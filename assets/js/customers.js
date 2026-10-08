// ============================================================
// Customer 360 — Clientes (con CRUD)
// ============================================================

(function() {
    'use strict';

    console.log('🚀 customers.js cargado');

    const BASE_URL = window.location.pathname.replace(/\/[^/]*$/, '').replace(/\/$/, '');
    const ROLE = document.body.dataset.userRole || 'viewer';
    const CAN_EDIT = ['admin', 'sales'].includes(ROLE);
    const CAN_DELETE = ROLE === 'admin';

    // ============================================================
    // Listar clientes
    // ============================================================
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
                <tr class="fade-in-up" style="animation-delay: ${i * 0.02}s">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width:36px;height:36px;font-size:0.8rem;">
                                ${(c.first_name[0] || '') + (c.last_name[0] || '')}
                            </div>
                            <div>
                                <strong>${c.first_name} ${c.last_name}</strong>
                                ${c.status !== 'active' ? '<br><small class="text-muted">' + c.status + '</small>' : ''}
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">${c.email}</td>
                    <td>${c.company || '-'}</td>
                    <td><span class="badge-segment badge-${c.segment}">${c.segment}</span></td>
                    <td><strong>$${parseFloat(c.lifetime_value).toLocaleString()}</strong></td>
                    <td>${renderChurnBadge(c.churn_risk)}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="${BASE_URL}/customer-detail.php?id=${c.id}" class="btn btn-sm btn-outline-primary" title="Ver perfil">
                                <i class="bi bi-eye"></i>
                            </a>
                            ${CAN_EDIT ? `
                                <button class="btn btn-sm btn-outline-secondary" title="Editar" onclick='editCustomer(${JSON.stringify(c).replace(/'/g, "&#39;")})'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                            ` : ''}
                            ${CAN_DELETE ? `
                                <button class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="deleteCustomer(${c.id}, '${(c.first_name + ' ' + c.last_name).replace(/'/g, "&#39;")}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            ` : ''}
                        </div>
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

    // ============================================================
    // Modal: Crear
    // ============================================================
    function openCustomerModal() {
        const modal = document.getElementById('customerModal');
        const form = document.getElementById('customerForm');

        if (!modal || !form) return;

        form.reset();
        form.dataset.mode = 'create';
        form.dataset.customerId = '';

        document.getElementById('customerModalTitle').textContent = 'Nuevo Cliente';
        document.getElementById('customerError').style.display = 'none';

        modal.classList.add('open');
        setTimeout(() => form.first_name?.focus(), 100);
    }

    // ============================================================
    // Modal: Editar
    // ============================================================
    function editCustomer(customer) {
        const modal = document.getElementById('customerModal');
        const form = document.getElementById('customerForm');

        if (!modal || !form) return;

        form.dataset.mode = 'edit';
        form.dataset.customerId = customer.id;

        document.getElementById('customerModalTitle').textContent = 'Editar Cliente';
        document.getElementById('customerError').style.display = 'none';

        // Llenar campos
        Object.keys(customer).forEach(key => {
            const field = form.querySelector(`[name="${key}"]`);
            if (field) field.value = customer[key] ?? '';
        });

        modal.classList.add('open');
    }

    // ============================================================
    // Cerrar modal
    // ============================================================
    function closeCustomerModal() {
        document.getElementById('customerModal')?.classList.remove('open');
    }

    // ============================================================
    // Guardar (crear o editar)
    // ============================================================
    async function submitCustomer(e) {
        e.preventDefault();

        const form = e.target;
        const mode = form.dataset.mode;
        const customerId = form.dataset.customerId;
        const errBox = document.getElementById('customerError');
        const btn = document.getElementById('customerSubmit');

        errBox.style.display = 'none';

        // Recolectar datos
        const payload = {
            first_name: form.first_name.value.trim(),
            last_name: form.last_name.value.trim(),
            email: form.email.value.trim(),
            phone: form.phone.value.trim() || null,
            company: form.company.value.trim() || null,
            industry: form.industry.value.trim() || null,
            country: form.country.value.trim() || null,
            city: form.city.value.trim() || null,
            segment: form.segment.value,
            status: form.status.value
        };

        // Validaciones básicas
        if (!payload.first_name || !payload.last_name || !payload.email) {
            showError('Nombre, apellido y email son obligatorios');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

        try {
            let url = `${BASE_URL}/api/customers.php`;
            let method = 'POST';

            if (mode === 'edit') {
                url += `?id=${customerId}`;
                method = 'PUT';
            }

            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (!res.ok || data.error) {
                showError(data.error || 'Error al guardar');
                return;
            }

            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Listo!';

            setTimeout(() => {
                closeCustomerModal();
                loadCustomers();
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar';
                showToast(mode === 'edit' ? 'Cliente actualizado' : 'Cliente creado', 'success');
            }, 700);

        } catch (error) {
            showError('Error de conexión: ' + error.message);
        }
    }

    function showError(message) {
        const errBox = document.getElementById('customerError');
        const btn = document.getElementById('customerSubmit');

        errBox.textContent = message;
        errBox.style.display = 'flex';
        errBox.classList.add('shake');
        setTimeout(() => errBox.classList.remove('shake'), 500);

        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Guardar';
    }

    // ============================================================
    // Eliminar cliente
    // ============================================================
    async function deleteCustomer(id, name) {
        const confirmed = confirm(
            `¿Eliminar a "${name}"?\n\n` +
            `• Sí = Soft delete (se desactiva, recomendado)\n` +
            `• Aceptar con Shift = Eliminar permanentemente`
        );

        if (!confirmed) return;

        try {
            const res = await fetch(`${BASE_URL}/api/customers.php?id=${id}`, { method: 'DELETE' });
            const data = await res.json();

            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }

            loadCustomers();
            showToast(data.message || 'Cliente eliminado', 'success');
        } catch (error) {
            alert('Error: ' + error.message);
        }
    }

    // ============================================================
    // Toast de notificación
    // ============================================================
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `crud-toast crud-toast-${type}`;
        toast.innerHTML = `
            <i class="bi bi-check-circle-fill"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ============================================================
    // Búsqueda con debounce
    // ============================================================
    let timeout;
    document.getElementById('searchInput')?.addEventListener('input', (e) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => loadCustomers(e.target.value), 300);
    });

    // ============================================================
    // Exponer al scope global
    // ============================================================
    window.loadCustomers = loadCustomers;
    window.openCustomerModal = openCustomerModal;
    window.editCustomer = editCustomer;
    window.closeCustomerModal = closeCustomerModal;
    window.submitCustomer = submitCustomer;
    window.deleteCustomer = deleteCustomer;

    // ============================================================
    // Init
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => loadCustomers());
    } else {
        loadCustomers();
    }
})();