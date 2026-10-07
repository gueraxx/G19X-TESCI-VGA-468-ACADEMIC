// ============================================================
// Customer 360 — Churn
// ============================================================

(function() {
    'use strict';

    console.log('🚀 churn.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');

    async function loadChurn() {
        const tbody = document.getElementById('churnTable');

        if (!tbody) return;

        try {
            const res = await fetch(`${BASE_URL}/api/churn.php`);
            const data = await res.json();

            document.getElementById('kpi-churn-count').textContent = data.data.length;

            if (!data.data || !data.data.length) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>¡Sin clientes en riesgo!</td></tr>';
                return;
            }

            tbody.innerHTML = data.data.map((c, i) => `
                <tr class="fade-in-up" style="animation-delay: ${i * 0.03}s">
                    <td><strong>${c.first_name} ${c.last_name}</strong></td>
                    <td>${c.company || '-'}</td>
                    <td><span class="badge-segment badge-${c.segment}">${c.segment}</span></td>
                    <td><strong>$${parseFloat(c.lifetime_value).toLocaleString()}</strong></td>
                    <td><strong>${(parseFloat(c.churn_risk) * 100).toFixed(0)}%</strong></td>
                    <td>${renderRiskBadge(c.risk_level)}</td>
                    <td>
                        <a href="${BASE_URL}/customer-detail.php?id=${c.id}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">Error: ${error.message}</td></tr>`;
        }
    }

    function renderRiskBadge(level) {
        if (level === 'high') return '<span class="badge-churn-high">ALTO</span>';
        if (level === 'medium') return '<span class="badge-churn-medium">MEDIO</span>';
        return '<span class="badge-churn-low">BAJO</span>';
    }

    async function recalculateChurn() {
        const btn = document.getElementById('btnRecalc');
        if (!btn) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Calculando...';

        try {
            const res = await fetch(`${BASE_URL}/api/churn.php?action=recalculate`, { method: 'POST' });
            const data = await res.json();

            if (data.error) {
                alert('Error: ' + data.error);
            } else {
                btn.innerHTML = '<i class="bi bi-check-circle"></i> ¡Listo!';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Recalcular Churn';
                    btn.disabled = false;
                }, 1500);
                loadChurn();
                return;
            }
        } catch (error) {
            alert('Error al recalcular: ' + error.message);
        }

        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Recalcular Churn';
    }

    window.recalculateChurn = recalculateChurn;

    loadChurn();
})();