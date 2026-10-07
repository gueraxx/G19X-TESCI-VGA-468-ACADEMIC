// ============================================================
// Customer 360 — Recomendaciones
// ============================================================

(function() {
    'use strict';

    console.log('🚀 recommendations.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');

    async function loadRecommendations() {
        const type = document.getElementById('filterType').value;
        const segment = document.getElementById('filterSegment').value;
        const limit = document.getElementById('filterLimit').value;

        const container = document.getElementById('recommendationsList');
        container.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-2 text-muted">Generando recomendaciones con IA...</p>
            </div>
        `;

        try {
            const params = new URLSearchParams({ type, segment, limit });
            const res = await fetch(`${BASE_URL}/api/recommendations-list.php?${params}`);
            const data = await res.json();

            console.log('📊 Recomendaciones:', data);

            if (data.error) {
                container.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                return;
            }

            document.getElementById('rec-total').textContent = data.summary.totalRecommendations;
            document.getElementById('rec-upsell').textContent = data.summary.byType.upsell;
            document.getElementById('rec-cross').textContent = data.summary.byType['cross-sell'];
            document.getElementById('rec-retention').textContent = data.summary.byType.retention;

            const statusBanner = document.getElementById('aiStatusBanner');
            if (statusBanner) {
                if (data.summary.iaEnabled && data.summary.iaUsed > 0) {
                    const cacheInfo = data.summary.cacheHits > 0
                        ? `<span class="cache-badge"><i class="bi bi-lightning-charge-fill"></i> ${data.summary.cacheHits} desde caché</span>`
                        : '';

                    const rulesInfo = data.summary.rulesUsed > 0
                        ? ` · ${data.summary.rulesUsed} con reglas (fallback)`
                        : '';

                    statusBanner.innerHTML = `
                        <div class="ai-status-banner ai-active">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-robot"></i>
                                <div>
                                    <strong>IA Generativa activa</strong>
                                    <div class="small">
                                        ${data.summary.iaUsed} recomendaciones generadas con <code>${data.summary.modelo}</code>
                                        ${rulesInfo}
                                        ${cacheInfo}
                                    </div>
                                </div>
                            </div>
                            <span class="ai-status-badge">
                                <i class="bi bi-lightning-charge-fill"></i> Powered by Groq
                            </span>
                        </div>
                    `;
                } else {
                    statusBanner.innerHTML = `
                        <div class="ai-status-banner ai-inactive">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-gear"></i>
                                <div>
                                    <strong>Modo reglas de negocio</strong>
                                    <div class="small">
                                        La IA no está configurada. Las recomendaciones se generan con reglas heurísticas.
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }

            if (!data.recommendations.length) {
                container.innerHTML = `
                    <div class="chart-card text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">No hay recomendaciones para estos filtros</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = data.recommendations.map((item, i) => `
                <div class="rec-card fade-in-up" style="animation-delay: ${i * 0.05}s">
                    <div class="rec-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar" style="width:44px;height:44px;">
                                ${item.customer.name.split(' ').map(n => n[0]).join('').slice(0, 2)}
                            </div>
                            <div>
                                <h6 class="mb-0">
                                    <a href="${BASE_URL}/customer-detail.php?id=${item.customer.id}" class="text-decoration-none">
                                        ${item.customer.name}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    ${item.customer.company || 'Sin empresa'}
                                    &nbsp;·&nbsp;
                                    <span class="badge-segment badge-${item.customer.segment}">${item.customer.segment}</span>
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">LTV</div>
                            <strong>$${item.customer.lifetime_value.toLocaleString()}</strong>
                        </div>
                    </div>

                    <div class="rec-list">
                        ${item.recommendations.map(r => `
                            <div class="rec-item rec-${r.type}">
                                <div class="rec-badge">
                                    ${iconForType(r.type)}
                                    <span>${r.type}</span>
                                </div>
                                <div class="rec-content">
                                    <strong>${r.product}</strong>
                                    <p class="mb-1">${r.reason}</p>
                                    <div class="rec-meta">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-flag"></i> Prioridad: ${r.priority}
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-graph-up"></i> Confianza: ${(r.confidence * 100).toFixed(0)}%
                                        </span>
                                        ${renderSourceBadge(r.source)}
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `).join('');

        } catch (error) {
            console.error('❌ Error:', error);
            container.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        }
    }

    function renderSourceBadge(source) {
        if (source === 'ai') {
            return `
                <span class="badge-source badge-ai" title="Recomendación generada por IA">
                    <i class="bi bi-robot"></i> IA
                </span>
            `;
        }
        return `
            <span class="badge-source badge-rules" title="Recomendación generada por reglas de negocio">
                <i class="bi bi-gear"></i> Reglas
            </span>
        `;
    }

    function iconForType(type) {
        if (type === 'upsell') return '<i class="bi bi-arrow-up-circle-fill"></i>';
        if (type === 'cross-sell') return '<i class="bi bi-shuffle"></i>';
        if (type === 'retention') return '<i class="bi bi-shield-fill-check"></i>';
        return '<i class="bi bi-lightbulb-fill"></i>';
    }

    ['filterType', 'filterSegment', 'filterLimit'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', loadRecommendations);
    });

    window.loadRecommendations = loadRecommendations;

    loadRecommendations();
})();