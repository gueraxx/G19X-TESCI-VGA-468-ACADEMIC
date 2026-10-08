<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['logged_in'])) {
    jsonResponse(['error' => 'No autorizado'], 401);
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = getDB();

    // ============================================================
    // GET — Listar o ver un cliente
    // ============================================================
    if ($method === 'GET') {
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
        $segment = $_GET['segment'] ?? '';
        $status = $_GET['status'] ?? '';

        $sql = "SELECT * FROM customers WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR company LIKE ?)";
            $like = "%$search%";
            $params = array_merge($params, [$like, $like, $like, $like]);
        }

        if ($segment) {
            $sql .= " AND segment = ?";
            $params[] = $segment;
        }

        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC LIMIT 200";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        jsonResponse(['data' => $stmt->fetchAll()]);
    }

    // ============================================================
    // POST — Crear cliente (admin, sales)
    // ============================================================
    if ($method === 'POST') {
        if (!hasRole('admin', 'sales')) {
            jsonResponse(['error' => 'No tienes permisos para crear clientes'], 403);
        }

        $input = json_decode(file_get_contents('php://input'), true);

        // Validaciones
        $required = ['first_name', 'last_name', 'email'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                jsonResponse(['error' => "El campo '$field' es requerido"], 400);
            }
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            jsonResponse(['error' => 'Email inválido'], 400);
        }

        // ¿Email único?
        $stmt = $db->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->execute([$input['email']]);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'Ya existe un cliente con ese email'], 409);
        }

        // Generar external_id si no viene
        $externalId = $input['external_id'] ?? 'CRM-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $stmt = $db->prepare("
            INSERT INTO customers
            (external_id, first_name, last_name, email, phone, company, industry, country, city, segment, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $externalId,
            trim($input['first_name']),
            trim($input['last_name']),
            trim($input['email']),
            $input['phone'] ?? null,
            $input['company'] ?? null,
            $input['industry'] ?? null,
            $input['country'] ?? null,
            $input['city'] ?? null,
            $input['segment'] ?? 'bronze',
            $input['status'] ?? 'active'
        ]);

        $newId = $db->lastInsertId();

        jsonResponse([
            'ok' => true,
            'id' => $newId,
            'message' => 'Cliente creado correctamente'
        ], 201);
    }

    // ============================================================
    // PUT — Actualizar cliente (admin, sales)
    // ============================================================
    if ($method === 'PUT') {
        if (!hasRole('admin', 'sales')) {
            jsonResponse(['error' => 'No tienes permisos para editar clientes'], 403);
        }

        $id = (int)($_GET['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $input = json_decode(file_get_contents('php://input'), true);

        // Verificar que existe
        $stmt = $db->prepare("SELECT id, email FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch();
        if (!$current) jsonResponse(['error' => 'Cliente no encontrado'], 404);

        // Validar email único (si cambió)
        if (!empty($input['email']) && $input['email'] !== $current['email']) {
            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                jsonResponse(['error' => 'Email inválido'], 400);
            }
            $check = $db->prepare("SELECT id FROM customers WHERE email = ? AND id != ?");
            $check->execute([$input['email'], $id]);
            if ($check->fetch()) {
                jsonResponse(['error' => 'Ya existe otro cliente con ese email'], 409);
            }
        }

        // Actualizar solo los campos enviados
        $allowedFields = ['first_name', 'last_name', 'email', 'phone', 'company',
                          'industry', 'country', 'city', 'segment', 'status'];

        $updates = [];
        $values = [];

        foreach ($allowedFields as $field) {
            if (isset($input[$field])) {
                $updates[] = "$field = ?";
                $values[] = $input[$field];
            }
        }

        if (empty($updates)) {
            jsonResponse(['error' => 'No hay campos para actualizar'], 400);
        }

        $values[] = $id;

        $stmt = $db->prepare("UPDATE customers SET " . implode(', ', $updates) . " WHERE id = ?");
        $stmt->execute($values);

        jsonResponse(['ok' => true, 'message' => 'Cliente actualizado']);
    }

    // ============================================================
    // DELETE — Eliminar cliente (solo admin)
    // ============================================================
    if ($method === 'DELETE') {
        if (!hasRole('admin')) {
            jsonResponse(['error' => 'Solo los administradores pueden eliminar clientes'], 403);
        }

        $id = (int)($_GET['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $stmt = $db->prepare("SELECT id FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            jsonResponse(['error' => 'Cliente no encontrado'], 404);
        }

        // Soft delete: cambiar estado a 'blocked' en lugar de borrar
        $softDelete = ($_GET['soft'] ?? '1') === '1';

        if ($softDelete) {
            $db->prepare("UPDATE customers SET status = 'blocked' WHERE id = ?")->execute([$id]);
            jsonResponse(['ok' => true, 'message' => 'Cliente desactivado (soft delete)']);
        } else {
            // Eliminar definitivamente (cascade elimina transacciones e interacciones)
            $db->prepare("DELETE FROM customers WHERE id = ?")->execute([$id]);
            jsonResponse(['ok' => true, 'message' => 'Cliente eliminado permanentemente']);
        }
    }

    jsonResponse(['error' => 'Método no soportado'], 405);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}