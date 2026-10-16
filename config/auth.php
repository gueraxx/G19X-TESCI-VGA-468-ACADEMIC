<?php
/**
 * Middleware de autenticación — Customer 360
 * 
 * Uso al inicio de cada página protegida:
 *   require_once __DIR__ . '/config/auth.php';
 *   requireLogin();
 * 
 * Uso en APIs:
 *   require_once __DIR__ . '/../config/auth.php';
 *   if (!isset($_SESSION['logged_in'])) {
 *       jsonResponse(['error' => 'No autorizado'], 401);
 *   }
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// BASE PATH dinámico (para rutas relativas)
// ============================================================

/**
 * Devuelve el base path del proyecto.
 * 
 * Ejemplos:
 *   http://localhost/customer360/index.php  → '/customer360'
 *   http://localhost/index.php              → ''
 *   http://midominio.com/G19X-TESCI/index.php → '/G19X-TESCI'
 * 
 * @return string
 */
function basePath() {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = str_replace('\\', '/', dirname($script));
    return ($dir === '/' || $dir === '.') ? '' : $dir;
}

// ============================================================
// VALIDACIÓN DE SESIÓN
// ============================================================

/**
 * Verifica que el usuario esté autenticado.
 * Si no, redirige al login.
 */
function requireLogin() {
    // No autenticado
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ' . basePath() . '/login.php');
        exit;
    }

    // Sesión expirada (8 horas)
    $timeout = 8 * 60 * 60;
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
        session_unset();
        session_destroy();
        header('Location: ' . basePath() . '/login.php?expired=1');
        exit;
    }
}

/**
 * Verifica que el usuario tenga uno de los roles permitidos.
 * Si no, muestra página 403.
 * 
 * Uso:
 *   requireRole('admin');
 *   requireRole('admin', 'analyst');
 */
function requireRole(...$roles) {
    requireLogin();

    if (!in_array($_SESSION['user_role'] ?? '', $roles)) {
        http_response_code(403);
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8">';
        echo '<title>403 — Acceso denegado</title>';
        echo '<style>body{font-family:system-ui,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f4f6f9;color:#1a1a2e;}';
        echo '.box{text-align:center;padding:40px;background:white;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,0.1);max-width:500px;}';
        echo 'h1{font-size:4rem;margin:0;color:#ef476f;}';
        echo 'p{color:#64748b;margin:16px 0;}';
        echo 'a{display:inline-block;margin-top:16px;padding:12px 24px;background:#4361ee;color:white;text-decoration:none;border-radius:10px;font-weight:600;}';
        echo 'a:hover{background:#3a0ca3;}</style></head><body>';
        echo '<div class="box">';
        echo '<h1>403</h1>';
        echo '<h2>Acceso denegado</h2>';
        echo '<p>No tienes permisos para acceder a esta página.</p>';
        echo '<a href="' . basePath() . '/index.php">Volver al dashboard</a>';
        echo '</div></body></html>';
        exit;
    }
}

// ============================================================
// INFORMACIÓN DEL USUARIO ACTUAL
// ============================================================

/**
 * Devuelve el usuario actual (array) o null si no hay sesión.
 */
function currentUser() {
    if (!isset($_SESSION['logged_in'])) return null;
    return [
        'id'        => $_SESSION['user_id'],
        'email'     => $_SESSION['user_email'],
        'full_name' => $_SESSION['user_name'],
        'role'      => $_SESSION['user_role']
    ];
}

/**
 * Devuelve el rol del usuario actual.
 * Por defecto 'viewer' si no hay sesión.
 */
function currentRole() {
    return $_SESSION['user_role'] ?? 'viewer';
}

// ============================================================
// HELPERS DE PERMISOS
// ============================================================

/**
 * Verifica si el usuario actual tiene uno de los roles dados.
 * NO corta la ejecución, solo devuelve true/false.
 * 
 * Uso:
 *   if (hasRole('admin')) { ... }
 *   if (hasRole('admin', 'analyst')) { ... }
 */
function hasRole(...$roles) {
    if (!isset($_SESSION['logged_in'])) return false;
    return in_array($_SESSION['user_role'] ?? '', $roles);
}

/**
 * ¿Puede editar? (crear/editar clientes) → admin, sales
 */
function canEdit() {
    return hasRole('admin', 'sales');
}

/**
 * ¿Puede recalcular? (churn, segmentos) → admin, analyst
 */
function canRecalculate() {
    return hasRole('admin', 'analyst');
}

/**
 * ¿Puede gestionar usuarios? → admin
 */
function canManageUsers() {
    return hasRole('admin');
}

// ============================================================
// HELPERS DE PRESENTACIÓN (para vistas)
// ============================================================

/**
 * Etiqueta legible del rol.
 */
function roleLabel($role = null) {
    $role = $role ?? currentRole();
    return [
        'admin'   => 'Administrador',
        'analyst' => 'Analista',
        'sales'   => 'Ventas',
        'viewer'  => 'Observador'
    ][$role] ?? 'Usuario';
}

/**
 * Clase CSS del badge de rol.
 */
function roleBadgeClass($role = null) {
    $role = $role ?? currentRole();
    return 'badge-role-' . $role;
}