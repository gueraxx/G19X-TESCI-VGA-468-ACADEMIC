// ============================================================
// Customer 360 — Segmentos
// ============================================================

(function() {
    'use strict';

    console.log('🚀 segments.js cargado');

    const BASE_URL = window.location.pathname
        .replace(/\/[^/]*$/, '')
        .replace(/\/$/, '');

    // ============================================================
    // Cargar datos
    // ============================================================
    async function loadSegments() {
        try {
            const res = await fetch(`${BASE_URL}/api/segments.php`);
            const data = await res.json();

            console.log('📊 Segmentos:', data);

            if (data.error) {
                console.error(data.error);
                return;
            }

            renderSegmentsChart(data.segments);
            renderIndustriesChart(data.industries);
            renderSegmentsTable(data.segments);
            renderTopCustomers(data.topCustomers);

        } catch (error) {
            console.error('❌ Error:', error);
        }
    }

    // ============================================================
    // Gráfico de segmentos
    // ============================================================
    function renderSegmentsChart(segments) {
        const canvas = document.getElementById('chartSegmentsDetail');
        if (!canvas) return;

        const colors = { bronze: '#cd7f32', silver: '#a8a8a8', gold: '#ffd700', platinum: '#8b5cf6' };
        const labels = { bronze: 'Bronce', silver: 'Plata', gold: 'Oro', platinum: 'Platino' };

        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: segments.map(s => labels[s.segment] || s.segment),
                datasets: [{
                    data: segments.map(s => Number(s.count)),
                    backgroundColor: segments.map(s => colors[s.segment] || '#ccc'),
                    borderWidth: 0,
                    hoverOffset: 12,
                    spacing: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                animation: { animateScale: true, animateRotate: true, duration: 1200 },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 13, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (ctx) => {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = ((ctx.parsed / total) * 100).toFixed(1);
                                return ` ${ctx.parsed} clientes (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // ============================================================
    // Gráfico de industrias
    // ============================================================
    function renderIndustriesChart(industries) {
        const canvas = document.getElementById('chartIndustries');
        if (!canvas) return;

        new Chart(canvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: industries.map(i => i.industry),
                datasets: [{
                    label: 'Clientes',
                    data: industries.map(i => Number(i.count)),
                    backgroundColor: '#4361ee',
                    borderRadius: 6,
                    barThickness: 22
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1200 },
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f0f2f5' }, ticks: { font: { size: 12 } } },
                    y: { grid: { display: false }, ticks: { font: { size: 12, weight: '600' } } }
                }
            }
        });
    }

    // ============================================================
    // Tabla de resumen
    // ============================================================
    function renderSegmentsTable(segments) {
        const tbody = document.getElementById('segmentsTable');
        if (!tbody) return;

        tbody.innerHTML = segments.map(s => `
            <tr>
                <td><span class="badge-segment badge-${s.segment}">${s.segment}</span></td>
                <td><strong>${s.count}</strong></td>
                <td>$${parseFloat(s.avg_ltv).toLocaleString(undefined, { maximumFractionDigits: 0 })}</td>
                <td><strong>$${parseFloat(s.total_ltv).toLocaleString(undefined, { maximumFractionDigits: 0 })}</strong></td>
                <td>${renderChurnBadge(s.avg_churn)}</td>
            </tr>
        `).join('');
    }

    // ============================================================
    // Top clientes
    // ============================================================
    function renderTopCustomers(customers) {
        const tbody = document.getElementById('topCustomersTable');
        if (!tbody) return;

        if (!customers.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">Sin datos</td></tr>';
            return;
        }

        tbody.innerHTML = customers.map((c, i) => `
            <tr>
                <td><strong>${i + 1}</strong></td>
                <td><strong>${c.first_name} ${c.last_name}</strong></td>
                <td>${c.company || '-'}</td>
                <td><span class="badge-segment badge-${c.segment}">${c.segment}</span></td>
                <td><strong>$${parseFloat(c.lifetime_value).toLocaleString()}</strong></td>
                <td>${renderChurnBadge(c.churn_risk)}</td>
            </tr>
        `).join('');
    }

    function renderChurnBadge(risk) {
        const r = parseFloat(risk);
        if (r >= 0.7) return `<span class="badge-churn-high">${(r*100).toFixed(0)}%</span>`;
        if (r >= 0.4) return `<span class="badge-churn-medium">${(r*100).toFixed(0)}%</span>`;
        return `<span class="badge-churn-low">${(r*100).toFixed(0)}%</span>`;
    }

    // ============================================================
    // Recalcular segmentos
    // ============================================================
    async function recalculateSegments() {
        const btn = document.getElementById('btnRecalc');
        if (!btn) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Recalculando...';

        try {
            const res = await fetch(`${BASE_URL}/api/segments.php?action=recalculate`, { method: 'POST' });
            const data = await res.json();

            if (data.ok) {
                btn.innerHTML = '<i class="bi bi-check-circle"></i> ¡Listo!';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Recalcular Segmentos';
                    btn.disabled = false;
                    loadSegments();
                }, 1200);
            } else {
                alert(data.error || 'Error al recalcular');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Recalcular Segmentos';
            }
        } catch (error) {
            alert('Error: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Recalcular Segmentos';
        }
    }

    // ============================================================
    // Exponer al scope global
    // ============================================================
    window.recalculateSegments = recalculateSegments;

    // ============================================================
    // Init
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadSegments);
    } else {
        loadSegments();
    }
})();