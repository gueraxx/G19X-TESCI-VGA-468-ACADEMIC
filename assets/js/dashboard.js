
(function() {
    'use strict';
// ============================================================
// Customer 360 — Dashboard JS
// ============================================================

console.log('🚀 dashboard.js cargado');

// ============================================================
// Configuración de Chart.js según el tema
// ============================================================
function getChartColors() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    return {
        text: isDark ? '#f1f5f9' : '#8d99ae',
        grid: isDark ? '#334155' : '#f0f2f5',
        border: isDark ? '#334155' : '#e9ecef'
    };
}

function applyChartDefaults() {
    const colors = getChartColors();
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = colors.text;
    Chart.defaults.font.size = 12;
}

applyChartDefaults();

// ============================================================
// Cargar Dashboard
// ============================================================
async function loadDashboard() {
    try {
        const res = await fetch('/customer360/api/dashboard.php');
        const data = await res.json();

        console.log('📊 Dashboard:', data);

        if (data.error) {
            console.error('❌ Error del API:', data.error);
            showError();
            return;
        }

        // KPIs con animación
        animateValue('kpi-total', 0, data.kpis.totalCustomers, 800);
        animateValue('kpi-active', 0, data.kpis.activeCustomers, 800);
        animateValue('kpi-churn', 0, data.kpis.highChurnRisk, 800);
        animateValue('kpi-revenue', 0, data.kpis.totalRevenue, 1000, true);

        // Gráficos principales
        renderSegmentsChart(data.segments);
        renderInteractionsChart(data.interactions);

        // 🆕 Gráficos adicionales
        renderRevenueChart(data.monthlyRevenue || []);
        renderChannelChart(data.byChannel || []);

        // 🆕 Top clientes
if (data.topCustomers) {
    renderTopCustomers(data.topCustomers);
}

        // Actividad reciente
        if (data.recentTransactions) {
            renderRecentActivity(data.recentTransactions);
        }

    } catch (error) {
        console.error('Error cargando dashboard:', error);
        showError();
    }
}

// ============================================================
// Animación de números
// ============================================================
function animateValue(id, start, end, duration, isCurrency = false) {
    const el = document.getElementById(id);
    if (!el) return;

    el.classList.remove('kpi-skeleton');
    el.classList.add('kpi-value');

    const startTime = performance.now();
    const diff = end - start;

    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = start + diff * eased;

        if (isCurrency) {
            el.textContent = '$' + Math.floor(current).toLocaleString();
        } else {
            el.textContent = Math.floor(current).toLocaleString();
        }

        if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
}

// ============================================================
// Gráfico de Segmentos (Doughnut)
// ============================================================
function renderSegmentsChart(segments) {
    const canvas = document.getElementById('chartSegments');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const segmentColors = {
        bronze: '#cd7f32',
        silver: '#a8a8a8',
        gold: '#ffd700',
        platinum: '#8b5cf6'
    };

    const segmentLabels = {
        bronze: 'Bronce',
        silver: 'Plata',
        gold: 'Oro',
        platinum: 'Platino'
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: segments.map(s => segmentLabels[s.segment] || s.segment),
            datasets: [{
                data: segments.map(s => Number(s.count)),
                backgroundColor: segments.map(s => segmentColors[s.segment] || '#ccc'),
                borderWidth: 0,
                hoverOffset: 12,
                spacing: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            animation: { animateScale: true, animateRotate: true, duration: 1200 },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 13, weight: '600' }
                    }
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
// Gráfico de Interacciones (Bar)
// ============================================================
function renderInteractionsChart(interactions) {
    const canvas = document.getElementById('chartInteractions');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const colors = getChartColors();

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, '#4361ee');
    gradient.addColorStop(1, '#4895ef');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: interactions.map(i => i.type.charAt(0).toUpperCase() + i.type.slice(1)),
            datasets: [{
                label: 'Interacciones',
                data: interactions.map(i => Number(i.count)),
                backgroundColor: gradient,
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: { label: (ctx) => ` ${ctx.parsed.y} interacciones` }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: colors.grid, drawBorder: false },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12, weight: '600' } }
                }
            }
        }
    });
}

// ============================================================
// 🆕 Gráfico de Evolución de Ingresos (Línea)
// ============================================================
function renderRevenueChart(monthlyRevenue) {
    const canvas = document.getElementById('chartRevenue');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const colors = getChartColors();

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, isDark ? 'rgba(99, 102, 241, 0.4)' : 'rgba(67, 97, 238, 0.3)');
    gradient.addColorStop(1, 'rgba(67, 97, 238, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyRevenue.map(m => m.month_label),
            datasets: [{
                label: 'Ingresos',
                data: monthlyRevenue.map(m => Number(m.revenue)),
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
            animation: { duration: 1500, easing: 'easeOutQuart' },
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
                    grid: { color: colors.grid },
                    ticks: { callback: (v) => '$' + v.toLocaleString() }
                },
                x: { grid: { display: false } }
            }
        }
    });
}

