<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    $db = getDB();

    // ============================================================
    // LOGIN
    // ============================================================
    if ($action === 'login') {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (!$email || !$password) {
            jsonResponse(['error' => 'Email y contraseña son requeridos'], 400);
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            // Delay para prevenir ataques de fuerza bruta
            usleep(300000);
            jsonResponse(['error' => 'Credenciales incorrectas'], 401);
        }

        // Actualizar último login
        $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

        // Crear sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();

        jsonResponse([
            'ok' => true,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'role' => $user['role']
            ]
        ], 200, 'Login exitoso');
    }

    // ============================================================
    // LOGOUT
    // ============================================================
    if ($action === 'logout') {
        session_unset();
        session_destroy();
        jsonResponse(['ok' => true], 200, 'Sesión cerrada');
    }

    // ============================================================
    // CHECK (verificar si está autenticado)
    // ============================================================
    if ($action === 'check') {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            jsonResponse([
                'authenticated' => true,
                'user' => [
                    'id' => $_SESSION['user_id'],
                    'email' => $_SESSION['user_email'],
                    'full_name' => $_SESSION['user_name'],
                    'role' => $_SESSION['user_role']
                ]
            ]);
        }
        jsonResponse(['authenticated' => false]);
    }

    // ============================================================
    // CAMBIAR CONTRASEÑA
    // ============================================================
    if ($action === 'change-password') {
        if (!isset($_SESSION['logged_in'])) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $currentPassword = $input['current_password'] ?? '';
        $newPassword = $input['new_password'] ?? '';

        if (strlen($newPassword) < 6) {
            jsonResponse(['error' => 'La nueva contraseña debe tener al menos 6 caracteres'], 400);
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!password_verify($currentPassword, $user['password_hash'])) {
            jsonResponse(['error' => 'Contraseña actual incorrecta'], 401);
        }

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
           ->execute([$newHash, $_SESSION['user_id']]);

        jsonResponse(['ok' => true], 200, 'Contraseña actualizada');
    }

    jsonResponse(['error' => 'Acción no válida'], 400);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}