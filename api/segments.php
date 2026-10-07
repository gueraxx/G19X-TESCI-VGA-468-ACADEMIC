<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

try {
    $db = getDB();
$action = $_GET['action'] ?? '';
if ($action === 'recalculate' && !hasRole('admin', 'analyst')) {
    jsonResponse(['error' => 'No tienes permisos para recalcular segmentos'], 403);
}
    // POST ?action=recalculate → recalcular todos los segmentos
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'recalculate') {
        $customers = $db->query("SELECT id FROM customers")->fetchAll();

        foreach ($customers as $c) {
            $stmt = $db->prepare("SELECT COALESCE(SUM(amount),0) FROM transactions WHERE customer_id = ? AND status='completed'");
            $stmt->execute([$c['id']]);
            $total = (float)$stmt->fetchColumn();

            $segment = 'bronze';
            if ($total >= 50000) $segment = 'platinum';
            elseif ($total >= 20000) $segment = 'gold';
            elseif ($total >= 5000) $segment = 'silver';

            $db->prepare("UPDATE customers SET segment = ?, lifetime_value = ? WHERE id = ?")
               ->execute([$segment, $total, $c['id']]);
        }
        jsonResponse(['ok' => true, 'recalculated' => count($customers)]);
    }

    // GET → estadísticas de segmentos
    $segments = $db->query("
        SELECT
            segment,
            COUNT(*) as count,
            COALESCE(AVG(lifetime_value), 0) as avg_ltv,
            COALESCE(SUM(lifetime_value), 0) as total_ltv,
            COALESCE(AVG(churn_risk), 0) as avg_churn
        FROM customers
        GROUP BY segment
    ")->fetchAll();

    // Por industria
    $industries = $db->query("
        SELECT industry, COUNT(*) as count
        FROM customers
        WHERE industry IS NOT NULL AND industry != ''
        GROUP BY industry
        ORDER BY count DESC
        LIMIT 10
    ")->fetchAll();

    // Top clientes por LTV
    $topCustomers = $db->query("
        SELECT id, first_name, last_name, company, segment, lifetime_value, churn_risk
        FROM customers
        ORDER BY lifetime_value DESC
        LIMIT 10
    ")->fetchAll();

    // Distribución por país
    $countries = $db->query("
        SELECT country, COUNT(*) as count
        FROM customers
        WHERE country IS NOT NULL AND country != ''
        GROUP BY country
        ORDER BY count DESC
        LIMIT 10
    ")->fetchAll();

    jsonResponse([
        'segments' => $segments,
        'industries' => $industries,
        'topCustomers' => $topCustomers,
        'countries' => $countries
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}