// ============================================================
// 🆕 Gráfico de Ingresos por Canal (Polar Area)
// ============================================================
function renderChannelChart(channels) {
    const canvas = document.getElementById('chartChannel');
    if (!canvas) return;

    const colors = ['#4361ee', '#06d6a0', '#ffd166', '#ef476f', '#8b5cf6'];

    new Chart(canvas.getContext('2d'), {
        type: 'polarArea',
        data: {
            labels: channels.map(c => c.channel.charAt(0).toUpperCase() + c.channel.slice(1)),
            datasets: [{
                data: channels.map(c => Number(c.revenue)),
                backgroundColor: colors.map(c => c + '90'),
                borderColor: colors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200 },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 11 }
                    }
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

// ============================================================
// Actividad reciente
// ============================================================
function renderRecentActivity(transactions) {
    const container = document.getElementById('recentActivity');
    if (!container) return;

    if (!transactions.length) {
        container.innerHTML = '<p class="text-muted py-3 text-center">Sin actividad reciente</p>';
        return;
    }

    container.innerHTML = `
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Canal</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    ${transactions.map(t => `
                        <tr>
                            <td>
                                <i class="bi bi-person-circle text-primary me-2"></i>
                                ${t.customer ? t.customer.firstName + ' ' + t.customer.lastName : 'Cliente'}
                            </td>
                            <td><strong>$${parseFloat(t.amount).toLocaleString()}</strong></td>
                            <td><span class="badge bg-light text-dark">${t.channel}</span></td>
                            <td class="text-muted">${new Date(t.transactionDate).toLocaleDateString('es-MX')}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// ============================================================
// Error
// ============================================================
function showError() {
    ['kpi-total', 'kpi-active', 'kpi-churn', 'kpi-revenue'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('kpi-skeleton');
        el.classList.add('kpi-value');
        el.textContent = '—';
        el.style.color = '#ef476f';
    });
}

// ============================================================
// Re-renderizar gráficos al cambiar tema
// ============================================================
window.addEventListener('themeChanged', () => {
    // Destruir gráficos existentes y recargar
    Chart.helpers?.each?.(Chart.instances, (chart) => chart.destroy());
    location.reload();
});
// ============================================================
// 🆕 Gráfico de Evolución de Ingresos (Línea)
// ============================================================
function renderRevenueChart(monthlyRevenue) {
    const canvas = document.getElementById('chartRevenue');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const colors = getChartColors();

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, isDark ? 'rgba(99, 102, 241, 0.4)' : 'rgba(67, 97, 238, 0.3)');
    gradient.addColorStop(1, 'rgba(67, 97, 238, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyRevenue.map(m => m.month_label),
            datasets: [{
                label: 'Ingresos',
                data: monthlyRevenue.map(m => Number(m.revenue)),
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
            animation: { duration: 1500, easing: 'easeOutQuart' },
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
                    grid: { color: colors.grid },
                    ticks: { callback: (v) => '$' + v.toLocaleString() }
                },
                x: { grid: { display: false } }
            }
        }
    });
}

// ============================================================
// 🆕 Gráfico de Ingresos por Canal (Polar Area)
// ============================================================
function renderChannelChart(channels) {
    const canvas = document.getElementById('chartChannel');
    if (!canvas) return;

    const colors = ['#4361ee', '#06d6a0', '#ffd166', '#ef476f', '#8b5cf6'];

    new Chart(canvas.getContext('2d'), {
        type: 'polarArea',
        data: {
            labels: channels.map(c => c.channel.charAt(0).toUpperCase() + c.channel.slice(1)),
            datasets: [{
                data: channels.map(c => Number(c.revenue)),
                backgroundColor: colors.map(c => c + '90'),
                borderColor: colors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200 },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 11 }
                    }
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

// ============================================================
// 🆕 Top Clientes
// ============================================================
function renderTopCustomers(customers) {
    const tbody = document.getElementById('topCustomersTable');
    if (!tbody) return;

    if (!customers.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-muted">Sin datos</td></tr>';
        return;
    }

    tbody.innerHTML = customers.map((c, i) => `
        <tr>
            <td>
                <span class="badge bg-${i === 0 ? 'warning text-dark' : 'light text-dark'}">${i + 1}</span>
            </td>
            <td>
                <strong>${c.first_name} ${c.last_name}</strong>
            </td>
            <td>${c.company || '-'}</td>
            <td><span class="badge-segment badge-${c.segment}">${c.segment}</span></td>
            <td><strong>$${parseFloat(c.lifetime_value).toLocaleString()}</strong></td>
        </tr>
    `).join('');
}
// ============================================================
// Init
// ============================================================
loadDashboard();
})();