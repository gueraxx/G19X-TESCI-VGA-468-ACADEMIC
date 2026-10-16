<?php
session_start();

// ============================================================
// Validación de sesión y permisos
// ============================================================
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

// Verificar sesión activa
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    jsonResponse(['error' => 'No autorizado'], 401);
}

// Cualquiera autenticado puede VER, solo admin/analyst pueden recalcular
$action = $_GET['action'] ?? '';
if ($action === 'recalculate' && !hasRole('admin', 'analyst')) {
    jsonResponse(['error' => 'No tienes permisos para recalcular churn'], 403);
}

try {
    $db = getDB();

    // ============================================================
    // POST ?action=recalculate — Recalcular churn (solo admin/analyst)
    // ============================================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'recalculate') {
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

            // Score heurístico
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

    // ============================================================
    // GET — Listar clientes con riesgo
    // ============================================================
    $stmt = $db->query("
        SELECT id, first_name, last_name, email, company, industry, 
               country, city, segment, lifetime_value, churn_risk, status
        FROM customers
        WHERE churn_risk >= 0.3
        ORDER BY churn_risk DESC
        LIMIT 100
    ");
    $customers = $stmt->fetchAll();

    // Agregar nivel de riesgo
    foreach ($customers as &$c) {
        $r = (float)$c['churn_risk'];
        $c['risk_level'] = $r >= 0.7 ? 'high' : ($r >= 0.4 ? 'medium' : 'low');
    }
    unset($c);

    jsonResponse(['data' => $customers]);

} catch (Exception $e) {
    error_log('API Error: ' . $e->getMessage());
    jsonResponse(['error' => 'Error interno del servidor'], 500);
}