      <footer class="text-center text-muted py-4 mt-5">
        <small>
            <i class="bi bi-people-fill"></i>
            <strong>Customer 360</strong> &copy; <?= date('Y') ?> — PluriOne
        </small>
    </footer>
</div>
<!-- Modal: Cambiar contraseña -->
<div class="modal-overlay" id="changePasswordModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class="bi bi-key text-primary"></i> Cambiar contraseña</h5>
            <button class="modal-close" onclick="closeChangePassword()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="changePasswordForm" onsubmit="submitChangePassword(event)">
            <div class="modal-body">
                <div id="cpError" class="login-error" style="display: none;"></div>

                <div class="form-group">
                    <label>Contraseña actual</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <input type="password" name="new_password" required minlength="6">
                </div>

                <div class="form-group">
                    <label>Confirmar nueva contraseña</label>
                    <input type="password" name="confirm_password" required minlength="6">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeChangePassword()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" id="cpSubmit">
                    <i class="bi bi-check-circle"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Modal: Crear/Editar Usuario -->
<div class="modal-overlay" id="userModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class="bi bi-person-plus text-primary"></i> <span id="userModalTitle">Nuevo Usuario</span></h5>
            <button class="modal-close" onclick="closeUserModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="userForm" onsubmit="submitUser(event)">
            <div class="modal-body">
                <div id="userError" class="login-error" style="display: none;"></div>

                <div class="form-group">
                    <label>Nombre completo</label>
                    <input type="text" name="full_name" id="userName" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="userEmail" required>
                </div>

                <div class="form-group">
                    <label>Rol</label>
                    <select name="role" id="userRole" required>
                        <option value="viewer">Observador (solo lectura)</option>
                        <option value="sales">Ventas (puede editar clientes)</option>
                        <option value="analyst">Analista (puede recalcular)</option>
                        <option value="admin">Administrador (todo)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" id="userPassword">
                    <small id="passwordHint" class="text-muted">Mínimo 6 caracteres</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeUserModal()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" id="userSubmit">
                    <i class="bi bi-check-circle"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/customer360/assets/js/theme.js"></script>
<script src="/customer360/assets/js/notifications.js?v=1"></script>
<script src="/customer360/assets/js/export.js?v=1"></script>
<script src="/customer360/assets/js/user-menu.js?v=1"></script>
<script src="/customer360/assets/js/permissions.js?v=1"></script>
</body>
</html>