<footer class="text-center text-muted py-4 mt-5">
    <small>
        <i class="bi bi-people-fill"></i>
        <strong>Customer 360</strong> &copy; <?= date('Y') ?> — PluriOne
    </small>
</footer>
</div> <!-- Cierre de .main-content -->

<!-- Modal: Personalizar Avatar -->
<div class="modal-overlay" id="avatarModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class="bi bi-palette text-primary"></i> Personalizar Perfil</h5>
            <button class="modal-close" onclick="closeAvatarModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="avatarForm" onsubmit="submitAvatar(event)">
            <div class="modal-body">
                <div id="avatarError" class="login-error" style="display: none;"></div>

                <div class="form-group text-center mb-4">
                    <div class="user-avatar mx-auto mb-3" id="previewAvatar" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <small class="text-muted">Así se verá tu avatar</small>
                </div>

                <div class="form-group">
                    <label>Color de fondo</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="color-btn" style="background: #4361ee" onclick="setAvatarColor('#4361ee')"></button>
                        <button type="button" class="color-btn" style="background: #7209b7" onclick="setAvatarColor('#7209b7')"></button>
                        <button type="button" class="color-btn" style="background: #10b981" onclick="setAvatarColor('#10b981')"></button>
                        <button type="button" class="color-btn" style="background: #ef4444" onclick="setAvatarColor('#ef4444')"></button>
                        <button type="button" class="color-btn" style="background: #f59e0b" onclick="setAvatarColor('#f59e0b')"></button>
                        <button type="button" class="color-btn" style="background: #06b6d4" onclick="setAvatarColor('#06b6d4')"></button>
                        <button type="button" class="color-btn" style="background: #475569" onclick="setAvatarColor('#475569')"></button>
                        <button type="button" class="color-btn" style="background: #ff6b6b" onclick="setAvatarColor('#ff6b6b')"></button>
                    </div>
                    <input type="hidden" name="avatar_color" id="selectedColor" value="<?= $_SESSION['user_color'] ?? '#4361ee' ?>">
                </div>

                <div class="form-group mt-3">
                    <label>Ícono</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-person-fill')"><i class="bi bi-person-fill"></i></button>
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-briefcase-fill')"><i class="bi bi-briefcase-fill"></i></button>
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-star-fill')"><i class="bi bi-star-fill"></i></button>
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-heart-fill')"><i class="bi bi-heart-fill"></i></button>
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-lightning-fill')"><i class="bi bi-lightning-fill"></i></button>
                        <button type="button" class="icon-btn" onclick="setAvatarIcon('bi-rocket-fill')"><i class="bi bi-rocket-fill"></i></button>
                    </div>
                    <input type="hidden" name="avatar_icon" id="selectedIcon" value="<?= $_SESSION['user_icon'] ?? 'bi-person-fill' ?>">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeAvatarModal()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" id="avatarSubmit">
                    <i class="bi bi-check-circle"></i> Guardar
                </button>
            </div>
        </form>
    </div>
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

<!-- ============================================================ -->
<!-- SCRIPTS GLOBALES -->
<!-- ============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Lógica del Sidebar Móvil -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (sidebar) sidebar.classList.toggle('open');
        if (overlay) overlay.classList.toggle('show');
    }

    document.addEventListener('click', (e) => {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('menuToggle');
        
        if (sidebar && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
                if (overlay) overlay.classList.remove('show');
            }
        }
    });
</script>

<!-- Scripts del sistema (con versiones actualizadas para forzar recarga) -->
<script src="<?= basePath() ?>/assets/js/theme.js?v=2"></script>
<script src="<?= basePath() ?>/assets/js/notifications.js?v=3"></script>
<script src="<?= basePath() ?>/assets/js/export.js?v=2"></script>
<script src="<?= basePath() ?>/assets/js/user-menu.js?v=3"></script>
<script src="<?= basePath() ?>/assets/js/permissions.js?v=2"></script>
</body>
</html>