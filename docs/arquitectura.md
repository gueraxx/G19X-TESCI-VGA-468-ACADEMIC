# 🏗️ Arquitectura — Customer 360

## Documento de Arquitectura Técnica

---

### 1. Visión General

Customer 360 es una aplicación web monolítica con arquitectura **cliente-servidor** y separación clara entre:

- **Frontend:** HTML + CSS + Bootstrap + JavaScript (vanilla)
- **Backend:** PHP 8+ con APIs RESTful
- **Base de datos:** MySQL 8
- **IA externa:** Groq API

---

### 2. Diagrama de Arquitectura
┌───────────────────────────────────────────────────────────┐
│ CAPA DE PRESENTACIÓN │
│ │
│ Navegador (Chrome, Firefox, Edge, Safari) │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ HTML5 + Bootstrap 5 + Chart.js + JavaScript │ │
│ │ - Dashboard - Clientes - Perfil 360° │ │
│ │ - Churn - Segmentos - Recomendaciones │ │
│ │ - Reportes - Usuarios - Login │ │
│ └─────────────────────────────────────────────────────┘ │
└────────────────────────┬──────────────────────────────────┘
│ HTTP/HTTPS (JSON)
┌────────────────────────▼──────────────────────────────────┐
│ CAPA DE APLICACIÓN │
│ │
│ Apache + PHP 8+ │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ /api/.php → Endpoints REST (JSON) │ │
│ │ ├── auth.php (login/logout) │ │
│ │ ├── dashboard.php (KPIs) │ │
│ │ ├── customers.php (CRUD) │ │
│ │ ├── churn.php (predicción) │ │
│ │ ├── segments.php (segmentación) │ │
│ │ ├── recommendations.php (IA) │ │
│ │ ├── reports.php (exportación) │ │
│ │ ├── notifications.php (alertas) │ │
│ │ └── users.php (admin) │ │
│ └─────────────────────────────────────────────────────┘ │
│ │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Middleware │ │
│ │ ├── auth.php (requireLogin/Role) │ │
│ │ └── ai_cache.php (caché de IA) │ │
│ └─────────────────────────────────────────────────────┘ │
└────────────┬──────────────────────────────┬───────────────┘
│ PDO │ HTTPS
│ │
┌────────────▼──────────────┐ ┌───────────▼───────────────┐
│ CAPA DE DATOS │ │ CAPA DE SERVICIOS IA │
│ │ │ │
│ MySQL 8 / MariaDB │ │ Groq API │
│ ┌─────────────────────┐ │ │ ┌─────────────────────┐ │
│ │ customers │ │ │ │ GPT-OSS 120B │ │
│ │ transactions │ │ │ │ - Generación texto │ │
│ │ interactions │ │ │ │ - JSON estructurado │ │
│ │ users │ │ │ └─────────────────────┘ │
│ │ ai_cache │ │ │ │
│ └─────────────────────┘ │ └───────────────────────────┘
└───────────────────────────┘

text

---

### 3. Componentes

#### 3.1 Frontend

| Archivo | Responsabilidad |
|---------|----------------|
| `index.php` | Dashboard principal |
| `customers.php` | Listado de clientes |
| `customer-detail.php` | Perfil 360° |
| `churn.php` | Clientes en riesgo |
| `segmentos.php` | Análisis de segmentos |
| `recomendaciones.php` | Recomendaciones IA |
| `reportes.php` | Reportes y exportación |
| `usuarios.php` | Gestión de usuarios (admin) |
| `login.php` | Autenticación |

#### 3.2 Backend (APIs)

| Endpoint | Método | Descripción |
|----------|:------:|-------------|
| `/api/auth.php` | GET/POST | Login, logout, check, change-password |
| `/api/dashboard.php` | GET | KPIs + gráficos |
| `/api/customers.php` | GET/POST/PUT/DELETE | CRUD de clientes |
| `/api/churn.php` | GET/POST | Listado y recálculo |
| `/api/segments.php` | GET/POST | Estadísticas y recálculo |
| `/api/recommendations.php` | GET | Recomendaciones individuales |
| `/api/recommendations-list.php` | GET | Recomendaciones masivas |
| `/api/reports.php` | GET | Reportes y exportación |
| `/api/notifications.php` | GET | Notificaciones del sistema |
| `/api/users.php` | GET/POST/PUT/DELETE | Gestión de usuarios |

