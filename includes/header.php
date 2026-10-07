<?php
// ============================================================
// Cargar configuración de autenticación ANTES de usar hasRole()
// ============================================================
if (!function_exists('hasRole')) {
    require_once __DIR__ . '/../config/auth.php';
}

$pageTitle = $pageTitle ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer 360 — <?= $pageTitle ?></title>

    <!-- ✅ Aplicar tema ANTES de cargar CSS (evita flash blanco) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/customer360/assets/css/style.css?v=100" rel="stylesheet">
    <link href="/customer360/assets/css/print.css?v=1" rel="stylesheet" media="print">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body data-user-role="<?= htmlspecialchars($_SESSION['user_role'] ?? 'viewer') ?>">

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <a href="/customer360/bienvenida.php" class="sidebar-logo text-decoration-none">
        <div class="logo-icon"><i class="bi bi-people-fill"></i></div>
        <div>
            <h4>Customer 360</h4>
            <small>PluriOne Platform</small>
        </div>
    </a>

    <ul class="sidebar-nav">
    <li class="nav-section">Principal</li>
    <li>
        <a href="/customer360/bienvenida.php" class="<?= ($pageTitle ?? '') === 'Bienvenida' ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i> Inicio
        </a>
    </li>
    <li>
        <a href="/customer360/index.php" class="<?= ($pageTitle ?? '') === 'Dashboard' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="/customer360/customers.php" class="<?= ($pageTitle ?? '') === 'Clientes' ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Clientes
        </a>
    </li>

    <?php if (hasRole('admin', 'analyst')): ?>
    <li>
        <a href="/customer360/churn.php" class="<?= ($pageTitle ?? '') === 'Churn' ? 'active' : '' ?>">
            <i class="bi bi-graph-down-arrow"></i> Churn
        </a>
    </li>
    <?php endif; ?>

    <li class="nav-section">Análisis</li>

    <?php if (hasRole('admin', 'analyst')): ?>
    <li>
        <a href="/customer360/segmentos.php" class="<?= ($pageTitle ?? '') === 'Segmentos' ? 'active' : '' ?>">
            <i class="bi bi-pie-chart"></i> Segmentos
        </a>
    </li>
    <?php endif; ?>

    <li>
        <a href="/customer360/recomendaciones.php" class="<?= ($pageTitle ?? '') === 'Recomendaciones' ? 'active' : '' ?>">
            <i class="bi bi-lightbulb"></i> Recomendaciones
        </a>
    </li>

    <li>
        <a href="/customer360/reportes.php" class="<?= ($pageTitle ?? '') === 'Reportes' ? 'active' : '' ?>">
            <i class="bi bi-bar-chart"></i> Reportes
        </a>
    </li>

    <?php if (hasRole('admin')): ?>
    <li class="nav-section">Administración</li>
    <li>
        <a href="/customer360/usuarios.php" class="<?= ($pageTitle ?? '') === 'Usuarios' ? 'active' : '' ?>">
            <i class="bi bi-person-badge"></i> Usuarios
        </a>
    </li>
    <?php endif; ?>
</ul>
</aside>

<!-- CONTENIDO PRINCIPAL -->
<div class="main-content">
    <div class="topbar">
        <div>
            <h1><?= $pageTitle ?? 'Dashboard' ?></h1>
            <div class="breadcrumb-text">
                <i class="bi bi-house-door"></i> Inicio / <?= $pageTitle ?? 'Dashboard' ?>
            </div>
        </div>
       <div class="topbar-actions">
    <button class="btn-icon" id="themeToggle" title="Cambiar tema">
        <i class="bi bi-moon-stars" id="themeIcon"></i>
    </button>
    <button class="btn-icon" onclick="location.reload()" title="Recargar">
        <i class="bi bi-arrow-clockwise"></i>
    </button>

    <!-- 🔔 Notificaciones -->
    <div class="notification-wrapper" id="notifWrapper">
        <button class="btn-icon" id="notifToggle" title="Notificaciones">
            <i class="bi bi-bell"></i>
            <span class="notif-badge" id="notifBadge" style="display: none;">0</span>
        </button>

        <div class="notification-dropdown" id="notifDropdown">
            <div class="notif-header">
                <div>
                    <strong>Notificaciones</strong>
                    <span class="notif-count" id="notifCount">0</span>
                </div>
                <button class="notif-mark-read" onclick="markAllRead()">Marcar todas leídas</button>
            </div>
            <div class="notif-list" id="notifList">
                <div class="notif-loading">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                </div>
            </div>
            <div class="notif-footer">
                <a href="/customer360/customers.php">Ver todos los clientes</a>
            </div>
        </div>
    </div>

    <!-- Menú de usuario -->
<div class="user-menu-wrapper" id="userMenuWrapper">
    <div class="user-avatar" id="userAvatar" title="<?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>">
        <?php
            $name = $_SESSION['user_name'] ?? 'AD';
            $initials = implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $name), 0, 2)));
            echo strtoupper($initials);
        ?>
    </div>
<div>
    <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?></strong>
    <div class="small text-muted"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></div>
    <span class="badge-role <?= roleBadgeClass() ?>">
        <?= roleLabel() ?>
    </span>
</div>
    <div class="user-menu-dropdown" id="userMenuDropdown">
        <div class="user-menu-header">
            <div class="user-menu-avatar">
                <?= strtoupper($initials) ?>
            </div>
            <div>
                <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?></strong>
                <div class="small text-muted"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></div>
                <span class="badge-role badge-role-<?= $_SESSION['user_role'] ?? 'viewer' ?>">
                    <?= ucfirst($_SESSION['user_role'] ?? 'viewer') ?>
                </span>
            </div>
        </div>

        <div class="user-menu-list">
            <a href="#" class="user-menu-item" onclick="openChangePassword(event)">
                <i class="bi bi-key"></i> Cambiar contraseña
            </a>
            <a href="#" class="user-menu-item" onclick="openThemeFromMenu(event)">
                <i class="bi bi-palette"></i> Cambiar tema
            </a>
            <div class="user-menu-divider"></div>
            <a href="#" class="user-menu-item text-danger" onclick="logout(event)">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </div>
    </div>
</div>
</div>
    </div>