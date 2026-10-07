// ============================================================
// Customer 360 — Toggle de tema (light / dark)
// ============================================================

(function() {
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    if (!toggle) return;

    const getCurrentTheme = () => document.documentElement.getAttribute('data-theme') || 'light';

    const updateIcon = (theme) => {
        if (!icon) return;
        if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill';
        } else {
            icon.className = 'bi bi-moon-stars';
        }
    };

    // Inicializar icono según el tema actual
    updateIcon(getCurrentTheme());

    toggle.addEventListener('click', () => {
        const current = getCurrentTheme();
        const next = current === 'dark' ? 'light' : 'dark';

        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        updateIcon(next);

        // Disparar evento para que Chart.js pueda reaccionar
        window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: next } }));
    });
})();