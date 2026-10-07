<?php 

require_once __DIR__ . '/config/auth.php';
requireLogin();

$pageTitle = 'Reportes';
include 'includes/header.php'; 
?>

<!-- KPIs del reporte -->
<div class="row g-4 mb-4">
    <div class="col-md-3 fade-in-up">
        <div class="kpi-card kpi-info">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Ingresos Totales</p>
                    <div id="rep-revenue" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-currency-dollar"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-1">
        <div class="kpi-card kpi-primary">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Total Clientes</p>
                    <div id="rep-customers" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-2">
        <div class="kpi-card kpi-success">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">LTV Promedio</p>
                    <div id="rep-ltv" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 fade-in-up delay-3">
        <div class="kpi-card kpi-danger">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Alto Riesgo</p>
                    <div id="rep-churn" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Botones de exportación -->
<div class="chart-card mb-4 fade-in-up delay-2">
    <div class="chart-card-header">
        <div>
            <h5><i class="bi bi-download text-primary"></i> Exportar Reportes</h5>
            <small>Descarga los datos en formato CSV (compatible con Excel)</small>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="/customer360/api/reports.php?type=customers&format=csv" class="btn btn-primary">
            <i class="bi bi-file-earmark-spreadsheet"></i> Clientes (CSV)
        </a>
        <a href="/customer360/api/reports.php?type=transactions&format=csv" class="btn btn-primary">
            <i class="bi bi-file-earmark-spreadsheet"></i> Transacciones (CSV)
        </a>
        <a href="/customer360/api/reports.php?type=churn&format=csv" class="btn btn-primary">
            <i class="bi bi-file-earmark-spreadsheet"></i> Churn (CSV)
        </a>
        <button class="btn btn-danger no-print" onclick="exportToPDF('Reporte Ejecutivo')">
    <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
</button>
<button onclick="exportToPDFLandscape('Reporte')">
    <i class="bi bi-file-earmark-pdf"></i> PDF Horizontal
</button>
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir / PDF
        </button>
    </div>
</div>

<!-- Gráficos -->
<div class="row g-4 mb-4">
    <div class="col-lg-8 fade-in-up delay-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-graph-up text-primary"></i> Ingresos por Mes</h5>
                    <small>Últimos 12 meses</small>
                </div>
            </div>
            <div class="chart-container" style="height: 320px;">
                <canvas id="chartMonthly"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 fade-in-up delay-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-diagram-3 text-primary"></i> Ingresos por Canal</h5>
                    <small>Distribución</small>
                </div>
            </div>
            <div class="chart-container" style="height: 320px;">
                <canvas id="chartChannel"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabla resumen por segmento -->
<div class="table-card fade-in-up delay-4">
    <div class="table-card-header">
        <div>
            <h5><i class="bi bi-table text-primary"></i> Resumen por Segmento</h5>
            <small>Clientes, ingresos y churn</small>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Segmento</th>
                    <th>Clientes</th>
                    <th>Ingresos</th>
                    <th>Churn Promedio</th>
                </tr>
            </thead>
            <tbody id="reportsTable">
                <tr><td colspan="4" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/customer360/assets/js/reports.js" defer></script>
<?php include 'includes/footer.php'; ?>