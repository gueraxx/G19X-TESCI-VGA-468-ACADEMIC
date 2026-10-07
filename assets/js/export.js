// ============================================================
// Customer 360 — Exportar a PDF
// ============================================================

(function() {
    'use strict';

    console.log('📤 export.js cargado');

    function exportToPDF(title = '') {
        const originalTitle = document.title;

        const now = new Date();
        const dateStr = now.toLocaleDateString('es-MX', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.body.setAttribute('data-print-date', dateStr);

        if (title) {
            document.title = `${title} — Customer 360`;
        }

        setTimeout(() => {
            window.print();
            setTimeout(() => {
                document.title = originalTitle;
            }, 1000);
        }, 100);
    }

    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            exportToPDF();
        }
    });

    (function setPrintDate() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('es-MX', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.body.setAttribute('data-print-date', dateStr);
    })();

    window.exportToPDF = exportToPDF;
})();