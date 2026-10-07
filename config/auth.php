<?php
/**
 * Middleware de autenticación
 * Incluir al inicio de cada página protegida:
 *   require_once __DIR__ . '/../config/auth.php';
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica que el usuario esté autenticado
 * Si no, redirige al login
 */
function requireLogin() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: /customer360/login.php');
        exit;
    }

    // Expiración de sesión (8 horas)
    $timeout = 8 * 60 * 60;
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
        session_unset();
        session_destroy();
        header('Location: /customer360/login.php?expired=1');
        exit;
    }
}

/**
 * Verifica que el usuario tenga uno de los roles permitidos
 */
function requireRole(...$roles) {
    requireLogin();
    if (!in_array($_SESSION['user_role'] ?? '', $roles)) {
        header('HTTP/1.1 403 Forbidden');
        echo '<h1>403 — Acceso denegado</h1>';
        echo '<p>No tienes permisos para acceder a esta página.</p>';
        echo '<a href="/customer360/index.php">Volver al dashboard</a>';
        exit;
    }
}

/**
 * Devuelve el usuario actual
 */
function currentUser() {
    if (!isset($_SESSION['logged_in'])) return null;
    return [
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email'],
        'full_name' => $_SESSION['user_name'],
        'role' => $_SESSION['user_role']
    ];
}
/**
 * Verifica si el usuario actual tiene uno de los roles dados
 * (sin cortar la ejecución, solo devuelve true/false)
 */
function hasRole(...$roles) {
    if (!isset($_SESSION['logged_in'])) return false;
    return in_array($_SESSION['user_role'] ?? '', $roles);
}

/**
 * Devuelve el rol del usuario actual
 */
function currentRole() {
    return $_SESSION['user_role'] ?? 'viewer';
}

/**
 * Etiqueta legible del rol
 */
function roleLabel($role = null) {
    $role = $role ?? currentRole();
    return [
        'admin' => 'Administrador',
        'analyst' => 'Analista',
        'sales' => 'Ventas',
        'viewer' => 'Observador'
    ][$role] ?? 'Usuario';
}

/**
 * Color del badge del rol
 */
function roleBadgeClass($role = null) {
    $role = $role ?? currentRole();
    return 'badge-role-' . $role;
}
/**
 * Devuelve true si el usuario puede ver ciertos botones según su rol
 */
function canEdit() {
    return hasRole('admin', 'sales');
}

function canRecalculate() {
    return hasRole('admin', 'analyst');
}

function canManageUsers() {
    return hasRole('admin');
}