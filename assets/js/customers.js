// ============================================================
// Customer 360 — Clientes
// ============================================================

(function() {
    'use strict';

    console.log('🚀 customers.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');

    async function loadCustomers(search = '') {
        const tbody = document.getElementById('customersTable');

        if (!tbody) return;

        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>';

        try {
            const url = `${BASE_URL}/api/customers.php` + (search ? '?search=' + encodeURIComponent(search) : '');
            const res = await fetch(url);

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const data = await res.json();

            if (data.error) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">${data.error}</td></tr>`;
                return;
            }

            if (!data.data || !data.data.length) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Sin resultados</td></tr>';
                return;
            }

            tbody.innerHTML = data.data.map((c, i) => `
                <tr class="fade-in-up" style="animation-delay: ${i * 0.03}s">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width:36px;height:36px;font-size:0.8rem;">
                                ${c.first_name[0]}${c.last_name[0]}
                            </div>
                            <div>
                                <strong>${c.first_name} ${c.last_name}</strong>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">${c.email}</td>
                    <td>${c.company || '-'}</td>
                    <td><span class="badge-segment badge-${c.segment}">${c.segment}</span></td>
                    <td><strong>$${parseFloat(c.lifetime_value).toLocaleString()}</strong></td>
                    <td>${renderChurnBadge(c.churn_risk)}</td>
                    <td>
                        <a href="${BASE_URL}/customer-detail.php?id=${c.id}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            console.error('❌ Error:', error);
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">Error: ${error.message}</td></tr>`;
        }
    }

    function renderChurnBadge(risk) {
        const r = parseFloat(risk);
        if (r >= 0.7) return `<span class="badge-churn-high">${(r*100).toFixed(0)}%</span>`;
        if (r >= 0.4) return `<span class="badge-churn-medium">${(r*100).toFixed(0)}%</span>`;
        return `<span class="badge-churn-low">${(r*100).toFixed(0)}%</span>`;
    }

    let timeout;
    document.getElementById('searchInput')?.addEventListener('input', (e) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => loadCustomers(e.target.value), 300);
    });

    window.loadCustomers = loadCustomers;

    loadCustomers();
})();