#### 3.3 Middleware

**`config/auth.php`**
- `requireLogin()` — redirige a login si no hay sesión
- `requireRole(...$roles)` — valida rol del usuario
- `hasRole(...$roles)` — verifica sin cortar ejecución
- `currentUser()` — devuelve datos del usuario actual

**`config/ai_cache.php`**
- `getAICache($key)` — busca en caché
- `setAICache($key, $response)` — guarda en caché
- `cleanExpiredAICache()` — limpia entradas vencidas

---

### 4. Flujos Clave

#### 4.1 Autenticación
Usuario → login.php
↓
POST /api/auth.php?action=login
↓
Verifica email + password_verify()
↓
Crea sesión PHP ($_SESSION)
↓
Redirige a /index.php

text

#### 4.2 Generación de recomendaciones con IA
Usuario → recomendaciones.php
↓
JS → GET /api/recommendations-list.php
↓
Para cada cliente:
↓
¿Existe en caché? ──SÍ──► Devolver caché
│
NO
↓
POST a Groq API (GPT-OSS)
↓
Guardar en ai_cache
↓
Devolver recomendación
↓
JS renderiza con badge "🤖 IA"

text

#### 4.3 Cálculo de churn
POST /api/churn.php?action=recalculate
↓
Para cada cliente:
↓
¿Días sin compra? (>90, >60, >30)
¿Frecuencia de compra? (<3, <10)
¿Ticket promedio? (<50)
¿Estado? (inactive)
↓
Score = suma ponderada (0-1)
↓
UPDATE customers SET churn_risk = ?

text

---

### 5. Modelo de Datos
customers
├── id (PK)
├── external_id (UNIQUE)
├── first_name, last_name
├── email (UNIQUE)
├── phone, company, industry
├── country, city, birth_date
├── segment (bronze|silver|gold|platinum)
├── lifetime_value (DECIMAL)
├── churn_risk (FLOAT 0-1)
├── status (active|inactive|blocked)
└── created_at

transactions
├── id (PK)
├── customer_id (FK → customers)
├── external_id (UNIQUE)
├── amount, currency
├── channel (web|mobile|store|phone|partner)
├── status (pending|completed|refunded|cancelled)
└── transaction_date

interactions
├── id (PK)
├── customer_id (FK → customers)
├── type (call|email|chat|ticket|meeting|campaign)
├── source (crm|erp|sales|marketing|support)
├── subject, description
├── sentiment (positive|neutral|negative)
└── occurred_at

users
├── id (PK)
├── email (UNIQUE)
├── password_hash (bcrypt)
├── full_name
├── role (admin|analyst|sales|viewer)
├── is_active
└── last_login

ai_cache
├── id (PK)
├── cache_key (UNIQUE)
├── response (JSON)
├── model
├── hits
└── expires_at

text

---

### 6. Seguridad

| Aspecto | Implementación |
|---------|---------------|
| Contraseñas | `password_hash()` con bcrypt |
| Sesiones | PHP nativo con expiración (8h) |
| SQL Injection | PDO con prepared statements |
| XSS | `htmlspecialchars()` en salidas |
| CSRF | Verificación de sesión por endpoint |
| Roles | Middleware `requireRole()` |
| Credenciales | `.env` fuera de Git |

---

### 7. Decisiones Arquitectónicas

| Decisión | Alternativa | Razón |
|----------|-------------|-------|
| PHP vanilla | Framework (Laravel) | Simplicidad académica |
| MySQL | PostgreSQL | Disponibilidad en XAMPP |
| Vanilla JS | React/Vue | Sin build steps |
| Groq | Azure OpenAI | Costo cero para el proyecto |
| IIFE | Módulos ES6 | Compatibilidad sin transpilación |
| CSS custom | Tailwind | Bootstrap ya provee base |

---

**Última actualización:** [07/10/26]