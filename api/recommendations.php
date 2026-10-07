<?php
require_once __DIR__ . '/../config/database.php';
$db = getDB();

try {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

    $stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->execute([$id]);
    $customer = $stmt->fetch();

    if (!$customer) jsonResponse(['error' => 'Cliente no encontrado'], 404);

    $recommendations = [];

    if ($customer['churn_risk'] >= 0.6) {
        $recommendations[] = [
            'type' => 'retention',
            'product' => 'Plan de retención personalizado',
            'reason' => 'El cliente presenta alto riesgo de abandono. Se recomienda contacto proactivo.',
            'confidence' => 0.85
        ];
    }

    if (in_array($customer['segment'], ['gold', 'platinum'])) {
        $recommendations[] = [
            'type' => 'upsell',
            'product' => 'Plan Enterprise Premium',
            'reason' => 'Cliente de alto valor con potencial de escalar a un plan superior.',
            'confidence' => 0.75
        ];
    }

    if (in_array($customer['segment'], ['bronze', 'silver'])) {
        $recommendations[] = [
            'type' => 'cross-sell',
            'product' => 'Módulo de Analítica Avanzada',
            'reason' => 'Producto complementario que se ajusta a su perfil y presupuesto.',
            'confidence' => 0.65
        ];
    }

    jsonResponse([
        'recommendations' => $recommendations,
        'nextBestAction' => $customer['churn_risk'] >= 0.6
            ? 'Llamar al cliente en las próximas 48 horas'
            : 'Enviar propuesta comercial por email',
        'summary' => "Cliente {$customer['first_name']} {$customer['last_name']} ({$customer['segment']}) con LTV de \${$customer['lifetime_value']}"
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}