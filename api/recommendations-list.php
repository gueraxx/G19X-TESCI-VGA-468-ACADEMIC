<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/ai_cache.php';
if (!isset($_SESSION['logged_in'])) {
    jsonResponse(['error' => 'No autorizado'], 401);
}

// ============================================================
// CONFIGURACIÓN DE GROQ
// ============================================================
// 💡 OPCIÓN A: Poner la clave directamente aquí (rápido pero NO seguro)
// $groqApiKey = 'gsk_TU_CLAVE_AQUI';

// 💡 OPCIÓN B (RECOMENDADA): Leer desde archivo protegido
if (file_exists(__DIR__ . '/../config/ai.local.php')) {
    $aiConfig = require __DIR__ . '/../config/ai.local.php';
    $groqApiKey = $aiConfig['groq_api_key'] ?? '';
    $modelo = $aiConfig['groq_model'] ?? 'llama-3.3-70b-versatile';
} else {
    // Sin archivo, la IA queda desactivada → solo reglas de negocio
    $groqApiKey = '';
    $modelo = 'llama-3.3-70b-versatile';
}

$groqApiUrl = 'https://api.groq.com/openai/v1/chat/completions';
$usarIA = !empty($groqApiKey);

// ============================================================
// FUNCIONES AUXILIARES
// ============================================================

/**
 * Genera recomendaciones con reglas de negocio (fallback)
 */
function generarRecomendacionesConReglas($c, $type) {
    $recs = [];

    // Retención: churn alto
    if ($c['churn_risk'] >= 0.6) {
        $recs[] = [
            'type' => 'retention',
            'priority' => 'alta',
            'product' => 'Plan de retención personalizado',
            'reason' => 'Alto riesgo de abandono detectado (' . round($c['churn_risk'] * 100) . '%). Contactar en las próximas 48 hrs.',
            'confidence' => 0.85,
            'source' => 'rules'
        ];
    }

    // Upsell: gold/platinum con buen LTV
    if (in_array($c['segment'], ['gold', 'platinum']) && $c['churn_risk'] < 0.4) {
        $recs[] = [
            'type' => 'upsell',
            'priority' => 'media',
            'product' => 'Plan Enterprise Premium',
            'reason' => 'Cliente de alto valor con bajo riesgo. Ofrecer upgrade con descuento anual.',
            'confidence' => 0.75,
            'source' => 'rules'
        ];
    }

    // Cross-sell: bronze/silver
    if (in_array($c['segment'], ['bronze', 'silver'])) {
        $recs[] = [
            'type' => 'cross-sell',
            'priority' => 'media',
            'product' => 'Módulo de Analítica Avanzada',
            'reason' => 'Perfil compatible con producto complementario de bajo costo.',
            'confidence' => 0.65,
            'source' => 'rules'
        ];
    }

    // Cross-sell adicional: clientes con buen historial
    if ($c['lifetime_value'] > 10000 && $c['churn_risk'] < 0.5) {
        $recs[] = [
            'type' => 'cross-sell',
            'priority' => 'baja',
            'product' => 'Servicio de Soporte 24/7',
            'reason' => 'Cliente activo con buena rentabilidad. Ampliar servicios.',
            'confidence' => 0.7,
            'source' => 'rules'
        ];
    }

    if ($type !== 'all') {
        $recs = array_filter($recs, fn($r) => $r['type'] === $type);
    }

    return array_values($recs);
}

/**
 * Genera recomendaciones con Groq (IA)
 */
