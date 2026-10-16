<?php
session_start();

// ============================================================
// Validación de sesión
// ============================================================
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    jsonResponse(['error' => 'No autorizado'], 401);
}

try {
    $db = getDB();

    $id = (int)($_GET['id'] ?? 0);
    if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

    $stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->execute([$id]);
    $customer = $stmt->fetch();

    if (!$customer) jsonResponse(['error' => 'Cliente no encontrado'], 404);

    $recommendations = [];

    // ============================================================
    // Reglas de negocio para recomendaciones individuales
    // ============================================================

    // Retención: churn alto
    if ($customer['churn_risk'] >= 0.6) {
        $recommendations[] = [
            'type' => 'retention',
            'priority' => 'alta',
            'product' => 'Plan de retención personalizado',
            'reason' => 'El cliente presenta alto riesgo de abandono. Se recomienda contacto proactivo.',
            'confidence' => 0.85,
            'source' => 'rules'
        ];
    }

    // Upsell: gold/platinum
    if (in_array($customer['segment'], ['gold', 'platinum'])) {
        $recommendations[] = [
            'type' => 'upsell',
            'priority' => 'media',
            'product' => 'Plan Enterprise Premium',
            'reason' => 'Cliente de alto valor con potencial de escalar a un plan superior.',
            'confidence' => 0.75,
            'source' => 'rules'
        ];
    }

    // Cross-sell: bronze/silver
    if (in_array($customer['segment'], ['bronze', 'silver'])) {
        $recommendations[] = [
            'type' => 'cross-sell',
            'priority' => 'media',
            'product' => 'Módulo de Analítica Avanzada',
            'reason' => 'Producto complementario que se ajusta a su perfil y presupuesto.',
            'confidence' => 0.65,
            'source' => 'rules'
        ];
    }

    // ============================================================
    // Respuesta
    // ============================================================
    jsonResponse([
        'recommendations' => $recommendations,
        'nextBestAction' => $customer['churn_risk'] >= 0.6
            ? 'Llamar al cliente en las próximas 48 horas'
            : 'Enviar propuesta comercial por email',
        'summary' => "Cliente {$customer['first_name']} {$customer['last_name']} ({$customer['segment']}) con LTV de \${$customer['lifetime_value']}"
    ]);

} catch (Exception $e) {
    error_log('API Error: ' . $e->getMessage());
    jsonResponse(['error' => 'Error interno del servidor'], 500);
}