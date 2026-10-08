<?php
require_once __DIR__ . '/config/auth.php';
requireLogin();

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
            <?php if (canEdit()): ?>
            <button class="btn btn-primary" onclick="openCustomerModal()">
                <i class="bi bi-plus-circle"></i> Nuevo Cliente
            </button>
            <?php endif; ?>
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
                    <div class="spinner-border text-primary"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Crear/Editar Cliente -->
<div class="modal-overlay" id="customerModal">
    <div class="modal-box" style="max-width: 620px;">
        <div class="modal-header">
            <h5><i class="bi bi-person-plus text-primary"></i> <span id="customerModalTitle">Nuevo Cliente</span></h5>
            <button class="modal-close" onclick="closeCustomerModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="customerForm" onsubmit="submitCustomer(event)">
            <div class="modal-body">
                <div id="customerError" class="login-error" style="display: none;"></div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre *</label>
                            <input type="text" name="first_name" required maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellido *</label>
                            <input type="text" name="last_name" required maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" required maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="phone" maxlength="30">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Empresa</label>
                            <input type="text" name="company" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Industria</label>
                            <input type="text" name="industry" maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" name="country" maxlength="80">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" name="city" maxlength="80">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Segmento</label>
                            <select name="segment">
                                <option value="bronze">Bronce</option>
                                <option value="silver">Plata</option>
                                <option value="gold">Oro</option>
                                <option value="platinum">Platino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="status">
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                                <option value="blocked">Bloqueado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeCustomerModal()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" id="customerSubmit">
                    <i class="bi bi-check-circle"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/customer360/assets/js/customers.js?v=<?= time() ?>" defer></script>
<?php include 'includes/footer.php'; ?>