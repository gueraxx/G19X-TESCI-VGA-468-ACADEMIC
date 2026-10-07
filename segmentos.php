<?php
require_once __DIR__ . '/config/auth.php';
requireRole('admin', 'analyst');
$pageTitle = 'Segmentos';
include 'includes/header.php';
?>

<!-- KPIs de segmentos -->
<div class="row g-4 mb-4" id="segmentKpis">
    <div class="col-md-6 fade-in-up">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-pie-chart text-primary"></i> Distribución por Segmento</h5>
                    <small>Clientes agrupados por valor de vida</small>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="chartSegmentsDetail"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 fade-in-up delay-1">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-bar-chart text-primary"></i> Clientes por Industria</h5>
                    <small>Top 10 industrias</small>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="chartIndustries"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabla resumen por segmento -->
<div class="table-card mb-4 fade-in-up delay-2">
    <div class="table-card-header">
    <div>
        <h5><i class="bi bi-list-check text-primary"></i> Resumen por Segmento</h5>
        <small>Métricas consolidadas</small>
    </div>
    <?php if (canRecalculate()): ?>
    <button class="btn btn-primary" onclick="recalculateSegments()" id="btnRecalc">
        <i class="bi bi-arrow-clockwise"></i> Recalcular Segmentos
    </button>
    <?php endif; ?>
</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Segmento</th>
                    <th>Clientes</th>
                    <th>LTV Promedio</th>
                    <th>LTV Total</th>
                    <th>Churn Promedio</th>
                </tr>
            </thead>
            <tbody id="segmentsTable">
                <tr><td colspan="5" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Top clientes -->
<div class="table-card fade-in-up delay-3">
    <div class="table-card-header">
        <div>
            <h5><i class="bi bi-trophy text-warning"></i> Top 10 Clientes por LTV</h5>
            <small>Los clientes más valiosos</small>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Empresa</th>
                    <th>Segmento</th>
                    <th>LTV</th>
                    <th>Churn</th>
                </tr>
            </thead>
            <tbody id="topCustomersTable">
                <tr><td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/customer360/assets/js/segments.js?v=<?= time() ?>" defer></script>
<?php include 'includes/footer.php'; ?>