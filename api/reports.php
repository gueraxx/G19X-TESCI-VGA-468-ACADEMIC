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

    $type = $_GET['type'] ?? 'summary';
    $format = $_GET['format'] ?? 'json';

    // ============================================================
    // Reporte de clientes
    // ============================================================
    if ($type === 'customers') {
        $data = $db->query("
            SELECT
                c.id, c.first_name, c.last_name, c.email, c.company,
                c.industry, c.segment, c.lifetime_value, c.churn_risk, c.status
            FROM customers c
            ORDER BY c.lifetime_value DESC
        ")->fetchAll();

        if ($format === 'csv') {
            outputCSV($data, 'clientes_' . date('Y-m-d') . '.csv');
        }

        jsonResponse(['data' => $data]);
    }

    // ============================================================
    // Reporte de transacciones
    // ============================================================
    if ($type === 'transactions') {
        $data = $db->query("
            SELECT
                t.id, t.external_id, t.amount, t.currency, t.channel,
                t.status, t.transaction_date,
                c.first_name, c.last_name, c.company
            FROM transactions t
            JOIN customers c ON c.id = t.customer_id
            ORDER BY t.transaction_date DESC
        ")->fetchAll();

        if ($format === 'csv') {
            outputCSV($data, 'transacciones_' . date('Y-m-d') . '.csv');
        }

        jsonResponse(['data' => $data]);
    }

    // ============================================================
    // Reporte de churn
    // ============================================================
    if ($type === 'churn') {
        $data = $db->query("
            SELECT
                id, first_name, last_name, company, segment,
                lifetime_value, churn_risk,
                CASE
                    WHEN churn_risk >= 0.7 THEN 'ALTO'
                    WHEN churn_risk >= 0.4 THEN 'MEDIO'
                    ELSE 'BAJO'
                END as risk_level
            FROM customers
            WHERE churn_risk > 0
            ORDER BY churn_risk DESC
        ")->fetchAll();

        if ($format === 'csv') {
            outputCSV($data, 'churn_' . date('Y-m-d') . '.csv');
        }

        jsonResponse(['data' => $data]);
    }

    // ============================================================
    // Reporte resumen general (default)
    // ============================================================
    $totalRevenue = $db->query("SELECT COALESCE(SUM(amount),0) FROM transactions WHERE status='completed'")->fetchColumn();
    $totalCustomers = $db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
    $avgLTV = $db->query("SELECT COALESCE(AVG(lifetime_value),0) FROM customers")->fetchColumn();
    $highChurn = $db->query("SELECT COUNT(*) FROM customers WHERE churn_risk >= 0.7")->fetchColumn();

    $bySegment = $db->query("
        SELECT segment,
               COUNT(*) as count,
               COALESCE(SUM(lifetime_value),0) as revenue,
               COALESCE(AVG(churn_risk),0) as avg_churn
        FROM customers
        GROUP BY segment
        ORDER BY FIELD(segment, 'platinum', 'gold', 'silver', 'bronze')
    ")->fetchAll();

    $monthlyRevenue = $db->query("
        SELECT
            DATE_FORMAT(transaction_date, '%Y-%m') as month,
            DATE_FORMAT(transaction_date, '%b %Y') as month_label,
            COUNT(*) as transactions,
            SUM(amount) as revenue
        FROM transactions
        WHERE status='completed'
        GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')
        ORDER BY month ASC
        LIMIT 12
    ")->fetchAll();

    $byChannel = $db->query("
        SELECT channel, COUNT(*) as count, COALESCE(SUM(amount),0) as revenue
        FROM transactions
        WHERE status='completed'
        GROUP BY channel
        ORDER BY revenue DESC
    ")->fetchAll();

    jsonResponse([
        'kpis' => [
            'totalRevenue' => (float)$totalRevenue,
            'totalCustomers' => (int)$totalCustomers,
            'avgLTV' => (float)$avgLTV,
            'highChurn' => (int)$highChurn
        ],
        'bySegment' => $bySegment,
        'monthlyRevenue' => $monthlyRevenue,
        'byChannel' => $byChannel,
        'generatedAt' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    error_log('API Error: ' . $e->getMessage());
    jsonResponse(['error' => 'Error interno del servidor'], 500);
}

// ============================================================
// Helper: descargar CSV
// ============================================================
function outputCSV($data, $filename) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    // BOM UTF-8 para Excel
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    if (!empty($data)) {
        // Encabezados
        fputcsv($output, array_keys($data[0]));
        // Filas
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}