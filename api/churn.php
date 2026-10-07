<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';
$db = getDB();
// Cualquiera autenticado puede VER, solo admin/analyst pueden recalcular
$action = $_GET['action'] ?? '';
if ($action === 'recalculate' && !hasRole('admin', 'analyst')) {
    jsonResponse(['error' => 'No tienes permisos para recalcular churn'], 403);
}

try {
    // Recalcular churn de todos los clientes
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'recalculate') {
        $customers = $db->query("SELECT id FROM customers")->fetchAll();
        $count = 0;

        foreach ($customers as $c) {
            $stmt = $db->prepare("
                SELECT MAX(transaction_date) as last_tx, COUNT(*) as freq, COALESCE(AVG(amount),0) as avg_ticket
                FROM transactions
                WHERE customer_id = ? AND status = 'completed'
            ");
            $stmt->execute([$c['id']]);
            $stats = $stmt->fetch();

            $daysSince = $stats['last_tx'] ? floor((time() - strtotime($stats['last_tx'])) / 86400) : 999;
            $freq = (int)$stats['freq'];
            $avg = (float)$stats['avg_ticket'];

            $score = 0;
            if ($daysSince > 90) $score += 0.5;
            elseif ($daysSince > 60) $score += 0.35;
            elseif ($daysSince > 30) $score += 0.2;

            if ($freq < 3) $score += 0.25;
            elseif ($freq < 10) $score += 0.1;

            if ($avg < 50) $score += 0.15;
            $score = min($score, 1);

            $db->prepare("UPDATE customers SET churn_risk = ? WHERE id = ?")
               ->execute([$score, $c['id']]);
            $count++;
        }
        jsonResponse(['processed' => $count]);
    }

    // Listar clientes con riesgo
    $stmt = $db->query("SELECT * FROM customers WHERE churn_risk >= 0.3 ORDER BY churn_risk DESC LIMIT 100");
    $customers = $stmt->fetchAll();

    foreach ($customers as &$c) {
        $c['risk_level'] = $c['churn_risk'] >= 0.7 ? 'high' : ($c['churn_risk'] >= 0.4 ? 'medium' : 'low');
    }

    jsonResponse(['data' => $customers]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}