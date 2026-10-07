# 🚀 Customer 360

> **Plataforma Inteligente de Cliente** 
> Proyecto de desarrollo de una solución Customer 360 con IA para unificar la visión del cliente.

![Status](https://img.shields.io/badge/status-MVP%20funcional-success)
![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.4-FF6384?logo=chartdotjs&logoColor=white)
![License](https://img.shields.io/badge/license-Académico-blue)

---

## 📋 Tabla de Contenidos

- [Descripción](#-descripción)
- [Demo en Vivo](#-demo-en-vivo)
- [Características](#-características)
- [Stack Tecnológico](#-stack-tecnológico)
- [Arquitectura](#-arquitectura)
- [Instalación](#-instalación)
- [Uso](#-uso)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Base de Datos](#-base-de-datos)
- [Capturas de Pantalla](#-capturas-de-pantalla)
- [Documentación](#-documentación)
- [Equipo](#-equipo)
- [Licencia](#-licencia)

---

## 📖 Descripción

**Customer 360** es una plataforma web que consolida una visión unificada del cliente integrando información de **CRM, ERP, ventas, marketing y soporte**. Utiliza inteligencia artificial para generar:

- 👤 **Perfiles unificados 360°** del cliente
- 🔮 **Predicción de abandono** (churn)
- 🎯 **Recomendaciones personalizadas** (upsell, cross-sell, retención)
- 🧩 **Segmentación automática** por valor de cliente
- 📊 **Dashboards ejecutivos** con KPIs en tiempo real

### Problema que resuelve

Las empresas tienen datos de clientes dispersos en múltiples sistemas, lo que impide una visión completa, dificulta la toma de decisiones y provoca pérdida de oportunidades comerciales y clientes.

### Solución

Una plataforma web unificada que centraliza todos los datos del cliente, aplica analítica avanzada con IA y entrega información accionable en segundos.

---

## 🌐 Demo en Vivo

🔗 **URL de la demo:** [http://customer360.infinityfreeapp.com](http://customer360.infinityfreeapp.com) _(ejemplo — actualiza con tu URL real)_

**Credenciales de prueba:**
| Rol | Usuario | Contraseña |
|-----|---------|------------|
| Admin | admin@customer360.com | admin123 |
| Ventas | ventas@customer360.com | ventas123 |
| Viewer | viewer@customer360.com | viewer123 |

> 💡 La demo está desplegada en InfinityFree con PHP + MySQL.
> Si el hosting está suspendido por inactividad, se reactiva automáticamente al entrar.

---

## ✨ Características

### 📊 Dashboard Ejecutivo
- KPIs animados: total clientes, activos, churn alto, ingresos
- Gráficos interactivos: distribución por segmento, interacciones por tipo
- Actividad reciente en tiempo real

### 👥 Gestión de Clientes
- Listado paginado con búsqueda instantánea
- Filtros por segmento, industria y estado
- Vista de tarjetas y tabla

### 👤 Perfil 360°
- Datos demográficos y de empresa
- Historial completo de transacciones
- Registro de interacciones (calls, emails, tickets, etc.)
- Métricas calculadas: LTV, ticket promedio, días sin compra

### 🔮 Predicción de Churn
- Algoritmo heurístico basado en:
  - Días desde la última compra
  - Frecuencia de transacciones
  - Ticket promedio
  - Estado del cliente
- Clasificación automática: Bajo / Medio / Alto
- Recalculo manual bajo demanda

### 🧩 Segmentación Automática
- **Bronce:** LTV < $5,000
- **Plata:** $5,000 - $19,999
- **Oro:** $20,000 - $49,999
- **Platino:** LTV ≥ $50,000
- Análisis por segmento, industria y país

### 🎯 Recomendaciones IA
- **Retención:** si churn ≥ 0.6
- **Upsell:** si es Gold/Platinum con bajo churn
- **Cross-sell:** si es Bronce/Plata
- Con prioridad, confianza y razón

### 📈 Reportes
- Exportación a CSV (clientes, transacciones, churn)
- Gráficos: ingresos por mes, por canal
- Opción de imprimir / PDF

### 🔐 Seguridad
- Login con contraseñas hasheadas (bcrypt)
- Roles y permisos por usuario
- Protección SQL injection (PDO preparado)
- Sesiones seguras

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript (vanilla) |
| **Gráficos** | Chart.js 4 |
| **Iconos** | Bootstrap Icons |
| **Backend** | PHP 8+ |
| **Base de datos** | MySQL 8 / MariaDB |
| **Servidor local** | Apache (XAMPP) |
| **Control de versiones** | Git + GitHub |
| **Hosting demo** | InfinityFree |

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
                                └───────────────────┘
```

---

## 🚀 Instalación

### Requisitos previos

- **XAMPP** (o cualquier stack Apache + PHP 8+ + MySQL)
- **Git** (opcional, para clonar)
- **Navegador moderno** (Chrome, Firefox, Edge)

### Paso 1: Clonar o descargar el proyecto

```bash
cd C:\xampp\htdocs
git clone https://github.com/TU-USUARIO/customer360.git
```

O descarga el ZIP desde GitHub y descomprímelo en `C:\xampp\htdocs\customer360`.

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

### Paso 4: Configurar credenciales

Copia el archivo de ejemplo:

```bash
cp config/database.local.php.example config/database.local.php
```

Edita `config/database.local.php` con tus datos:

```php
return [
    'host' => '127.0.0.1',
    'port' => 3306,          // Cambia si tu MySQL usa otro puerto (ej. 3308)
    'name' => 'customer360',
    'user' => 'root',
    'pass' => ''             // En XAMPP por defecto va vacío
];
```

### Paso 5: Abrir en el navegador

```
http://localhost/customer360
```

¡Listo! 🎉

---

## 🎮 Uso

### Páginas principales

| Página | URL | Descripción |
|--------|-----|-------------|
| **Bienvenida** | `/bienvenida.php` | Landing page |
| **Dashboard** | `/` | KPIs y gráficos ejecutivos |
| **Clientes** | `/customers.php` | Listado y búsqueda |
| **Perfil 360°** | `/customer-detail.php?id=1` | Vista unificada del cliente |
| **Churn** | `/churn.php` | Clientes en riesgo |
| **Segmentos** | `/segmentos.php` | Análisis de segmentación |
| **Recomendaciones** | `/recomendaciones.php` | Acciones sugeridas por IA |
| **Reportes** | `/reportes.php` | Exportar datos y reportes |

### Endpoints API

| Endpoint | Descripción |
|----------|-------------|
| `GET /api/dashboard.php` | KPIs y datos del dashboard |
| `GET /api/customers.php` | Listado de clientes |
| `GET /api/customers.php?id=1` | Perfil 360° del cliente 1 |
| `GET /api/churn.php` | Clientes con riesgo |
| `POST /api/churn.php?action=recalculate` | Recalcular churn |
| `GET /api/recommendations.php?id=1` | Recomendaciones de un cliente |
| `GET /api/recommendations-list.php` | Recomendaciones de todos |
| `GET /api/segments.php` | Estadísticas de segmentos |
| `POST /api/segments.php?action=recalculate` | Recalcular segmentos |
| `GET /api/reports.php` | Resumen general |
| `GET /api/reports.php?type=customers&format=csv` | Exportar clientes a CSV |

---

## 📁 Estructura del Proyecto

```
customer360/
│
├── api/                          # Endpoints REST (JSON)
│   ├── dashboard.php
│   ├── customers.php
│   ├── churn.php
│   ├── recommendations.php
│   ├── recommendations-list.php
│   ├── segments.php
│   └── reports.php
│
├── assets/
│   ├── css/
│   │   └── style.css            # Estilos personalizados
│   └── js/
│       ├── dashboard.js
│       ├── customers.js
│       ├── customer-detail.js
│       ├── churn.js
│       ├── segments.js
│       ├── recommendations.js
│       └── reports.js
│
├── config/
│   ├── database.php              # Config base
│   ├── database.local.php        # 🔒 Credenciales (NO subir)
│   └── database.local.php.example
│
├── database/
│   └── customer360.sql           # Script completo con datos de prueba
│
├── docs/
│   ├── PRD.md                    # Product Requirements Document
│   ├── MVP.md                    # Minimum Viable Product
│   └── MANUAL.md                 # Manual de usuario
│
├── includes/
│   ├── header.php                # Header + sidebar
│   └── footer.php                # Footer + scripts
│
├── index.php                     # Dashboard (página principal)
├── bienvenida.php                # Landing page
├── customers.php                 # Listado de clientes
├── customer-detail.php           # Perfil 360°
├── churn.php                     # Predicción de abandono
├── segmentos.php                 # Segmentación
├── recomendaciones.php           # Recomendaciones IA
├── reportes.php                  # Reportes y exportación
│
├── .gitignore
└── README.md
```

---

## 🗄️ Base de Datos

### Diagrama Entidad-Relación

```
┌──────────────────┐
│    customers     │
├──────────────────┤
│ id (PK)          │
│ external_id      │
│ first_name       │
│ last_name        │
│ email            │
│ phone            │
│ company          │
│ industry         │
│ country          │
│ city             │
│ segment          │──┐
│ lifetime_value   │  │
│ churn_risk       │  │
│ status           │  │
│ created_at       │  │
└────────┬─────────┘  │
         │            │
         │ 1:N        │
         │            │
┌────────▼─────────┐  │
│  transactions    │  │
├──────────────────┤  │
│ id (PK)          │  │
│ customer_id (FK) │  │
│ external_id      │  │
│ amount           │  │
│ currency         │  │
│ channel          │  │
│ status           │  │
│ transaction_date │  │
└──────────────────┘  │
                      │
┌──────────────────┐  │
│  interactions    │  │
├──────────────────┤  │
│ id (PK)          │  │
│ customer_id (FK) │◄─┘
│ type             │
│ source           │
│ subject          │
│ description      │
│ sentiment        │
│ occurred_at      │
└──────────────────┘
```

### Datos de prueba incluidos

- **5 clientes** con diferentes segmentos
- **7 transacciones** distribuidas en el tiempo
- **5 interacciones** de distintos tipos

---

## 📸 Capturas de Pantalla

> Añade aquí tus capturas reales después de subir el proyecto.

### Dashboard Ejecutivo
![Dashboard](docs/screenshots/dashboard.png)

### Perfil 360°
![Perfil 360](docs/screenshots/customer-detail.png)

### Predicción de Churn
![Churn](docs/screenshots/churn.png)

### Segmentación
![Segmentos](docs/screenshots/segmentos.png)

### Recomendaciones IA
![Recomendaciones](docs/screenshots/recomendaciones.png)

---

## 📚 Documentación

| Documento | Descripción |
|-----------|-------------|
| [PRD](docs/PRD.md) | Product Requirements Document |
| [MVP](docs/MVP.md) | Minimum Viable Product |
| [Manual de Usuario](docs/MANUAL.md) | Guía de uso paso a paso |

---

## 🧪 Pruebas

### Checklist de QA

- [ ] Login funciona con los 3 roles
- [ ] Dashboard carga KPIs en < 2 s
- [ ] Listado de clientes permite búsqueda
- [ ] Perfil 360° muestra datos completos
- [ ] Churn recalcula correctamente
- [ ] Segmentos se actualizan
- [ ] Recomendaciones se filtran por tipo
- [ ] CSV se descarga sin errores
- [ ] Responsive en móvil (375px)
- [ ] Sin errores en consola del navegador

---

## 🗺️ Roadmap

### ✅ MVP v1.0 (actual)

- Dashboard, clientes, perfil 360°, churn, segmentos, recomendaciones, reportes

### 🔜 v2.0 (futuro)

- [ ] Autenticación con Microsoft Entra ID (SSO)
- [ ] Integración real con Azure OpenAI
- [ ] Conectores reales CRM/ERP
- [ ] Power BI embebido
- [ ] App móvil (PWA)
- [ ] Notificaciones por email
- [ ] Multi-idioma

---

## 👥 Equipo

| Rol | Nombre | Responsabilidad |
|-----|--------|-----------------|
| **Product Owner** | [Tu nombre] | Priorización del backlog |
| **Scrum Master** | [Nombre] | Facilitación del equipo |
| **Dev Backend** | [Tu nombre] | APIs, BD, integraciones |
| **Dev Frontend** | [Nombre] | Interfaz, UX |
| **Data/IA** | [Nombre] | Modelos, recomendaciones |
| **QA** | [Nombre] | Pruebas, validaciones |

**Metodología:** Scrum con sprints de 2 semanas.

---

## 🤝 Contribuir

Este es un proyecto académico. Para contribuir:

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
- **Bootstrap Icons** por los iconos

---

<div align="center">

**⭐ Si este proyecto te fue útil, dale una estrella en GitHub ⭐**

Hecho con ❤️ por el equipo de Customer 360

</div>