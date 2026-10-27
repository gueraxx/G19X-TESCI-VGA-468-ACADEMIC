<?php
// ============================================================
// Cargar configuración de autenticación ANTES de usar hasRole()
// ============================================================
if (!function_exists('hasRole')) {
    require_once __DIR__ . '/../config/auth.php';
}

$pageTitle = $pageTitle ?? 'Dashboard';

// Base path dinámico (funciona sin importar el nombre de la carpeta)
$base = basePath();

// Datos del usuario actual
$userName     = $_SESSION['user_name']  ?? 'Usuario';
$userEmail    = $_SESSION['user_email'] ?? '';
$userRole     = $_SESSION['user_role']  ?? 'viewer';
$userColor    = $_SESSION['user_color'] ?? '#4361ee';
$userIcon     = $_SESSION['user_icon']  ?? 'bi-person-fill';

// Cálculo de iniciales (por si acaso se usa en otro lado)
$userInitials = strtoupper(implode('', array_map(
    fn($w) => $w[0] ?? '',
    array_slice(explode(' ', $userName), 0, 2)
)));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer 360 — <?= htmlspecialchars($pageTitle) ?></title>

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
    <link href="<?= $base ?>/assets/css/style.css?v=103" rel="stylesheet">
    <link href="<?= $base ?>/assets/css/print.css?v=1" rel="stylesheet" media="print">

    <!-- Chart.js PRIMERO, antes de cualquier otro script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body data-user-role="<?= htmlspecialchars($userRole) ?>">

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <a href="<?= $base ?>/bienvenida.php" class="sidebar-logo text-decoration-none">
        <div class="logo-icon"><i class="bi bi-people-fill"></i></div>
        <div>
            <h4>Customer 360</h4>
            <small>PluriOne Platform</small>
        </div>
    </a>

    <ul class="sidebar-nav">
        <li class="nav-section">Principal</li>

        <li>
            <a href="<?= $base ?>/bienvenida.php" class="<?= $pageTitle === 'Bienvenida' ? 'active' : '' ?>">
                <i class="bi bi-house-door"></i> Inicio
            </a>
        </li>
        <li>
            <a href="<?= $base ?>/index.php" class="<?= $pageTitle === 'Dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= $base ?>/customers.php" class="<?= $pageTitle === 'Clientes' ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Clientes
            </a>
        </li>

        <?php if (hasRole('admin', 'analyst')): ?>
        <li>
            <a href="<?= $base ?>/churn.php" class="<?= $pageTitle === 'Churn' ? 'active' : '' ?>">
                <i class="bi bi-graph-down-arrow"></i> Churn
            </a>
        </li>
        <?php endif; ?>

        <li class="nav-section">Análisis</li>

        <?php if (hasRole('admin', 'analyst')): ?>
        <li>
            <a href="<?= $base ?>/segmentos.php" class="<?= $pageTitle === 'Segmentos' ? 'active' : '' ?>">
                <i class="bi bi-pie-chart"></i> Segmentos
            </a>
        </li>
        <?php endif; ?>

        <li>
            <a href="<?= $base ?>/recomendaciones.php" class="<?= $pageTitle === 'Recomendaciones' ? 'active' : '' ?>">
                <i class="bi bi-lightbulb"></i> Recomendaciones
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/reportes.php" class="<?= $pageTitle === 'Reportes' ? 'active' : '' ?>">
                <i class="bi bi-bar-chart"></i> Reportes
            </a>
        </li>

        <?php if (hasRole('admin')): ?>
        <li class="nav-section">Administración</li>
        <li>
            <a href="<?= $base ?>/usuarios.php" class="<?= $pageTitle === 'Usuarios' ? 'active' : '' ?>">
                <i class="bi bi-person-badge"></i> Usuarios
            </a>
        </li>
        <?php endif; ?>
    </ul>
</aside>

<!-- Overlay oscuro para cerrar el menú en móvil -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- CONTENIDO PRINCIPAL -->
<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            
            <!-- 🍔 Botón menú (solo visible en móvil) -->
            <button class="btn-icon btn-menu-toggle d-lg-none" id="menuToggle" onclick="toggleSidebar()">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>

            <div>
                <h1><?= htmlspecialchars($pageTitle) ?></h1>
                <div class="breadcrumb-text">
                    <i class="bi bi-house-door"></i> Inicio / <?= htmlspecialchars($pageTitle) ?>
                </div>
            </div>
        </div>

        <div class="topbar-actions">
            <!-- Toggle tema -->
            <button class="btn-icon" id="themeToggle" title="Cambiar tema">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
            </button>

            <!-- Recargar -->
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
                        <a href="<?= $base ?>/customers.php">Ver todos los clientes</a>
                    </div>
                </div>
            </div>

            <!-- Menú de usuario -->
            <div class="user-menu-wrapper" id="userMenuWrapper">
                
                <!-- Avatar del Topbar -->
                <div class="user-avatar" id="userAvatar" title="<?= htmlspecialchars($userName) ?>" 
                     style="background: <?= htmlspecialchars($userColor) ?> !important; background-image: none;">
                    <i class="bi <?= htmlspecialchars($userIcon) ?>"></i>
                </div>

                <div class="user-menu-dropdown" id="userMenuDropdown">
                    <div class="user-menu-header">
                        <!-- Avatar dentro del Menú -->
                        <div class="user-menu-avatar" id="userMenuAvatar" 
                             style="background: <?= htmlspecialchars($userColor) ?> !important; background-image: none;">
                            <i class="bi <?= htmlspecialchars($userIcon) ?>"></i>
                        </div>
                        <div>
                            <strong><?= htmlspecialchars($userName) ?></strong>
                            <div class="small text-muted"><?= htmlspecialchars($userEmail) ?></div>
                            <span class="badge-role <?= roleBadgeClass() ?>">
                                <?= roleLabel() ?>
                            </span>
                        </div>
                    </div>

                    <div class="user-menu-list">
                        <a href="#" class="user-menu-item" onclick="openAvatarModal(event)">
                            <i class="bi bi-palette"></i> Personalizar perfil
                        </a>
                        <a href="#" class="user-menu-item" onclick="openChangePassword(event)">
                            <i class="bi bi-key"></i> Cambiar contraseña
                        </a>
                        <a href="#" class="user-menu-item" onclick="openThemeFromMenu(event)">
                            <i class="bi bi-circle-half"></i> Cambiar tema
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