(function() {
    'use strict';
async function loadProfile() {
    const container = document.getElementById('profile-container');

    try {
        const [profileRes, recRes] = await Promise.all([
            fetch(`/customer360/api/customers.php?id=${CUSTOMER_ID}`),
            fetch(`/customer360/api/recommendations.php?id=${CUSTOMER_ID}`)
        ]);

        const profile = await profileRes.json();
        const recs = await recRes.json();

        if (profile.error) {
            container.innerHTML = `<div class="alert alert-danger">${profile.error}</div>`;
            return;
        }

        const c = profile.customer;
        const m = profile.metrics;

        container.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2><i class="bi bi-person-circle"></i> ${c.first_name} ${c.last_name}</h2>
                <div class="d-flex gap-2">
    <button class="btn btn-outline-primary no-print" onclick="exportToPDF('Perfil 360° - ${c.first_name} ${c.last_name}')">
        <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
    </button>
    <a href="/customer360/customers.php" class="btn btn-outline-secondary no-print">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card"><div class="card-body">
                        <small class="text-muted">Gasto total</small>
                        <h3>$${m.totalSpent.toLocaleString()}</h3>
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="card"><div class="card-body">
                        <small class="text-muted">Ticket promedio</small>
                        <h3>$${m.avgTicket}</h3>
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="card"><div class="card-body">
                        <small class="text-muted">Transacciones</small>
                        <h3>${m.transactionCount}</h3>
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="card"><div class="card-body">
                        <small class="text-muted">Interacciones</small>
                        <h3>${m.interactionCount}</h3>
                    </div></div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white"><strong>Datos del cliente</strong></div>
                        <div class="card-body">
                            <p><strong>Email:</strong> ${c.email}</p>
                            <p><strong>Teléfono:</strong> ${c.phone || '-'}</p>
                            <p><strong>Empresa:</strong> ${c.company || '-'}</p>
                            <p><strong>Industria:</strong> ${c.industry || '-'}</p>
                            <p><strong>Ubicación:</strong> ${c.city || '-'}, ${c.country || '-'}</p>
                            <p><strong>Segmento:</strong> <span class="badge bg-primary">${c.segment}</span></p>
                            <p><strong>Estado:</strong> <span class="badge bg-success">${c.status}</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white"><strong><i class="bi bi-stars"></i> Recomendaciones IA</strong></div>
                        <div class="card-body">
                            <p class="alert alert-info"><strong>Próxima mejor acción:</strong> ${recs.nextBestAction}</p>
                            <p><em>${recs.summary}</em></p>
                            <ul class="list-group">
                                ${recs.recommendations.map(r => `
                                    <li class="list-group-item">
                                        <span class="badge bg-success">${r.type}</span>
                                        <strong>${r.product}</strong>
                                        <br><small>${r.reason}</small>
                                        <br><small class="text-muted">Confianza: ${(r.confidence*100).toFixed(0)}%</small>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white"><strong>Historial de transacciones</strong></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Fecha</th><th>Monto</th><th>Canal</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            ${profile.transactions.length ? profile.transactions.map(t => `
                                <tr>
                                    <td>${new Date(t.transaction_date).toLocaleDateString()}</td>
                                    <td>$${parseFloat(t.amount).toLocaleString()}</td>
                                    <td>${t.channel}</td>
                                    <td><span class="badge bg-${t.status === 'completed' ? 'success' : 'secondary'}">${t.status}</span></td>
                                </tr>
                            `).join('') : '<tr><td colspan="4" class="text-center text-muted py-3">Sin transacciones</td></tr>'}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
    <div class="card-header bg-white">
        <strong><i class="bi bi-clock-history text-primary"></i> Timeline de Interacciones</strong>
        <span class="badge bg-primary ms-2">${profile.interactions.length}</span>
    </div>
    <div class="card-body">
        ${profile.interactions.length
            ? renderTimeline(profile.interactions)
            : '<p class="text-center text-muted py-4"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Sin interacciones registradas</p>'}
    </div>
</div>
        `;

    } catch (error) {
        container.innerHTML = `<div class="alert alert-danger">Error cargando perfil: ${error.message}</div>`;
    }
}

function sentimentColor(s) {
    return { positive: 'success', neutral: 'secondary', negative: 'danger' }[s] || 'secondary';
}
// ============================================================
// Timeline de interacciones
// ============================================================
function renderTimeline(interactions) {
    // Ordenar por fecha descendente
    const sorted = [...interactions].sort((a, b) =>
        new Date(b.occurred_at) - new Date(a.occurred_at)
    );

    // Agrupar por fecha
    const grouped = {};
    sorted.forEach(i => {
        const date = new Date(i.occurred_at).toLocaleDateString('es-MX', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        if (!grouped[date]) grouped[date] = [];
        grouped[date].push(i);
    });

    const iconMap = {
        call: 'bi-telephone-fill',
        email: 'bi-envelope-fill',
        chat: 'bi-chat-dots-fill',
        ticket: 'bi-ticket-detailed-fill',
        meeting: 'bi-calendar-event-fill',
        campaign: 'bi-megaphone-fill'
    };

    const colorMap = {
        call: 'primary',
        email: 'info',
        chat: 'success',
        ticket: 'warning',
        meeting: 'secondary',
        campaign: 'danger'
    };

    const sentimentIcon = {
        positive: 'bi-emoji-smile-fill',
        neutral: 'bi-emoji-neutral-fill',
        negative: 'bi-emoji-frown-fill'
    };

    let html = '<div class="timeline">';

    Object.entries(grouped).forEach(([date, items]) => {
        html += `
            <div class="timeline-date-divider">
                <span>${date}</span>
            </div>
        `;

        items.forEach(i => {
            const time = new Date(i.occurred_at).toLocaleTimeString('es-MX', {
                hour: '2-digit',
                minute: '2-digit'
            });

            html += `
                <div class="timeline-item">
                    <div class="timeline-marker bg-${colorMap[i.type] || 'secondary'}">
                        <i class="bi ${iconMap[i.type] || 'bi-circle-fill'}"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <strong>${i.subject || 'Sin asunto'}</strong>
                                <div class="small text-muted mt-1">
                                    <i class="bi bi-tag"></i> ${i.type}
                                    &nbsp;·&nbsp;
                                    <i class="bi bi-diagram-2"></i> ${i.source}
                                    &nbsp;·&nbsp;
                                    <i class="bi bi-clock"></i> ${time}
                                </div>
                            </div>
                            <span class="badge bg-${sentimentColor(i.sentiment)}">
                                <i class="bi ${sentimentIcon[i.sentiment] || 'bi-emoji-neutral-fill'}"></i>
                                ${i.sentiment}
                            </span>
                        </div>
                        ${i.description ? `<p class="text-muted small mb-0 mt-2">${i.description}</p>` : ''}
                    </div>
                </div>
            `;
        });
    });

    html += '</div>';
    return html;
}
loadProfile();
})();
