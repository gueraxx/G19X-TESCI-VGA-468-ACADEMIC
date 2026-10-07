<?php 

require_once __DIR__ . '/config/auth.php';
requireLogin();

$pageTitle = 'Recomendaciones'; 
include 'includes/header.php'; 
?>

<!-- KPIs de recomendaciones -->
<div class="row g-4 mb-4">
    <div class="col-md-3 fade-in-up">
        <div class="kpi-card kpi-primary">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Total Recomendaciones</p>
                    <div id="rec-total" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-lightbulb"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-1">
        <div class="kpi-card kpi-success">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Upsell</p>
                    <div id="rec-upsell" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-arrow-up-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-2">
        <div class="kpi-card kpi-info">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Cross-sell</p>
                    <div id="rec-cross" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-shuffle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-3">
        <div class="kpi-card kpi-danger">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Retención</p>
                    <div id="rec-retention" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-shield-check"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="chart-card mb-4 fade-in-up delay-2">
    <div class="d-flex flex-wrap gap-3 align-items-center">
        <div>
            <label class="form-label small text-muted mb-1">Filtrar por tipo</label>
            <select id="filterType" class="form-select" style="min-width: 180px;">
                <option value="all">Todos los tipos</option>
                <option value="upsell">Upsell</option>
                <option value="cross-sell">Cross-sell</option>
                <option value="retention">Retención</option>
            </select>
        </div>
        <div>
            <label class="form-label small text-muted mb-1">Filtrar por segmento</label>
            <select id="filterSegment" class="form-select" style="min-width: 180px;">
                <option value="">Todos los segmentos</option>
                <option value="bronze">Bronce</option>
                <option value="silver">Plata</option>
                <option value="gold">Oro</option>
                <option value="platinum">Platino</option>
            </select>
        </div>
        <div>
            <label class="form-label small text-muted mb-1">Límite</label>
            <select id="filterLimit" class="form-select" style="min-width: 120px;">
                <option value="10">10 clientes</option>
                <option value="20" selected>20 clientes</option>
                <option value="50">50 clientes</option>
                <option value="100">100 clientes</option>
            </select>
        </div>
    </div>
</div>

<!-- Banner de estado de IA -->
<div id="aiStatusBanner"></div>

<!-- Lista de recomendaciones -->
<div id="recommendationsList" class="fade-in-up delay-3">
    <div class="text-center py-5">
        <div class="spinner-border text-primary"></div>
        <p class="mt-2 text-muted">Generando recomendaciones...</p>
    </div>
</div>

<script src="/customer360/assets/js/recommendations.js?v=3" defer></script>
<?php include 'includes/footer.php'; ?>