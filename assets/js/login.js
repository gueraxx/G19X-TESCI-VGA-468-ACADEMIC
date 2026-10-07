(function() {
    'use strict';
// ============================================================
// Customer 360 — Login
// ============================================================

console.log('🔐 login.js cargado');

const form = document.getElementById('loginForm');
const btn = document.getElementById('loginBtn');
const errorBox = document.getElementById('loginError');
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

// ============================================================
// Toggle mostrar/ocultar contraseña
// ============================================================
togglePassword?.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    togglePassword.innerHTML = isPassword
        ? '<i class="bi bi-eye-slash"></i>'
        : '<i class="bi bi-eye"></i>';
});

// ============================================================
// Submit del formulario
// ============================================================
form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = passwordInput.value;

    // Reset errores
    errorBox.style.display = 'none';
    errorBox.textContent = '';

    // Loading
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Iniciando...';

    try {
        const res = await fetch('/customer360/api/auth.php?action=login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        if (!res.ok || data.error) {
            showError(data.error || 'Error al iniciar sesión');
            return;
        }

        // Éxito
        btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Bienvenido!';
        btn.classList.add('success');

        // Redirigir
        setTimeout(() => {
            window.location.href = '/customer360/index.php';
        }, 800);

    } catch (error) {
        console.error('Error:', error);
        showError('Error de conexión. Intenta de nuevo.');
    }
});

function showError(message) {
    errorBox.innerHTML = `<i class="bi bi-exclamation-triangle-fill"></i> ${message}`;
    errorBox.style.display = 'flex';

    // Shake animation
    errorBox.classList.add('shake');
    setTimeout(() => errorBox.classList.remove('shake'), 500);

    // Restaurar botón
    btn.disabled = false;
    btn.innerHTML = '<span class="btn-text">Iniciar Sesión</span><i class="bi bi-arrow-right"></i>';

    // Limpiar contraseña
    passwordInput.value = '';
    passwordInput.focus();
}

// ============================================================
// Limpiar error al escribir
// ============================================================
document.getElementById('email')?.addEventListener('input', () => {
    errorBox.style.display = 'none';
});

passwordInput?.addEventListener('input', () => {
    errorBox.style.display = 'none';
});
})();