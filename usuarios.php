<?php
require_once __DIR__ . '/config/auth.php';
requireRole('admin');
$pageTitle = 'Usuarios';
include 'includes/header.php';
?>

<div class="table-card fade-in-up">
    <div class="table-card-header">
        <div>
            <h5><i class="bi bi-person-badge text-primary"></i> Gestión de Usuarios</h5>
            <small class="text-muted">Administra los accesos al sistema</small>
        </div>
        <button class="btn btn-primary" onclick="openUserModal()">
            <i class="bi bi-plus-circle"></i> Nuevo Usuario
        </button>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Último acceso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                <tr><td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/customer360/assets/js/users.js?v=1" defer></script>
<?php include 'includes/footer.php'; ?>