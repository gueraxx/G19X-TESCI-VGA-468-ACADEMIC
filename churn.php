<?php $pageTitle = 'Churn'; include 'includes/header.php'; ?>

<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in-up delay-1">
        <div class="kpi-card kpi-danger">
            <div class="kpi-header">
                <div>
                    <p class="kpi-title">Clientes en Riesgo</p>
                    <div id="kpi-churn-count" class="kpi-value">—</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-8 fade-in-up delay-2 d-flex align-items-center">
        <div class="w-100 text-end">
            <?php if (canRecalculate()): ?>
<button class="btn btn-primary" onclick="recalculateChurn()" id="btnRecalc">
    <i class="bi bi-arrow-clockwise"></i> Recalcular Churn
</button>
<?php endif; ?>
        </div>
    </div>
</div>

<div class="table-card fade-in-up delay-3">
    <div class="table-card-header">
        <div>
            <h5><i class="bi bi-graph-down-arrow text-danger"></i> Clientes en Riesgo de Abandono</h5>
            <small class="text-muted">Ordenados por nivel de riesgo descendente</small>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Empresa</th>
                    <th>Segmento</th>
                    <th>LTV</th>
                    <th>Riesgo</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="churnTable">
                <tr><td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/customer360/assets/js/churn.js"></script>
<?php include 'includes/footer.php'; ?>