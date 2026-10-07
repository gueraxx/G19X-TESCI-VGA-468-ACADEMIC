<?php
require_once __DIR__ . '/../config/database.php';
$db = getDB();

try {
    // Perfil 360° de un cliente
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer) jsonResponse(['error' => 'Cliente no encontrado'], 404);

        $txs = $db->prepare("SELECT * FROM transactions WHERE customer_id = ? ORDER BY transaction_date DESC");
        $txs->execute([$id]);
        $transactions = $txs->fetchAll();

        $ints = $db->prepare("SELECT * FROM interactions WHERE customer_id = ? ORDER BY occurred_at DESC LIMIT 50");
        $ints->execute([$id]);
        $interactions = $ints->fetchAll();

        $totalSpent = array_sum(array_column($transactions, 'amount'));
        $avgTicket = count($transactions) ? $totalSpent / count($transactions) : 0;

        jsonResponse([
            'customer' => $customer,
            'transactions' => $transactions,
            'interactions' => $interactions,
            'metrics' => [
                'totalSpent' => (float)$totalSpent,
                'avgTicket' => round($avgTicket, 2),
                'transactionCount' => count($transactions),
                'interactionCount' => count($interactions)
            ]
        ]);
    }

    // Listar clientes
    $search = $_GET['search'] ?? '';
    $sql = "SELECT * FROM customers";
    $params = [];

    if ($search) {
        $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR company LIKE ?";
        $like = "%$search%";
        $params = [$like, $like, $like, $like];
    }

    $sql .= " ORDER BY created_at DESC LIMIT 100";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    jsonResponse(['data' => $stmt->fetchAll()]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}