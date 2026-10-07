<?php 
session_start();
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/auth.php';
requireLogin();

$method = $_SERVER['REQUEST_METHOD'];
if (in_array($method, ['POST', 'PUT', 'DELETE']) && !hasRole('admin', 'sales')) {
    jsonResponse(['error' => 'No tienes permisos para modificar clientes'], 403);
}
$pageTitle = 'Clientes'; 
include 'includes/header.php'; 
?>

<div class="table-card fade-in-up">
    <div class="table-card-header">
    <div>
        <h5><i class="bi bi-people-fill text-primary"></i> Todos los Clientes</h5>
        <small class="text-muted">Listado completo con segmentación y riesgo</small>
    </div>
    <div class="d-flex gap-2 align-items-center no-print">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar por nombre, email o empresa...">
        </div>
        <button class="btn btn-outline-danger" onclick="exportToPDF('Listado de Clientes')">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </button>
    </div>
</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Empresa</th>
                    <th>Segmento</th>
                    <th>LTV</th>
                    <th>Churn</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="customersTable">
                <tr><td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/customer360/assets/js/customers.js"></script>
<?php include 'includes/footer.php'; ?>