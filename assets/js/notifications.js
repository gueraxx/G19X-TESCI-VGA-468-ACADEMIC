// ============================================================
// Customer 360 — Sistema de Notificaciones
// ============================================================

(function() {
    'use strict';

    console.log('🔔 notifications.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');
    const READ_KEY = 'customer360_read_notifications';

    function getReadNotifications() {
        try {
            return JSON.parse(localStorage.getItem(READ_KEY)) || [];
        } catch {
            return [];
        }
    }

    function markAsRead(id) {
        const read = getReadNotifications();
        if (!read.includes(id)) {
            read.push(id);
            localStorage.setItem(READ_KEY, JSON.stringify(read));
        }
    }

    function markAllAsRead(ids) {
        const read = getReadNotifications();
        ids.forEach(id => {
            if (!read.includes(id)) read.push(id);
        });
        localStorage.setItem(READ_KEY, JSON.stringify(read));
    }

    async function loadNotifications() {
        const list = document.getElementById('notifList');
        const badge = document.getElementById('notifBadge');
        const count = document.getElementById('notifCount');

        if (!list) return;

        try {
            const res = await fetch(`${BASE_URL}/api/notifications.php`);
            const data = await res.json();

            console.log('🔔 Notificaciones:', data);

            if (data.error) {
                list.innerHTML = `<div class="notif-empty">Error: ${data.error}</div>`;
                return;
            }

            if (!data.notifications.length) {
                list.innerHTML = `
                    <div class="notif-empty">
                        <i class="bi bi-bell-slash"></i>
                        <p>Sin notificaciones nuevas</p>
                    </div>
                `;
                badge.style.display = 'none';
                return;
            }

            const read = getReadNotifications();
            const unread = data.notifications.filter(n => !read.includes(n.id));

            if (unread.length > 0) {
                badge.textContent = unread.length > 9 ? '9+' : unread.length;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }

            count.textContent = data.total;

            list.innerHTML = data.notifications.map(n => {
                const isRead = read.includes(n.id);
                return `
                    <a href="${n.link}" class="notif-item notif-${n.type} ${isRead ? 'notif-read' : ''}"
                       data-id="${n.id}"
                       onclick="window.markNotificationAsRead('${n.id}')">
                        <div class="notif-icon">
                            <i class="bi ${n.icon}"></i>
                        </div>
                        <div class="notif-body">
                            <div class="notif-title">${n.title}</div>
                            <div class="notif-message">${n.message}</div>
                            <div class="notif-time">
                                <i class="bi bi-clock"></i> ${n.time}
                            </div>
                        </div>
                        ${!isRead ? '<span class="notif-dot"></span>' : ''}
                    </a>
                `;
            }).join('');

        } catch (error) {
            console.error('❌ Error cargando notificaciones:', error);
            list.innerHTML = `<div class="notif-empty">Error: ${error.message}</div>`;
        }
    }

    async function markAllRead() {
        try {
            const res = await fetch(`${BASE_URL}/api/notifications.php`);
            const data = await res.json();

            if (data.notifications) {
                const ids = data.notifications.map(n => n.id);
                markAllAsRead(ids);
                loadNotifications();

                const btn = document.querySelector('.notif-mark-read');
                if (btn) {
                    const original = btn.textContent;
                    btn.textContent = '✅ Hecho';
                    setTimeout(() => btn.textContent = original, 1500);
                }
            }
        } catch (error) {
            console.error('Error marcando todas:', error);
        }
    }

    function setupDropdown() {
        const toggle = document.getElementById('notifToggle');
        const dropdown = document.getElementById('notifDropdown');
        const wrapper = document.getElementById('notifWrapper');

        if (!toggle || !dropdown) return;

        // Asegurar estado cerrado al inicio
        wrapper.classList.remove('open');

        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            wrapper.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                wrapper.classList.remove('open');
            }
        });
    }

    let refreshInterval = null;
    function setupAutoRefresh() {
        if (refreshInterval) clearInterval(refreshInterval);
        refreshInterval = setInterval(() => {
            if (!document.hidden) {
                loadNotifications();
            }
        }, 60000);
    }

    window.markNotificationAsRead = markAsRead;
    window.markAllRead = markAllRead;

    setupDropdown();
    loadNotifications();
    setupAutoRefresh();
})();