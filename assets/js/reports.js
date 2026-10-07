// ============================================================
// Customer 360 — Reportes
// ============================================================

(function() {
    'use strict';

    console.log('🚀 reports.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');

    async function loadReports() {
        try {
            const res = await fetch(`${BASE_URL}/api/reports.php`);
            const data = await res.json();

            console.log('📊 Reportes:', data);

            if (data.error) return;

            document.getElementById('rep-revenue').textContent = '$' + Math.floor(data.kpis.totalRevenue).toLocaleString();
            document.getElementById('rep-customers').textContent = data.kpis.totalCustomers;
            document.getElementById('rep-ltv').textContent = '$' + Math.floor(data.kpis.avgLTV).toLocaleString();
            document.getElementById('rep-churn').textContent = data.kpis.highChurn;

            renderMonthlyChart(data.monthlyRevenue);
            renderChannelChart(data.byChannel);
            renderReportsTable(data.bySegment);

        } catch (error) {
            console.error('❌ Error:', error);
        }
    }

    function renderMonthlyChart(monthly) {
        const canvas = document.getElementById('chartMonthly');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(67, 97, 238, 0.3)');
        gradient.addColorStop(1, 'rgba(67, 97, 238, 0.02)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthly.map(m => m.month),
                datasets: [{
                    label: 'Ingresos',
                    data: monthly.map(m => Number(m.revenue)),
                    borderColor: '#4361ee',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4361ee',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (ctx) => ` $${ctx.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0f2f5' },
                        ticks: { callback: (v) => '$' + v.toLocaleString() }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    function renderChannelChart(channels) {
        const canvas = document.getElementById('chartChannel');
        if (!canvas) return;

        const colors = ['#4361ee', '#06d6a0', '#ffd166', '#ef476f', '#8b5cf6'];

        new Chart(canvas.getContext('2d'), {
            type: 'polarArea',
            data: {
                labels: channels.map(c => c.channel),
                datasets: [{
                    data: channels.map(c => Number(c.revenue)),
                    backgroundColor: colors.map(c => c + '80'),
                    borderColor: colors,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 12 } }
                    },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (ctx) => ` $${ctx.parsed.r.toLocaleString()}`
                        }
                    }
                }
            }
        });
    }

    function renderReportsTable(segments) {
        const tbody = document.getElementById('reportsTable');
        if (!tbody) return;

        tbody.innerHTML = segments.map(s => `
            <tr>
                <td><span class="badge-segment badge-${s.segment}">${s.segment}</span></td>
                <td><strong>${s.count}</strong></td>
                <td><strong>$${parseFloat(s.revenue).toLocaleString(undefined, { maximumFractionDigits: 0 })}</strong></td>
                <td>${renderChurnBadge(s.avg_churn)}</td>
            </tr>
        `).join('');
    }

    function renderChurnBadge(risk) {
        const r = parseFloat(risk);
        if (r >= 0.7) return `<span class="badge-churn-high">${(r*100).toFixed(0)}%</span>`;
        if (r >= 0.4) return `<span class="badge-churn-medium">${(r*100).toFixed(0)}%</span>`;
        return `<span class="badge-churn-low">${(r*100).toFixed(0)}%</span>`;
    }

    loadReports();
})();