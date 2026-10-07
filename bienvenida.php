<?php
require_once __DIR__ . '/config/auth.php';
requireLogin();
$pageTitle = 'Bienvenida';
include 'includes/header.php';
?>

<!-- HERO -->
<div class="hero-section fade-in-up">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <span class="badge-hero">
                <i class="bi bi-stars"></i> Plataforma Inteligente de IA
            </span>
            <h1 class="hero-title">
                Conoce a tus clientes <br>
                <span class="text-gradient">como nunca antes</span>
            </h1>
            <p class="hero-subtitle">
                Customer 360 unifica CRM, ERP, ventas, marketing y soporte en una sola
                plataforma impulsada por inteligencia artificial. Toma decisiones con
                datos, no con intuición.
            </p>
            <div class="hero-actions">
                <a href="/customer360/index.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-speedometer2"></i> Ir al Dashboard
                </a>
                <a href="/customer360/customers.php" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-people"></i> Ver Clientes
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hero-visual">
                <div class="floating-card card-1">
                    <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                    <div>
                        <small class="text-muted d-block">Ingresos</small>
                        <strong>$60,300</strong>
                    </div>
                </div>
                <div class="floating-card card-2">
                    <i class="bi bi-people-fill text-primary fs-4"></i>
                    <div>
                        <small class="text-muted d-block">Clientes</small>
                        <strong>5 activos</strong>
                    </div>
                </div>
                <div class="floating-card card-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                    <div>
                        <small class="text-muted d-block">Churn</small>
                        <strong>1 en riesgo</strong>
                    </div>
                </div>
                <div class="hero-circle"></div>
            </div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<div class="row g-4 mt-5">
    <div class="col-md-3 fade-in-up delay-1">
        <div class="feature-card">
            <div class="feature-icon bg-primary-subtle">
                <i class="bi bi-person-badge text-primary"></i>
            </div>
            <h5>Perfil 360°</h5>
            <p class="text-muted small mb-0">Vista unificada del cliente con datos de todas las fuentes.</p>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-2">
        <div class="feature-card">
            <div class="feature-icon bg-success-subtle">
                <i class="bi bi-graph-up text-success"></i>
            </div>
            <h5>Analítica Avanzada</h5>
            <p class="text-muted small mb-0">KPIs, tendencias y dashboards ejecutivos en tiempo real.</p>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-3">
        <div class="feature-card">
            <div class="feature-icon bg-warning-subtle">
                <i class="bi bi-robot text-warning"></i>
            </div>
            <h5>IA Predictiva</h5>
            <p class="text-muted small mb-0">Predicción de abandono y recomendaciones personalizadas.</p>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-4">
        <div class="feature-card">
            <div class="feature-icon bg-info-subtle">
                <i class="bi bi-diagram-3 text-info"></i>
            </div>
            <h5>Integraciones</h5>
            <p class="text-muted small mb-0">Conecta CRM, ERP, ventas y soporte sin fricción.</p>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta-section mt-5 fade-in-up">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="mb-2">¿Listo para empezar?</h3>
            <p class="mb-0 text-white-50">
                Explora el dashboard con datos reales de tu base de clientes.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="/customer360/index.php" class="btn btn-light btn-lg">
                <i class="bi bi-rocket-takeoff"></i> Explorar Dashboard
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>