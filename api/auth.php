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
            // Delay anti fuerza bruta
            usleep(300000);
            jsonResponse(['error' => 'Credenciales incorrectas'], 401);
        }

        // Actualizar último login
        $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")
           ->execute([$user['id']]);

        // Crear sesión
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name']  = $user['full_name'];
        $_SESSION['user_role']  = $user['role'];
        $_SESSION['user_color'] = $user['avatar_color'] ?? '#4361ee'; // 🆕
        $_SESSION['user_icon']  = $user['avatar_icon'] ?? 'bi-person-fill'; // 🆕
        $_SESSION['logged_in']  = true;
        $_SESSION['login_time'] = time();

        jsonResponse([
            'ok' => true,
            'user' => [
                'id'        => $user['id'],
                'email'     => $user['email'],
                'full_name' => $user['full_name'],
                'role'      => $user['role']
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
    // CHECK
    // ============================================================
    if ($action === 'check') {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            jsonResponse([
                'authenticated' => true,
                'user' => [
                    'id'        => $_SESSION['user_id'],
                    'email'     => $_SESSION['user_email'],
                    'full_name' => $_SESSION['user_name'],
                    'role'      => $_SESSION['user_role'],
                    'color'     => $_SESSION['user_color'] ?? '#4361ee', // 🆕
                    'icon'      => $_SESSION['user_icon'] ?? 'bi-person-fill' // 🆕
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
        $newPassword     = $input['new_password'] ?? '';

        if (strlen($newPassword) < 6) {
            jsonResponse(['error' => 'La nueva contraseña debe tener al menos 6 caracteres'], 400);
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
            jsonResponse(['error' => 'Contraseña actual incorrecta'], 401);
        }

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
           ->execute([$newHash, $_SESSION['user_id']]);

        jsonResponse(['ok' => true], 200, 'Contraseña actualizada');
    }

    // ============================================================
    // ACTUALIZAR AVATAR
    // ============================================================
    if ($action === 'update-avatar') {
        if (!isset($_SESSION['logged_in'])) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $color = $input['color'] ?? '#4361ee';
        $icon  = $input['icon']  ?? 'bi-person-fill';

        // 🛡️ Listas cerradas de valores permitidos
        $coloresPermitidos = ['#4361ee', '#7209b7', '#10b981', '#ef4444', '#f59e0b', '#06b6d4', '#475569', '#ff6b6b'];
        $iconosPermitidos  = ['bi-person-fill', 'bi-briefcase-fill', 'bi-star-fill', 'bi-heart-fill', 'bi-lightning-fill', 'bi-rocket-fill'];

        // Validar contra las listas
        if (!in_array($color, $coloresPermitidos, true)) {
            jsonResponse(['error' => 'Color inválido'], 400);
        }
        if (!in_array($icon, $iconosPermitidos, true)) {
            jsonResponse(['error' => 'Ícono inválido'], 400);
        }

        $db->prepare("UPDATE users SET avatar_color = ?, avatar_icon = ? WHERE id = ?")
           ->execute([$color, $icon, $_SESSION['user_id']]);

        // Actualizar la sesión
        $_SESSION['user_color'] = $color;
        $_SESSION['user_icon']  = $icon;

        jsonResponse(['ok' => true, 'message' => 'Avatar actualizado']);
    }

    jsonResponse(['error' => 'Acción no válida'], 400);

} catch (Exception $e) {
    error_log('[api/auth.php] Error: ' . $e->getMessage());
    jsonResponse(['error' => 'Error interno del servidor'], 500);
}