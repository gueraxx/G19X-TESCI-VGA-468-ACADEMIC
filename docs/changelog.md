# 📝 Changelog — Customer 360

Todos los cambios notables del proyecto.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es/1.0.0/).

---
## [1.3.0] — 2026-10-27

### 🐛 Corregido
- **`database/customer360.sql`**: ajustados los valores de `segment` y `churn_risk` de 14 clientes para que coincidan exactamente con la lógica de los botones «Recalcular» de la app.
- **`README.md`**: corregida la cantidad de datos de prueba (25 clientes) y arreglados los enlaces a la documentación que tenían errores de mayúsculas (ej. `docs/prd.md` → `docs/PRD.md`).
- **`docs/MVP.md`**: corregido el enlace de la bitácora de evidencias.

### ✨ Añadido
- **Bitácora de instalación limpia** (`docs/evidencias/instalacion-limpia-2026-10-27.md`): con el paso a paso, correcciones y capturas de pantalla.
- **Sección "Uso de IA"** en el README para transparentar el desarrollo.

---
## [1.2.0] — 2026-10-23

### 🐛 Corregido

- **`api/notifications.php`**: eliminado `<?= basePath() ?>` dentro de strings PHP que rompía los enlaces de las notificaciones.
- **`assets/js/notifications.js`**: ahora antepone `BASE_URL` a los links de notificaciones.
- **`README.md`**: corregido `git clone` para apuntar al repositorio real (`gueraxx/G19X-TESCI-VGA-468-ACADEMIC`).
- **`docs/manual-usuario.md`**: rutas actualizadas, ya no menciona `/customer360/` fijo.

### ✨ Añadido

- **`database/customer360.sql`**: agregados 20 clientes adicionales para demo (total: 25).
- **`docs/changelog.md`**: esta entrada.

### 🔧 Cambiado

- **`docs/MVP.md`**: movidas las casillas de "en verificación" a "verificadas" tras instalación exitosa en carpeta con el nombre real del repositorio.

---

## [1.1.0] — 2026-10-20

### 🐛 Corregido

- **`api/recommendations-list.php`**: eliminada `env()` duplicada que causaba error fatal.
- **Páginas PHP**: `churn.php` ahora tiene `requireLogin()`.
- **`config/auth.php`**: agregado `basePath()` para rutas relativas.
- **`includes/header.php` y `footer.php`**: usan `basePath()`.
- **Todos los `.js`**: usan `BASE_URL` dinámico.
- **`config/database.php`**: errores internos ahora van al log, no al cliente.

### 🗑️ Eliminado

- **`setup-hashes.php` y `setup-users.php`**: expuestos sin login y con contraseñas en texto plano.
- **Rutas fijas `/customer360/`**: reemplazadas por `basePath()` / `BASE_URL`.

### 🔧 Cambiado

- **`docs/MVP.md` v1.1**: separadas las secciones "verificadas" de "en verificación".
- **`README.md`**: advertido que la carpeta puede tener cualquier nombre.

---

## [1.0.0] — 2026-10-14

### ✨ Añadido

- Autenticación con roles (admin, analyst, sales, viewer)
- Dashboard ejecutivo con KPIs y 4 gráficos
- Gestión de clientes con búsqueda y CRUD
- Perfil 360° con timeline de interacciones
- Predicción de churn heurística
- Segmentación automática por LTV
- Recomendaciones con IA generativa (Groq + GPT-OSS 120B)
- Caché de respuestas de IA (24h)
- Sistema de notificaciones inteligentes
- Exportación a CSV y PDF
- Modo oscuro con persistencia
- Gestión de usuarios (solo admin)
- Diseño responsive
- Documentación completa (PRD, MVP, Manual, Arquitectura)
- Script SQL completo con tablas `users` y `ai_cache`

---

**Última actualización:** 2026-10-23
**Versión actual:** 1.2.0