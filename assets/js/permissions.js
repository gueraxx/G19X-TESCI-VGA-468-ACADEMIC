(function() {
    'use strict';

    console.log('🔐 permissions.js cargado');

    const CURRENT_ROLE = document.body.dataset.userRole || 'viewer';

    console.log('👤 Rol actual:', CURRENT_ROLE);

    function canEdit() {
        return ['admin', 'sales'].includes(CURRENT_ROLE);
    }

    function canRecalculate() {
        return ['admin', 'analyst'].includes(CURRENT_ROLE);
    }

    function canManageUsers() {
        return CURRENT_ROLE === 'admin';
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-permission="edit"]').forEach(el => {
            if (!canEdit()) el.style.display = 'none';
        });

        document.querySelectorAll('[data-permission="recalculate"]').forEach(el => {
            if (!canRecalculate()) el.style.display = 'none';
        });

        document.querySelectorAll('[data-permission="admin"]').forEach(el => {
            if (!canManageUsers()) el.style.display = 'none';
        });

        document.querySelectorAll('[data-permission-role]').forEach(el => {
            const allowed = el.dataset.permissionRole.split(',').map(r => r.trim());
            if (!allowed.includes(CURRENT_ROLE)) el.style.display = 'none';
        });
    });

    window.canEdit = canEdit;
    window.canRecalculate = canRecalculate;
    window.canManageUsers = canManageUsers;
})();