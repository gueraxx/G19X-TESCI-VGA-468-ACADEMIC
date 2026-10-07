<?php 
require_once __DIR__ . '/config/auth.php';
requireLogin();

$pageTitle = 'Dashboard';
include 'includes/header.php'; 
?>

<!-- KPIs -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 fade-in-up delay-1">
        <div class="kpi-card kpi-primary">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Total Clientes</p>
                    <div id="kpi-total" class="kpi-skeleton"></div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="kpi-trend up">
                <i class="bi bi-arrow-up-right"></i> +12.5% vs mes anterior
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 fade-in-up delay-2">
        <div class="kpi-card kpi-success">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Clientes Activos</p>
                    <div id="kpi-active" class="kpi-skeleton"></div>
                </div>
                <div class="kpi-icon"><i class="bi bi-person-check-fill"></i></div>
            </div>
            <div class="kpi-trend up">
                <i class="bi bi-arrow-up-right"></i> +8.2% vs mes anterior
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 fade-in-up delay-3">
        <div class="kpi-card kpi-danger">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Alto Riesgo Churn</p>
                    <div id="kpi-churn" class="kpi-skeleton"></div>
                </div>
                <div class="kpi-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
            <div class="kpi-trend down">
                <i class="bi bi-arrow-down-right"></i> -3.1% vs mes anterior
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 fade-in-up delay-4">
        <div class="kpi-card kpi-info">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Ingresos Totales</p>
                    <div id="kpi-revenue" class="kpi-skeleton"></div>
                </div>
                <div class="kpi-icon"><i class="bi bi-currency-dollar"></i></div>
            </div>
            <div class="kpi-trend up">
                <i class="bi bi-arrow-up-right"></i> +15.7% vs mes anterior
            </div>
        </div>
    </div>
</div>

<!-- Gráficos principales -->
<div class="row g-4">
    <div class="col-lg-5 fade-in-up delay-2">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5>Distribución por Segmento</h5>
                    <small>Clientes agrupados por valor</small>
                </div>
                <i class="bi bi-pie-chart text-primary fs-4"></i>
            </div>
            <div class="chart-container">
                <canvas id="chartSegments"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-7 fade-in-up delay-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5>Interacciones por Tipo</h5>
                    <small>Últimos 30 días</small>
                </div>
                <i class="bi bi-bar-chart text-primary fs-4"></i>
            </div>
            <div class="chart-container">
                <canvas id="chartInteractions"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- 🆕 Gráficos adicionales -->
<div class="row g-4 mt-2">
    <div class="col-lg-8 fade-in-up delay-2">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-graph-up-arrow text-success"></i> Evolución de Ingresos</h5>
                    <small>Últimos 6 meses</small>
                </div>
                <i class="bi bi-graph-up-arrow text-success fs-4"></i>
            </div>
            <div class="chart-container">
                <canvas id="chartRevenue"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 fade-in-up delay-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-diagram-3 text-info"></i> Ingresos por Canal</h5>
                    <small>Distribución actual</small>
                </div>
                <i class="bi bi-diagram-3 text-info fs-4"></i>
            </div>
            <div class="chart-container">
                <canvas id="chartChannel"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- 🆕 Top 5 Clientes -->
<div class="row g-4 mt-2">
    <div class="col-12 fade-in-up delay-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-trophy text-warning"></i> Top 5 Clientes por LTV</h5>
                    <small>Los clientes más valiosos</small>
                </div>
                <a href="/customer360/segmentos.php" class="btn btn-sm btn-outline-primary">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Cliente</th>
                            <th>Empresa</th>
                            <th>Segmento</th>
                            <th>LTV</th>
                        </tr>
                    </thead>
                    <tbody id="topCustomersTable">
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="spinner-border spinner-border-sm text-primary"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Actividad reciente -->
<div class="row g-4 mt-2">
    <div class="col-12 fade-in-up delay-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <h5><i class="bi bi-activity text-primary"></i> Actividad Reciente</h5>
                    <small>Últimas transacciones registradas</small>
                </div>
            </div>
            <div id="recentActivity" class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
        </div>
    </div>
</div>

<script src="/customer360/assets/js/dashboard.js?v=5" defer></script>
<?php include 'includes/footer.php'; ?>