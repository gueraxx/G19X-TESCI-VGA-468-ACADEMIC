<?php
require_once __DIR__ . '/../config/database.php';

try {
    $db = getDB();
    $notifications = [];

    // ============================================================
    // 1. Clientes con churn alto (>= 0.7)
    // ============================================================
    $highChurn = $db->query("
        SELECT id, first_name, last_name, company, churn_risk, lifetime_value
        FROM customers
        WHERE churn_risk >= 0.7 AND status = 'active'
        ORDER BY churn_risk DESC
        LIMIT 5
    ")->fetchAll();

    foreach ($highChurn as $c) {
        $notifications[] = [
            'id' => 'churn_' . $c['id'],
            'type' => 'danger',
            'icon' => 'bi-exclamation-triangle-fill',
            'title' => 'Cliente en riesgo alto',
            'message' => "{$c['first_name']} {$c['last_name']} (" . ($c['company'] ?: 'Sin empresa') . ") tiene " . round($c['churn_risk'] * 100) . "% de riesgo de abandono.",
            'link' => "/customer360/customer-detail.php?id={$c['id']}",
            'time' => 'Reciente',
            'priority' => 1
        ];
    }

    // ============================================================
    // 2. Transacciones recientes (últimas 48 horas)
    // ============================================================
    $recentTx = $db->query("
        SELECT t.id, t.amount, t.transaction_date, t.customer_id,
               c.first_name, c.last_name
        FROM transactions t
        JOIN customers c ON c.id = t.customer_id
        WHERE t.transaction_date >= DATE_SUB(NOW(), INTERVAL 48 HOUR)
          AND t.status = 'completed'
        ORDER BY t.transaction_date DESC
        LIMIT 5
    ")->fetchAll();

    foreach ($recentTx as $t) {
        $notifications[] = [
            'id' => 'tx_' . $t['id'],
            'type' => 'success',
            'icon' => 'bi-cash-coin',
            'title' => 'Nueva transacción',
            'message' => "{$t['first_name']} {$t['last_name']} realizó una compra de $" . number_format($t['amount'], 2),
            'link' => "/customer360/customer-detail.php?id={$t['customer_id']}",
            'time' => formatTimeAgo($t['transaction_date']),
            'priority' => 2
        ];
    }

    // ============================================================
    // 3. Clientes nuevos (últimos 7 días)
    // ============================================================
    $newCustomers = $db->query("
        SELECT id, first_name, last_name, company, created_at
        FROM customers
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ORDER BY created_at DESC
        LIMIT 3
    ")->fetchAll();

    foreach ($newCustomers as $c) {
        $notifications[] = [
            'id' => 'new_' . $c['id'],
            'type' => 'info',
            'icon' => 'bi-person-plus-fill',
            'title' => 'Cliente nuevo',
            'message' => "Se registró {$c['first_name']} {$c['last_name']} (" . ($c['company'] ?: 'Sin empresa') . ")",
            'link' => "/customer360/customer-detail.php?id={$c['id']}",
            'time' => formatTimeAgo($c['created_at']),
            'priority' => 3
        ];
    }

    // ============================================================
    // 4. Interacciones sin resolver (tickets negativos)
    // ============================================================
    $negativeInteractions = $db->query("
        SELECT i.id, i.subject, i.customer_id, i.occurred_at,
               c.first_name, c.last_name
        FROM interactions i
        JOIN customers c ON c.id = i.customer_id
        WHERE i.sentiment = 'negative'
          AND i.type = 'ticket'
        ORDER BY i.occurred_at DESC
        LIMIT 3
    ")->fetchAll();

    foreach ($negativeInteractions as $i) {
        $notifications[] = [
            'id' => 'ticket_' . $i['id'],
            'type' => 'warning',
            'icon' => 'bi-ticket-detailed-fill',
            'title' => 'Ticket con sentimiento negativo',
            'message' => "{$i['first_name']} {$i['last_name']}: " . ($i['subject'] ?: 'Sin asunto'),
            'link' => "/customer360/customer-detail.php?id={$i['customer_id']}",
            'time' => formatTimeAgo($i['occurred_at']),
            'priority' => 2
        ];
    }

    // ============================================================
    // Ordenar por prioridad y fecha
    // ============================================================
    usort($notifications, function($a, $b) {
        return $a['priority'] - $b['priority'];
    });

    // Limitar a las 15 más importantes
    $notifications = array_slice($notifications, 0, 15);

    // Contadores
    $unread = count($notifications);
    $byType = [
        'danger' => count(array_filter($notifications, fn($n) => $n['type'] === 'danger')),
        'warning' => count(array_filter($notifications, fn($n) => $n['type'] === 'warning')),
        'success' => count(array_filter($notifications, fn($n) => $n['type'] === 'success')),
        'info' => count(array_filter($notifications, fn($n) => $n['type'] === 'info'))
    ];

    jsonResponse([
        'total' => $unread,
        'byType' => $byType,
        'notifications' => $notifications,
        'generatedAt' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}

// ============================================================
// Helper: tiempo relativo ("hace 2 horas", "ayer", etc)
// ============================================================
function formatTimeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return 'Hace unos segundos';
    if ($diff < 3600) return 'Hace ' . floor($diff / 60) . ' min';
    if ($diff < 86400) return 'Hace ' . floor($diff / 3600) . ' h';
    if ($diff < 172800) return 'Ayer';
    if ($diff < 604800) return 'Hace ' . floor($diff / 86400) . ' días';

    return date('d M', $timestamp);
}