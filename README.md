# 🚀 Customer 360

> **Plataforma Inteligente de Cliente** — PluriOne
> Proyecto de desarrollo de una solución Customer 360 con IA para unificar la visión del cliente.

![Status](https://img.shields.io/badge/status-En%20desarrollo-yellow)
![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.4-FF6384?logo=chartdotjs&logoColor=white)
![AI](https://img.shields.io/badge/AI-Groq%20%2F%20GPT--OSS-00A67E)
![License](https://img.shields.io/badge/license-Académico-blue)

---

## 📋 Tabla de Contenidos

- [Descripción](#-descripción)
- [Demo](#-demo)
- [Credenciales de Prueba](#-credenciales-de-prueba)
- [Características](#-características)
- [Stack Tecnológico](#-stack-tecnológico)
- [Arquitectura](#-arquitectura)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Base de Datos](#-base-de-datos)
- [Documentación](#-documentación)
- [Roadmap](#-roadmap)
- [Licencia](#-licencia)

---

## 📖 Descripción

**Customer 360** es una plataforma web que consolida una visión unificada del cliente integrando información de **CRM, ERP, ventas, marketing y soporte**. Utiliza inteligencia artificial generativa para producir:

- 👤 **Perfiles unificados 360°** del cliente
- 🔮 **Predicción de abandono** (churn)
- 🎯 **Recomendaciones personalizadas con IA** (upsell, cross-sell, retención)
- 🧩 **Segmentación automática** por valor de cliente
- 📊 **Dashboards ejecutivos** con KPIs en tiempo real

### Problema que resuelve

Las empresas tienen datos de clientes dispersos en múltiples sistemas, lo que impide una visión completa, dificulta la toma de decisiones y provoca pérdida de oportunidades comerciales y clientes.

### Solución

Una plataforma web unificada que centraliza todos los datos del cliente, aplica analítica avanzada con IA y entrega información accionable en segundos.

---

## 🌐 Demo

🔗 **URL de la demo:** _(pendiente de despliegue en InfinityFree)_

> ⚠️ **Nota:** la URL pública se agregará una vez que el proyecto esté desplegado. Mientras tanto, se puede ejecutar localmente con XAMPP siguiendo las instrucciones de instalación.

---

## 🔐 Credenciales de Prueba

El sistema cuenta con **4 roles** con permisos diferenciados:

| Rol | Email | Contraseña | Permisos |
|-----|-------|-----------|----------|
| 🔴 **Admin** | `admin@customer360.com` | `admin123` | Acceso total + gestión de usuarios |
| 🔵 **Analyst** | `analyst@customer360.com` | `analyst123` | Dashboard, churn, segmentos, reportes |
| 🟢 **Sales** | `sales@customer360.com` | `sales123` | Clientes, recomendaciones, edición |
| ⚪ **Viewer** | `viewer@customer360.com` | `viewer123` | Solo lectura |

> 💡 **Nota:** Estas credenciales son para fines de prueba y evaluación. En producción se deben cambiar.
> Puedes crear más usuarios desde `/usuarios.php` (solo como Admin).

### Matriz de permisos

| Funcionalidad | Admin | Analyst | Sales | Viewer |
|---------------|:-----:|:-------:|:-----:|:------:|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Ver clientes | ✅ | ✅ | ✅ | ✅ |
| Crear/editar clientes | ✅ | ❌ | ✅ | ❌ |
| Eliminar clientes | ✅ | ❌ | ❌ | ❌ |
| Ver churn | ✅ | ✅ | ❌ | ❌ |
| Recalcular churn | ✅ | ✅ | ❌ | ❌ |
| Ver segmentos | ✅ | ✅ | ❌ | ❌ |
| Recalcular segmentos | ✅ | ✅ | ❌ | ❌ |
| Ver recomendaciones IA | ✅ | ✅ | ✅ | ✅ |
| Exportar PDF/CSV | ✅ | ✅ | ✅ | ✅ |
| Gestionar usuarios | ✅ | ❌ | ❌ | ❌ |

---

## ✨ Características

### 📊 Dashboard Ejecutivo
- KPIs animados: total clientes, activos, churn alto, ingresos
- 4 gráficos interactivos: segmentos, interacciones, evolución de ingresos, canales
- Top 5 clientes por LTV
- Actividad reciente

### 👥 Gestión de Clientes
- Listado con búsqueda instantánea
- Filtros por segmento y estado
- CRUD completo (crear, editar, eliminar según rol)
- Perfil 360° con datos completos

### 👤 Perfil 360°
- Datos demográficos y de empresa
- Timeline de interacciones con iconos y agrupación por fecha
- Historial completo de transacciones
- Métricas calculadas: LTV, ticket promedio, días sin compra

### 🔮 Predicción de Churn
- Algoritmo heurístico basado en múltiples factores
- Clasificación automática: Bajo / Medio / Alto
- Recalculo manual bajo demanda (admin/analyst)

### 🧩 Segmentación Automática
- **Bronce:** LTV < $5,000
- **Plata:** $5,000 - $19,999
- **Oro:** $20,000 - $49,999
- **Platino:** LTV ≥ $50,000

### 🎯 Recomendaciones con IA Generativa
- Integración con **Groq** (modelo `openai/gpt-oss-120b`)
- Recomendaciones contextuales generadas por IA
- Fallback automático a reglas de negocio si la IA falla
- Caché inteligente (24h) para no gastar tokens repetidos
- Badges visuales que distinguen IA vs Reglas

### 🔔 Notificaciones Inteligentes
- Dropdown en el topbar con notificaciones en tiempo real
- 4 tipos: churn alto, transacciones recientes, clientes nuevos, tickets negativos
- Marcado de leídas con persistencia en localStorage
- Auto-refresh cada 60 segundos

### 📤 Exportación
- Exportar cualquier página a PDF con estilos optimizados
- Exportar datos a CSV (clientes, transacciones, churn)

### 🔐 Autenticación y Seguridad
- Login con contraseñas hasheadas (bcrypt)
- Sesiones PHP con expiración automática (8 horas)
- Sistema de roles y permisos granular
- Consultas preparadas con PDO (previene SQL injection)
- Validación de sesión en todas las APIs
- Cambio de contraseña desde el menú de usuario

### 🌙 Extras
- Modo oscuro con persistencia
- Diseño responsive
- Animaciones suaves
- Estilos optimizados para impresión

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript (vanilla) |
| **Gráficos** | Chart.js 4 |
| **Iconos** | Bootstrap Icons |
| **Backend** | PHP 8+ |
| **Base de datos** | MySQL 8 / MariaDB |
| **IA** | Groq API (GPT-OSS 120B) |
| **Servidor local** | Apache (XAMPP) |
| **Control de versiones** | Git + GitHub |

---

## 🏗️ Arquitectura

```
┌─────────────────────────────────────────────────────────┐
│                    NAVEGADOR (Cliente)                  │
│   HTML + CSS + Bootstrap + JavaScript + Chart.js        │
└──────────────────────────┬──────────────────────────────┘
                           │ HTTP / JSON
┌──────────────────────────▼──────────────────────────────┐
│                    SERVIDOR APACHE                      │
│                                                         │
│  ┌─────────────────┐        ┌────────────────────────┐  │
│  │  Páginas PHP    │        │   API PHP (JSON)       │  │
│  │  (Vistas)       │◄──────►│   /api/*.php           │  │
│  └─────────────────┘        └───────────┬────────────┘  │
│                                         │               │
└─────────────────────────────────────────┼───────────────┘
                                          │ PDO
                                ┌─────────▼─────────┐
                                │   MySQL / MariaDB │
                                │   customer360     │
                                └─────────┬─────────┘
                                          │
                                          │ API REST (HTTPS)
                                ┌─────────▼─────────┐
                                │   Groq (IA)       │
                                │   GPT-OSS 120B    │
                                └───────────────────┘
```

---

## 🚀 Instalación

### Requisitos previos

- **XAMPP** (Apache + PHP 8+ + MySQL)
- **Git** (opcional)
- **Navegador moderno** (Chrome, Firefox, Edge)

### ⚠️ Nota sobre el nombre de la carpeta

El código funciona con **cualquier nombre de carpeta** gracias al helper `basePath()` que detecta automáticamente la ruta base. Si tu carpeta se llama `customer360` o `G19X-TESCI-VGA-468-ACADEMIC`, el sistema se adapta.

### Paso 1: Clonar o descargar

```bash
cd C:\xampp\htdocs
git clone https://github.com/gueraxx/G19X-TESCI-VGA-468-ACADEMIC.git
```

O descarga el ZIP y descomprímelo en `C:\xampp\htdocs\`.

### Paso 2: Arrancar servicios

1. Abre **XAMPP Control Panel**
2. Inicia **Apache** ✅
3. Inicia **MySQL** ✅

### Paso 3: Importar la base de datos

1. Abre [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Crea una base de datos llamada `customer360` (utf8mb4_unicode_ci)
3. Selecciónala → pestaña **Importar**
4. Sube el archivo `database/customer360.sql`
5. Clic en **Continuar**

> 💡 El script SQL crea automáticamente las tablas `users`, `customers`, `transactions`, `interactions` y `ai_cache`, e inserta los datos de prueba (incluidos los 4 usuarios).

### Paso 4: Configurar variables de entorno

```bash
cp .env.example .env
```

Edita `.env` con tus datos:

```env
DB_HOST=127.0.0.1
DB_PORT=3306          # Cambia si tu MySQL usa otro puerto (ej. 3308)
DB_NAME=customer360
DB_USER=root
DB_PASSWORD=
GROQ_API_KEY=gsk_TU_CLAVE_AQUI
GROQ_MODEL=openai/gpt-oss-120b
```

> ⚠️ **Si usas un puerto distinto** (ej. 3308), asegúrate de ajustar `DB_PORT` en el `.env`.

### Paso 5: Obtener clave de Groq (IA)

1. Regístrate en [https://console.groq.com/](https://console.groq.com/) (gratis)
2. Ve a **API Keys** → **Create API Key**
3. Copia la clave y pégala en `.env` (`GROQ_API_KEY`)

> 💡 Si no pones clave, el sistema usará **reglas de negocio** como fallback y seguirá funcionando.

### Paso 6: Abrir en el navegador

```
http://localhost/customer360
```

Serás redirigido al login. Usa cualquiera de las credenciales de prueba. 🎉

---

## ⚙️ Configuración

### Variables de entorno

| Variable | Descripción | Requerido |
|----------|-------------|:---------:|
| `APP_ENV` | Entorno (`local`/`production`) | ⬜ |
| `APP_DEBUG` | Modo debug | ⬜ |
| `DB_HOST` | Host de MySQL | ✅ |
| `DB_PORT` | Puerto de MySQL | ✅ |
| `DB_NAME` | Nombre de la base de datos | ✅ |
| `DB_USER` | Usuario de MySQL | ✅ |
| `DB_PASSWORD` | Contraseña de MySQL | ✅ |
| `GROQ_API_KEY` | Clave de Groq para IA | ⬜ |
| `GROQ_MODEL` | Modelo de Groq | ⬜ |
| `SESSION_LIFETIME_HOURS` | Duración de sesión | ⬜ |
| `AI_CACHE_TTL_HOURS` | TTL de caché de IA | ⬜ |

⚠️ **Nunca subas el archivo `.env` a Git.** Ya está en `.gitignore`.

---

## 🎮 Uso

### Páginas principales

| Página | URL | Descripción | Roles |
|--------|-----|-------------|-------|
| **Login** | `/login.php` | Inicio de sesión | Público |
| **Bienvenida** | `/bienvenida.php` | Landing page | Todos |
| **Dashboard** | `/index.php` | KPIs y gráficos | Todos |
| **Clientes** | `/customers.php` | Listado y CRUD | Todos (editar: admin/sales) |
| **Perfil 360°** | `/customer-detail.php?id=1` | Vista unificada | Todos |
| **Churn** | `/churn.php` | Clientes en riesgo | Admin, Analyst |
| **Segmentos** | `/segmentos.php` | Análisis de segmentación | Admin, Analyst |
| **Recomendaciones** | `/recomendaciones.php` | Recomendaciones IA | Todos |
| **Reportes** | `/reportes.php` | Reportes y exportación | Todos |
| **Usuarios** | `/usuarios.php` | Gestión de usuarios | Admin |

### Endpoints API

| Endpoint | Método | Descripción | Auth |
|----------|:------:|-------------|:----:|
| `/api/auth.php?action=login` | POST | Iniciar sesión | ❌ |
| `/api/auth.php?action=logout` | POST | Cerrar sesión | ✅ |
| `/api/auth.php?action=check` | GET | Verificar autenticación | ❌ |
| `/api/auth.php?action=change-password` | POST | Cambiar contraseña | ✅ |
| `/api/dashboard.php` | GET | KPIs y datos del dashboard | ✅ |
| `/api/customers.php` | GET | Listado de clientes | ✅ |
| `/api/customers.php?id=1` | GET | Perfil 360° del cliente | ✅ |
| `/api/customers.php` | POST | Crear cliente | ✅ (admin/sales) |
| `/api/customers.php?id=1` | PUT | Actualizar cliente | ✅ (admin/sales) |
| `/api/customers.php?id=1` | DELETE | Eliminar cliente | ✅ (admin) |
| `/api/churn.php` | GET | Clientes con riesgo | ✅ |
| `/api/churn.php?action=recalculate` | POST | Recalcular churn | ✅ (admin/analyst) |
| `/api/segments.php` | GET | Estadísticas de segmentos | ✅ |
| `/api/segments.php?action=recalculate` | POST | Recalcular segmentos | ✅ (admin/analyst) |
| `/api/recommendations-list.php` | GET | Recomendaciones de todos | ✅ |
| `/api/recommendations.php?id=1` | GET | Recomendaciones de un cliente | ✅ |
| `/api/reports.php` | GET | Resumen general | ✅ |
| `/api/reports.php?type=customers&format=csv` | GET | Exportar CSV | ✅ |
| `/api/notifications.php` | GET | Notificaciones del sistema | ✅ |
| `/api/users.php` | GET/POST/PUT/DELETE | Gestión de usuarios | ✅ (admin) |

---

## 📁 Estructura del Proyecto

```
customer360/
│
├── api/                          # Endpoints REST (JSON)
│   ├── auth.php
│   ├── dashboard.php
│   ├── customers.php
│   ├── churn.php
│   ├── recommendations.php
│   ├── recommendations-list.php
│   ├── segments.php
│   ├── reports.php
│   ├── notifications.php
│   └── users.php
│
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── print.css
│   └── js/
│       ├── dashboard.js
│       ├── customers.js
│       ├── customer-detail.js
│       ├── churn.js
│       ├── segments.js
│       ├── recommendations.js
│       ├── reports.js
│       ├── notifications.js
│       ├── users.js
│       ├── theme.js
│       ├── export.js
│       ├── permissions.js
│       ├── user-menu.js
│       └── login.js
│
├── config/
│   ├── auth.php                 # Middleware + basePath()
│   ├── ai_cache.php             # Sistema de caché de IA
│   ├── database.php             # Configuración BD
│   └── database.local.php.example
│
├── database/
│   └── customer360.sql          # Script completo con datos de prueba
│
├── docs/                         # Documentación del proyecto
│   ├── prd.md
│   ├── mvp.md
│   ├── arquitectura.md
│   ├── manual-usuario.md
│   ├── plan-pruebas.md
│   ├── changelog.md
│   └── screenshots/
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── .env.example
├── .gitignore
├── README.md
├── accesos.md                    # 🔒 NO se sube (en .gitignore)
├── login.php
├── bienvenida.php
├── index.php
├── customers.php
├── customer-detail.php
├── churn.php
├── segmentos.php
├── recomendaciones.php
├── reportes.php
└── usuarios.php
```

---

## 🗄️ Base de Datos

### Tablas

```
customers          → Clientes
transactions       → Compras/transacciones
interactions       → Llamadas, emails, tickets
users              → Usuarios del sistema con roles
ai_cache           → Caché de recomendaciones IA
```

### Datos de prueba incluidos

El script `database/customer360.sql` incluye:
- ✅ **5 clientes** con diferentes segmentos
- ✅ **7 transacciones** distribuidas en el tiempo
- ✅ **5 interacciones** de distintos tipos
- ✅ **4 usuarios** (uno por cada rol)
- ✅ **0 registros** en `ai_cache` (se llena automáticamente)

---

## 📚 Documentación

| Documento | Descripción |
|-----------|-------------|
| [PRD](docs/prd.md) | Product Requirements Document |
| [MVP](docs/mvp.md) | Minimum Viable Product |
| [Arquitectura](docs/arquitectura.md) | Documento de arquitectura técnica |
| [Manual de Usuario](docs/manual-usuario.md) | Guía de uso paso a paso |
| [Plan de Pruebas](docs/plan-pruebas.md) | QA y testing |
| [Changelog](docs/changelog.md) | Historial de versiones |

---

## 🗺️ Roadmap

### ✅ v1.0 (actual)

- Login con roles y permisos
- Dashboard con 4 gráficos
- CRUD de clientes
- Perfil 360° con timeline
- Predicción de churn
- Segmentación automática
- Recomendaciones con IA generativa
- Sistema de notificaciones
- Exportación a PDF y CSV
- Modo oscuro
- Gestión de usuarios

### 🔜 v2.0 (futuro)

- Autenticación con Microsoft Entra ID (SSO)
- Integración real con CRM/ERP
- Power BI embebido
- App móvil (PWA)
- Notificaciones por email
- Multi-idioma
- Chatbot con IA
- Paginación server-side

---

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/nueva-funcionalidad`)
3. Commit (`git commit -m 'feat: agregar nueva funcionalidad'`)
4. Push (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

### Convención de commits

- `feat:` nueva funcionalidad
- `fix:` corrección de bug
- `docs:` documentación
- `style:` formato/CSS
- `refactor:` reestructuración
- `chore:` mantenimiento

---

## 📝 Licencia

Proyecto desarrollado con fines **académicos** para **PluriOne**.
Todos los derechos reservados © 2025.

---

## 🙏 Agradecimientos

- **PluriOne** por la oportunidad del proyecto
- **XAMPP** por el entorno de desarrollo
- **Bootstrap** por el framework CSS
- **Chart.js** por las gráficas
- **Groq** por el acceso gratuito a IA generativa

---

<div align="center">

**⭐ Si este proyecto te fue útil, dale una estrella en GitHub ⭐**

Hecho con ❤️ por el equipo de Customer 360

</div>