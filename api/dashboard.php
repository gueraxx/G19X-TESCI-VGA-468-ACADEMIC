<?php
require_once __DIR__ . '/../config/database.php';

try {
    $db = getDB();

    // ============================================================
    // KPIs principales
    // ============================================================
    $totalCustomers = $db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
    $activeCustomers = $db->query("SELECT COUNT(*) FROM customers WHERE status='active'")->fetchColumn();
    $highChurn = $db->query("SELECT COUNT(*) FROM customers WHERE churn_risk >= 0.7")->fetchColumn();
    $totalRevenue = $db->query("SELECT COALESCE(SUM(amount),0) FROM transactions WHERE status='completed'")->fetchColumn();

    // ============================================================
    // Distribuciones
    // ============================================================
    $segments = $db->query("SELECT segment, COUNT(*) as count FROM customers GROUP BY segment")->fetchAll();
    $interactions = $db->query("SELECT type, COUNT(*) as count FROM interactions GROUP BY type")->fetchAll();

    // ============================================================
    // 🆕 Ingresos por mes (últimos 6 meses)
    // ============================================================
    $monthlyRevenue = $db->query("
        SELECT
            DATE_FORMAT(transaction_date, '%Y-%m') as month,
            DATE_FORMAT(transaction_date, '%b') as month_label,
            COUNT(*) as transactions,
            SUM(amount) as revenue
        FROM transactions
        WHERE status = 'completed'
          AND transaction_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')
        ORDER BY month ASC
    ")->fetchAll();

    // ============================================================
    // 🆕 Ingresos por canal
    // ============================================================
    $byChannel = $db->query("
        SELECT channel, COUNT(*) as count, COALESCE(SUM(amount),0) as revenue
        FROM transactions
        WHERE status = 'completed'
        GROUP BY channel
        ORDER BY revenue DESC
    ")->fetchAll();

    // ============================================================
    // 🆕 Top 5 clientes por LTV
    // ============================================================
    $topCustomers = $db->query("
        SELECT id, first_name, last_name, company, lifetime_value, segment
        FROM customers
        ORDER BY lifetime_value DESC
        LIMIT 5
    ")->fetchAll();

    // ============================================================
    // 🆕 Actividad reciente
    // ============================================================
    $recentTransactions = $db->query("
        SELECT
            t.id, t.amount, t.currency, t.channel, t.status, t.transaction_date,
            c.first_name, c.last_name, c.company
        FROM transactions t
        JOIN customers c ON c.id = t.customer_id
        WHERE t.status = 'completed'
        ORDER BY t.transaction_date DESC
        LIMIT 8
    ")->fetchAll();

    // Adaptar formato para el frontend
    $recentTransactionsFormatted = array_map(function($t) {
        return [
            'id' => $t['id'],
            'amount' => (float)$t['amount'],
            'currency' => $t['currency'],
            'channel' => $t['channel'],
            'transactionDate' => $t['transaction_date'],
            'customer' => [
                'firstName' => $t['first_name'],
                'lastName' => $t['last_name']
            ]
        ];
    }, $recentTransactions);

    // ============================================================
    // Respuesta
    // ============================================================
    jsonResponse([
        'kpis' => [
            'totalCustomers' => (int)$totalCustomers,
            'activeCustomers' => (int)$activeCustomers,
            'highChurnRisk' => (int)$highChurn,
            'totalRevenue' => (float)$totalRevenue
        ],
        'segments' => $segments,
        'interactions' => $interactions,
        'monthlyRevenue' => $monthlyRevenue,
        'byChannel' => $byChannel,
        'topCustomers' => $topCustomers,
        'recentTransactions' => $recentTransactionsFormatted
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}