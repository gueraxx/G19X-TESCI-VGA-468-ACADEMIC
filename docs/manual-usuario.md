# 👤 Manual de Usuario — Customer 360

## Guía paso a paso para usar la plataforma

---

### 1. Introducción

Customer 360 es una plataforma web que te permite ver toda la información de tus clientes en un solo lugar, con análisis avanzado e inteligencia artificial.

---

### 2. Requisitos

- Navegador moderno (Chrome, Firefox, Edge, Safari)
- Conexión a internet (para la IA)
- Credenciales de acceso

---

### 3. Inicio de Sesión

1. Abre `http://localhost/customer360`
2. Ingresa tu email y contraseña
3. Clic en **Iniciar Sesión**

**Credenciales de prueba:**

| Rol | Email | Contraseña |
|-----|-------|-----------|
| Admin | admin@customer360.com | admin123 |
| Analyst | analyst@customer360.com | analyst123 |
| Sales | sales@customer360.com | sales123 |
| Viewer | viewer@customer360.com | viewer123 |

> ⚠️ Si ves "sesión expirada", vuelve a iniciar sesión.

---

### 4. Dashboard

Al iniciar sesión, verás el **Dashboard Ejecutivo** con:

**KPIs (arriba):**
- Total de clientes
- Clientes activos
- Clientes en alto riesgo
- Ingresos totales

**Gráficos:**
- Distribución por segmento (dona)
- Interacciones por tipo (barras)
- Evolución de ingresos (línea)
- Ingresos por canal (polar)

**Secciones adicionales:**
- Top 5 clientes por LTV
- Actividad reciente

---

### 5. Clientes

1. Ve al menú lateral → **Clientes**
2. Verás la tabla con todos los clientes
3. Usa el buscador para filtrar por nombre, email o empresa
4. Clic en 👁️ para ver el **perfil 360°**

---

### 6. Perfil 360°

Muestra todo sobre un cliente:

**Métricas superiores:**
- Gasto total
- Ticket promedio
- Número de transacciones
- Número de interacciones

**Tarjetas:**
- 📋 Datos del cliente (email, teléfono, empresa, ubicación, segmento)
- 🎯 Recomendaciones IA (upsell, cross-sell, retención)
- 💳 Historial de transacciones
- 📅 Timeline de interacciones

**Exportar a PDF:** clic en el botón **Exportar PDF** para guardar el perfil como PDF.

---

### 7. Churn (solo Admin y Analyst)

1. Menú lateral → **Churn**
2. Verás clientes con riesgo de abandono ordenados por criticidad
3. Cada cliente muestra:
   - Riesgo porcentual
   - Nivel (ALTO / MEDIO / BAJO)
   - LTV

**Recalcular:** clic en **Recalcular Churn** para actualizar los valores.

---

### 8. Segmentos (solo Admin y Analyst)

1. Menú lateral → **Segmentos**
2. Verás:
   - Distribución por segmento (dona)
   - Clientes por industria (barras horizontales)
   - Resumen por segmento (tabla)
   - Top 10 clientes por LTV

**Recalcular:** clic en **Recalcular Segmentos**.

---

### 9. Recomendaciones IA

1. Menú lateral → **Recomendaciones**
2. Verás:
   - **Banner de estado** (IA activa o modo reglas)
   - KPIs de recomendaciones
   - Filtros: tipo, segmento, límite
   - Lista de clientes con recomendaciones

**Tipos de recomendaciones:**
- 🎯 **Retención** — cliente en riesgo de abandono
- ⬆️ **Upsell** — cliente con potencial de upgrade
- 🔄 **Cross-sell** — cliente con oportunidad complementaria

**Badges:**
- 🤖 **IA** — generado por inteligencia artificial
- ⚙️ **Reglas** — generado por reglas de negocio
- ⚡ **desde caché** — recuperado de caché

**Forzar reglas:** agrega `?rules=1` a la URL.

---

### 10. Reportes

1. Menú lateral → **Reportes**
2. Verás:
   - KPIs generales
   - Botones de exportación
   - Gráficos de ingresos
   - Tabla resumen por segmento

**Exportar a CSV:**
- Clientes (CSV)
- Transacciones (CSV)
- Churn (CSV)

**Exportar a PDF:** clic en **Exportar PDF**.

---

### 11. Notificaciones

**Campana 🔔 en el topbar:**
- Muestra número de notificaciones no leídas
- Clic para abrir el dropdown
- Clic en una notificación para ir al cliente relacionado
- Clic en **Marcar todas leídas**

**Tipos:**
- 🔴 Cliente en riesgo alto
- 🟢 Nueva transacción
- 🔵 Cliente nuevo
- 🟡 Ticket negativo

---

### 12. Menú de Usuario

**Avatar arriba a la derecha:**

- 👤 Ver nombre, email y rol
- 🔑 **Cambiar contraseña**
- 🎨 **Cambiar tema** (claro/oscuro)
- 🚪 **Cerrar sesión**

---

### 13. Modo Oscuro

1. Clic en el botón 🌙 del topbar
2. La interfaz cambia a modo oscuro
3. Se guarda automáticamente
4. Para volver al modo claro, clic en ☀️

---

### 14. Gestión de Usuarios (solo Admin)

1. Menú lateral → **Usuarios**
2. Verás la tabla de usuarios
3. **Crear:** clic en **Nuevo Usuario**
4. **Editar:** clic en el ✏️
5. **Eliminar:** clic en el 🗑️ (con confirmación)

**Roles disponibles:**
- **Admin** — acceso total
- **Analyst** — churn, segmentos, reportes
- **Sales** — clientes, edición
- **Viewer** — solo lectura

---

### 15. Preguntas Frecuentes

**¿Por qué no veo el menú de "Churn"?**
Tu rol no tiene permiso. Solo Admin y Analyst pueden verlo.

**¿Por qué la IA no genera recomendaciones?**
Puede que no haya clave de Groq configurada. El sistema usará reglas como fallback.

**¿Qué significa el badge "⚡ desde caché"?**
La recomendación ya se había generado antes, y se recuperó del caché para ahorrar tiempo y tokens.

**¿Cómo exporto un reporte?**
En cada página de datos hay un botón de exportación. También puedes usar `Ctrl + P` para imprimir como PDF.

**¿Cómo cierro sesión?**
Clic en el avatar → **Cerrar sesión**.

---

### 16. Soporte

- 📧 Email: soporte@plurione.com
- 📚 Documentación: `/docs`
- 🐙 GitHub: [github.com/tu-usuario/customer360](https://github.com/tu-usuario/customer360)

---

**Última actualización:** [07/10/26]