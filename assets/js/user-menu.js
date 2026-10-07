
(function() {
    'use strict';// ============================================================
// Customer 360 — Menú de usuario
// ============================================================

console.log('👤 user-menu.js cargado');

// ============================================================
// Toggle del menú de usuario
// ============================================================
(function setupUserMenu() {
    const wrapper = document.getElementById('userMenuWrapper');
    const avatar = document.getElementById('userAvatar');

    if (!wrapper || !avatar) return;

    avatar.addEventListener('click', (e) => {
        e.stopPropagation();
        wrapper.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            wrapper.classList.remove('open');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') wrapper.classList.remove('open');
    });
})();

// ============================================================
// Logout
// ============================================================
async function logout(e) {
    e.preventDefault();

    if (!confirm('¿Cerrar sesión?')) return;

    try {
        await fetch('/customer360/api/auth.php?action=logout', { method: 'POST' });
        window.location.href = '/customer360/login.php';
    } catch (error) {
        console.error('Error cerrando sesión:', error);
        window.location.href = '/customer360/login.php';
    }
}

// ============================================================
// Cambiar contraseña
// ============================================================
function openChangePassword(e) {
    e.preventDefault();
    document.getElementById('userMenuWrapper')?.classList.remove('open');
    document.getElementById('changePasswordModal')?.classList.add('open');
}

function closeChangePassword() {
    document.getElementById('changePasswordModal')?.classList.remove('open');
    document.getElementById('changePasswordForm')?.reset();
    const err = document.getElementById('cpError');
    if (err) err.style.display = 'none';
}

async function submitChangePassword(e) {
    e.preventDefault();

    const form = e.target;
    const currentPassword = form.current_password.value;
    const newPassword = form.new_password.value;
    const confirmPassword = form.confirm_password.value;
    const errorBox = document.getElementById('cpError');
    const btn = document.getElementById('cpSubmit');

    errorBox.style.display = 'none';

    if (newPassword !== confirmPassword) {
        errorBox.textContent = 'Las contraseñas no coinciden';
        errorBox.style.display = 'flex';
        return;
    }

    if (newPassword.length < 6) {
        errorBox.textContent = 'La contraseña debe tener al menos 6 caracteres';
        errorBox.style.display = 'flex';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

    try {
        const res = await fetch('/customer360/api/auth.php?action=change-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword
            })
        });

        const data = await res.json();

        if (!res.ok || data.error) {
            errorBox.textContent = data.error || 'Error al cambiar contraseña';
            errorBox.style.display = 'flex';
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar cambios';
            return;
        }

        // Éxito
        btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Actualizada!';
        btn.classList.add('success');

        setTimeout(() => {
            closeChangePassword();
            btn.disabled = false;
            btn.classList.remove('success');
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar cambios';
        }, 1200);

    } catch (error) {
        errorBox.textContent = 'Error de conexión';
        errorBox.style.display = 'flex';
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar cambios';
    }
}

// ============================================================
// Cambiar tema desde el menú
// ============================================================
function openThemeFromMenu(e) {
    e.preventDefault();
    document.getElementById('userMenuWrapper')?.classList.remove('open');
    document.getElementById('themeToggle')?.click();
}
window.logout = logout;
    window.openChangePassword = openChangePassword;
    window.closeChangePassword = closeChangePassword;
    window.submitChangePassword = submitChangePassword;
    window.openThemeFromMenu = openThemeFromMenu;
})();
