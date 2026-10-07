<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

// Solo admin puede gestionar usuarios
requireRole('admin');

$action = $_GET['action'] ?? '';

try {
    $db = getDB();

    // LISTAR
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $users = $db->query("
            SELECT id, email, full_name, role, is_active, last_login, created_at
            FROM users
            ORDER BY created_at DESC
        ")->fetchAll();

        jsonResponse(['data' => $users]);
    }

    // CREAR
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$action) {
        $input = json_decode(file_get_contents('php://input'), true);

        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $fullName = trim($input['full_name'] ?? '');
        $role = $input['role'] ?? 'viewer';

        if (!$email || !$password || !$fullName) {
            jsonResponse(['error' => 'Todos los campos son requeridos'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(['error' => 'Email inválido'], 400);
        }

        if (strlen($password) < 6) {
            jsonResponse(['error' => 'Contraseña muy corta (mínimo 6 caracteres)'], 400);
        }

        if (!in_array($role, ['admin', 'analyst', 'sales', 'viewer'])) {
            jsonResponse(['error' => 'Rol inválido'], 400);
        }

        // ¿Ya existe el email?
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'Ya existe un usuario con ese email'], 409);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $db->prepare("
            INSERT INTO users (email, password_hash, full_name, role, is_active)
            VALUES (?, ?, ?, ?, 1)
        ")->execute([$email, $hash, $fullName, $role]);

        jsonResponse(['ok' => true, 'message' => 'Usuario creado'], 201);
    }

    // ACTUALIZAR
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = (int)($_GET['id'] ?? 0);
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $fullName = trim($input['full_name'] ?? '');
        $role = $input['role'] ?? 'viewer';
        $isActive = isset($input['is_active']) ? (int)$input['is_active'] : 1;
        $password = $input['password'] ?? '';

        // No permitir que se desactive a sí mismo
        if ($id === (int)$_SESSION['user_id'] && $isActive === 0) {
            jsonResponse(['error' => 'No puedes desactivar tu propio usuario'], 400);
        }

        if (!in_array($role, ['admin', 'analyst', 'sales', 'viewer'])) {
            jsonResponse(['error' => 'Rol inválido'], 400);
        }

        $sql = "UPDATE users SET full_name = ?, role = ?, is_active = ?";
        $params = [$fullName, $role, $isActive];

        if ($password) {
            if (strlen($password) < 6) {
                jsonResponse(['error' => 'Contraseña muy corta'], 400);
            }
            $sql .= ", password_hash = ?";
            $params[] = password_hash($password, PASSWORD_BCRYPT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $db->prepare($sql)->execute($params);

        jsonResponse(['ok' => true, 'message' => 'Usuario actualizado']);
    }

    // ELIMINAR
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        if ($id === (int)$_SESSION['user_id']) {
            jsonResponse(['error' => 'No puedes eliminar tu propio usuario'], 400);
        }

        $db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
        jsonResponse(['ok' => true, 'message' => 'Usuario eliminado']);
    }

    jsonResponse(['error' => 'Acción no válida'], 400);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}