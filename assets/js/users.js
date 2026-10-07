// ============================================================
// Customer 360 — Gestión de usuarios (solo admin)
// ============================================================

(function() {
    'use strict';

    console.log('👥 users.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');

    // ============================================================
    // Cargar usuarios
    // ============================================================
    async function loadUsers() {
        const tbody = document.getElementById('usersTable');
        if (!tbody) return;

        try {
            const res = await fetch(`${BASE_URL}/api/users.php`);
            const data = await res.json();

            if (data.error) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center py-4">${data.error}</td></tr>`;
                return;
            }

            tbody.innerHTML = data.data.map(u => `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width:36px;height:36px;font-size:0.75rem;">
                                ${initials(u.full_name)}
                            </div>
                            <strong>${u.full_name}</strong>
                        </div>
                    </td>
                    <td class="text-muted">${u.email}</td>
                    <td><span class="badge-role badge-role-${u.role}">${u.role}</span></td>
                    <td>
                        ${u.is_active == 1
                            ? '<span class="badge bg-success">Activo</span>'
                            : '<span class="badge bg-secondary">Inactivo</span>'}
                    </td>
                    <td class="text-muted small">
                        ${u.last_login ? new Date(u.last_login).toLocaleString('es-MX') : 'Nunca'}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick='window.editUser(${JSON.stringify(u).replace(/'/g, "&#39;")})'>
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="window.deleteUser(${u.id}, '${u.full_name}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center py-4">Error: ${error.message}</td></tr>`;
        }
    }

    function initials(name) {
        return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
    }

    // ============================================================
    // Abrir modal para crear
    // ============================================================
    function openUserModal() {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');

        form.reset();
        form.dataset.mode = 'create';
        form.dataset.userId = '';

        document.getElementById('userModalTitle').textContent = 'Nuevo Usuario';
        document.getElementById('passwordHint').style.display = 'block';
        document.getElementById('userPassword').required = true;
        document.getElementById('userEmail').disabled = false;

        modal.classList.add('open');
    }

    // ============================================================
    // Abrir modal para editar
    // ============================================================
    function editUser(user) {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');

        form.dataset.mode = 'edit';
        form.dataset.userId = user.id;

        document.getElementById('userModalTitle').textContent = 'Editar Usuario';
        document.getElementById('userName').value = user.full_name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userEmail').disabled = true;
        document.getElementById('userRole').value = user.role;
        document.getElementById('userPassword').value = '';
        document.getElementById('userPassword').required = false;
        document.getElementById('passwordHint').style.display = 'block';

        modal.classList.add('open');
    }

    // ============================================================
    // Cerrar modal
    // ============================================================
    function closeUserModal() {
        document.getElementById('userModal')?.classList.remove('open');
        const email = document.getElementById('userEmail');
        if (email) email.disabled = false;
    }

    // ============================================================
    // Submit
    // ============================================================
    async function submitUser(e) {
        e.preventDefault();

        const form = e.target;
        const mode = form.dataset.mode;
        const userId = form.dataset.userId;
        const errBox = document.getElementById('userError');
        const btn = document.getElementById('userSubmit');

        errBox.style.display = 'none';

        const payload = {
            full_name: form.full_name.value.trim(),
            email: form.email.value.trim(),
            role: form.role.value,
            password: form.password.value
        };

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

        try {
            let url = `${BASE_URL}/api/users.php`;
            let method = 'POST';

            if (mode === 'edit') {
                url += `?id=${userId}`;
                method = 'PUT';
            }

            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (!res.ok || data.error) {
                errBox.textContent = data.error || 'Error';
                errBox.style.display = 'flex';
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar';
                return;
            }

            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Listo!';

            setTimeout(() => {
                closeUserModal();
                loadUsers();
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar';
            }, 800);

        } catch (error) {
            errBox.textContent = 'Error de conexión';
            errBox.style.display = 'flex';
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar';
        }
    }

    // ============================================================
    // Eliminar
    // ============================================================
    async function deleteUser(id, name) {
        if (!confirm(`¿Eliminar a "${name}"? Esta acción no se puede deshacer.`)) return;

        try {
            const res = await fetch(`${BASE_URL}/api/users.php?id=${id}`, { method: 'DELETE' });
            const data = await res.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            loadUsers();
        } catch (error) {
            alert('Error: ' + error.message);
        }
    }

    // ============================================================
    // Exponer funciones al scope global (para onclick del HTML)
    // ============================================================
    window.openUserModal = openUserModal;
    window.editUser = editUser;
    window.closeUserModal = closeUserModal;
    window.submitUser = submitUser;
    window.deleteUser = deleteUser;

    // ============================================================
    // Init
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadUsers);
    } else {
        loadUsers();
    }
})();