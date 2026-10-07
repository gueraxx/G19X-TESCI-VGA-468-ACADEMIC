<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: /customer360/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer 360 — Iniciar Sesión</title>
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
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-people-fill"></i>
            </div>
            <h1>Customer 360</h1>
            <p>PluriOne Platform</p>
        </div>

        <?php if (isset($_GET['expired'])): ?>
            <div class="login-alert">
                <i class="bi bi-clock-history"></i>
                Tu sesión ha expirado. Vuelve a iniciar sesión.
            </div>
        <?php endif; ?>

        <form id="loginForm" class="login-form">
            <div class="form-group">
                <label for="email">
                    <i class="bi bi-envelope"></i> Correo electrónico
                </label>
                <input type="email" id="email" name="email" placeholder="admin@customer360.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="bi bi-lock"></i> Contraseña
                </label>
                <div class="password-input">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" id="togglePassword" class="password-toggle">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div id="loginError" class="login-error" style="display: none;"></div>

            <button type="submit" class="login-btn" id="loginBtn">
                <span class="btn-text">Iniciar Sesión</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer">
            <div class="demo-credentials">
                <i class="bi bi-info-circle"></i>
                <div>
                    <strong>Credenciales de prueba</strong>
                    <div class="credential-row">
                        <span>Email:</span> <code>admin@customer360.com</code>
                    </div>
                    <div class="credential-row">
                        <span>Contraseña:</span> <code>admin123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-side">
        <div class="side-content">
            <h2>Bienvenido de vuelta</h2>
            <p>Accede a tu plataforma inteligente de Customer 360 con IA generativa.</p>
            <ul class="side-features">
                <li><i class="bi bi-check-circle-fill"></i> Perfiles 360° unificados</li>
                <li><i class="bi bi-check-circle-fill"></i> Predicción de abandono</li>
                <li><i class="bi bi-check-circle-fill"></i> Recomendaciones con IA</li>
                <li><i class="bi bi-check-circle-fill"></i> Dashboards ejecutivos</li>
            </ul>
        </div>
        <div class="side-decoration"></div>
    </div>
</div>

<script src="/customer360/assets/js/login.js?v=1"></script>
</body>
</html>