function generarRecomendacionesConIA($c, $type, $apiKey, $apiUrl, $modelo) {
    $prompt = "Eres un experto en ventas B2B y retención de clientes.
Analiza este perfil de cliente y genera UNA recomendación personalizada y accionable.

DATOS DEL CLIENTE:
- Nombre: {$c['first_name']} {$c['last_name']}
- Empresa: {$c['company']}
- Segmento: {$c['segment']}
- Valor de vida (LTV): \${$c['lifetime_value']}
- Riesgo de abandono (Churn): {$c['churn_risk']}

REGLAS:
- Si el churn es alto (>= 0.6), prioriza RETENCIÓN.
- Si es cliente de alto valor (gold/platinum) con bajo churn, sugiere UPSELL.
- Si es cliente bronze/silver, sugiere CROSS-SELL.
- El campo 'type' debe ser exactamente: 'upsell', 'cross-sell' o 'retention'.";

    if ($type !== 'all') {
        $prompt .= "\n- IMPORTANTE: el tipo DEBE ser '{$type}'.";
    }

    $prompt .= "\n\nDevuelve SOLO un objeto JSON con esta estructura exacta (sin texto adicional):
{
  \"type\": \"upsell|cross-sell|retention\",
  \"priority\": \"alta|media|baja\",
  \"product\": \"Nombre del producto o servicio\",
  \"reason\": \"Explicación breve y convincente (máx 2 frases)\",
  \"confidence\": 0.0
}";

    $data = [
        'model' => $modelo,
        'messages' => [
            ['role' => 'system', 'content' => 'Eres un asistente experto en ventas B2B. Respondes SIEMPRE en JSON válido, sin texto adicional ni markdown.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.5,
        'response_format' => ['type' => 'json_object'],
        'max_tokens' => 400
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        error_log("[IA] Error curl: $curlError");
        return null;
    }

    if ($httpCode !== 200) {
        error_log("[IA] HTTP $httpCode: $response");
        return null;
    }

    $responseData = json_decode($response, true);
    $contenido = $responseData['choices'][0]['message']['content'] ?? null;

    if (!$contenido) {
        error_log("[IA] Respuesta sin contenido");
        return null;
    }

    $iaRec = json_decode($contenido, true);

    if (!$iaRec || !isset($iaRec['type'])) {
        error_log("[IA] JSON inválido: $contenido");
        return null;
    }

    // Validar y normalizar
    $iaRec['confidence'] = (float)($iaRec['confidence'] ?? 0.7);
    $iaRec['priority'] = $iaRec['priority'] ?? 'media';
    $iaRec['source'] = 'ai';

    return [$iaRec];
}

// ============================================================
// ENDPOINT PRINCIPAL
// ============================================================
try {
    $db = getDB();

    $limit = (int)($_GET['limit'] ?? 20);
    $type = $_GET['type'] ?? 'all';
    $segment = $_GET['segment'] ?? '';
    $forceRules = isset($_GET['rules']) && $_GET['rules'] === '1';

    // Traer clientes
    $sql = "SELECT id, first_name, last_name, company, segment, lifetime_value, churn_risk
            FROM customers
            WHERE status = 'active'";

    $params = [];
    if ($segment) {
        $sql .= " AND segment = ?";
        $params[] = $segment;
    }

    $sql .= " ORDER BY churn_risk DESC, lifetime_value DESC LIMIT " . (int)$limit;

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $customers = $stmt->fetchAll();

    // ============================================================
    // Generar recomendaciones (IA con fallback a reglas)
    // ============================================================
    $recommendations = [];
    $iaUsada = 0;
    $reglasUsadas = 0;
    $cacheHits = 0; 

    foreach ($customers as $c) {
        $recs = null;

        // Intentar con IA primero (si está configurada)
        if ($usarIA && !$forceRules) {
    // Generar clave de caché única por cliente + tipo + valores
    $cacheKey = 'rec_' . md5(
        $c['id'] . '|' .
        $c['churn_risk'] . '|' .
        $c['segment'] . '|' .
        $c['lifetime_value'] . '|' .
        $type . '|' .
        $modelo
    );

    // Intentar leer de caché
    $cached = getAICache($cacheKey);

    if ($cached !== null) {
        $recs = $cached;
        $iaUsada++;
        $cacheHits++;
    } else {
        // No hay caché, llamar a la IA
        $recs = generarRecomendacionesConIA($c, $type, $groqApiKey, $groqApiUrl, $modelo);

        if ($recs) {
            setAICache($cacheKey, $recs, $modelo, 24);
            $iaUsada++;
        }
    }
}

        // Si la IA falló o no está configurada, usar reglas
        if ($recs === null) {
            $recs = generarRecomendacionesConReglas($c, $type);
            $reglasUsadas++;
        }

        if (!empty($recs)) {
            $recommendations[] = [
                'customer' => [
                    'id' => $c['id'],
                    'name' => $c['first_name'] . ' ' . $c['last_name'],
                    'company' => $c['company'],
                    'segment' => $c['segment'],
                    'lifetime_value' => (float)$c['lifetime_value'],
                    'churn_risk' => (float)$c['churn_risk']
                ],
                'recommendations' => $recs
            ];
        }
    }

    // ============================================================
    // Métricas resumen
    // ============================================================
    $allRecs = [];
    foreach ($recommendations as $r) {
        $allRecs = array_merge($allRecs, $r['recommendations']);
    }

    $summary = [
        'totalRecommendations' => count($allRecs),
        'totalCustomers' => count($recommendations),
        'iaEnabled' => $usarIA,
        'iaUsed' => $iaUsada,
        'rulesUsed' => $reglasUsadas,
        'cacheHits' => $cacheHits,      
    'cacheEnabled' => true,         
        'modelo' => $usarIA ? $modelo : 'rules-only',
        'byType' => [
            'upsell' => count(array_filter($allRecs, fn($r) => $r['type'] === 'upsell')),
            'cross-sell' => count(array_filter($allRecs, fn($r) => $r['type'] === 'cross-sell')),
            'retention' => count(array_filter($allRecs, fn($r) => $r['type'] === 'retention'))
        ]
    ];

    jsonResponse([
        'summary' => $summary,
        'recommendations' => $recommendations
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}