# 📘 PRD — Product Requirements Document

## Customer 360 — Plataforma Inteligente de Cliente

---

### 1. Información del Documento

| Campo | Valor |
|-------|-------|
| **Producto** | Customer 360 |
| **Versión** | 1.0 |
| **Autor** | [Tu nombre] |
| **Fecha** | [Fecha] |
| **Empresa** | PluriOne |
| **Estado** | Aprobado para MVP |
| **Metodología** | Scrum |

---

### 2. Resumen Ejecutivo

**Customer 360** es una plataforma web que consolida la visión unificada de cada cliente integrando datos de CRM, ERP, ventas, marketing y soporte. Utiliza inteligencia artificial generativa para producir:

- Perfiles unificados 360°
- Predicción de abandono (churn)
- Recomendaciones personalizadas (upsell, cross-sell, retención)
- Segmentación automática por valor de cliente
- Dashboards ejecutivos con KPIs en tiempo real

**Problema que resuelve:** Las empresas tienen datos de clientes dispersos en múltiples sistemas, lo que impide una visión completa, dificulta la toma de decisiones y provoca pérdida de oportunidades comerciales y clientes.

---

### 3. Objetivos

#### 3.1 Objetivo General

Desarrollar una plataforma Customer 360 basada en inteligencia artificial que unifique la información del cliente y potencie la toma de decisiones comerciales.

#### 3.2 Objetivos Específicos

1. Integrar información de clientes desde múltiples fuentes
2. Diseñar una arquitectura tecnológica escalable y segura
3. Implementar analítica avanzada con recomendaciones basadas en IA
4. Validar seguridad, rendimiento y escalabilidad
5. Elaborar documentación técnica y plan de soporte

#### 3.3 Métricas de Éxito (KPIs)

| Métrica | Objetivo |
|---------|----------|
| Adopción de usuarios | ≥ 80% del área comercial |
| Reducción de churn | -15% en 6 meses |
| Incremento de venta cruzada | +20% en 6 meses |
| Tiempo de respuesta API | < 500 ms (p95) |
| Disponibilidad | ≥ 99.5% uptime |

---

### 4. Alcance

#### 4.1 Dentro del Alcance (In-Scope)

- ✅ Autenticación con roles (admin, analyst, sales, viewer)
- ✅ Perfil unificado 360° del cliente
- ✅ Dashboard ejecutivo con KPIs y gráficos
- ✅ Predicción de abandono (churn) heurística
- ✅ Segmentación automática de clientes
- ✅ Recomendaciones con IA generativa (Groq)
- ✅ Sistema de notificaciones inteligentes
- ✅ Reportes exportables (CSV, PDF)
- ✅ Modo oscuro
- ✅ Diseño responsive

#### 4.2 Fuera del Alcance (Out-of-Scope)

- ❌ App móvil nativa (iOS/Android)
- ❌ Integración real con Azure OpenAI (se usa Groq)
- ❌ Pasarela de pagos
- ❌ Facturación electrónica
- ❌ Multi-idioma
- ❌ Multi-tenant
- ❌ SSO con Entra ID (queda para v2)

---

### 5. Usuarios y Roles

| Rol | Descripción | Permisos |
|-----|-------------|----------|
| **Admin** | Administrador del sistema | Acceso total, gestión de usuarios |
| **Analyst** | Analista de datos/comercial | Ver reportes, recalcular churn/segmentos |
| **Sales** | Ejecutivo comercial | Ver clientes, editar, recomendaciones |
| **Viewer** | Solo lectura | Ver dashboards y reportes |

---

### 6. Requerimientos Funcionales

#### RF-01: Gestión de Clientes
- Listar clientes con búsqueda y paginación
- Ver perfil 360° con datos, transacciones, interacciones y métricas
- Crear y editar clientes (admin, sales)

#### RF-02: Dashboard Ejecutivo
- KPIs: total clientes, activos, churn alto, ingresos
- 4 gráficos: segmentos, interacciones, evolución, canales
- Top 5 clientes por LTV
- Actividad reciente

#### RF-03: Predicción de Churn
- Cálculo heurístico basado en días sin compra, frecuencia, ticket promedio
- Clasificación: bajo, medio, alto
- Recalculo manual

#### RF-04: Segmentación
- Asignación automática por LTV:
  - Bronce: < $5,000
  - Plata: $5,000 - $19,999
  - Oro: $20,000 - $49,999
  - Platino: ≥ $50,000

#### RF-05: Recomendaciones IA
- Generación con Groq (GPT-OSS 120B)
- Tipos: retención, upsell, cross-sell
- Fallback a reglas si la IA falla
- Caché de 24 horas

#### RF-06: Notificaciones
- Churn alto, transacciones recientes, clientes nuevos, tickets negativos
- Marcado de leídas
- Auto-refresh cada 60s

#### RF-07: Reportes
- Exportar CSV (clientes, transacciones, churn)
- Exportar PDF con estilos optimizados
- Gráficos de ingresos por mes y por canal

#### RF-08: Autenticación
- Login con email y contraseña
- Hash bcrypt
- Sesiones con expiración
- Cambio de contraseña

---

### 7. Requerimientos No Funcionales

| Categoría | Requerimiento |
|-----------|---------------|
| **Rendimiento** | APIs < 500 ms (p95) |
| **Escalabilidad** | Soporta 10,000 clientes sin degradación |
| **Seguridad** | bcrypt, HTTPS en producción, PDO preparado, protección CSRF |
| **Usabilidad** | Interfaz responsive, accesible desde cualquier dispositivo |
| **Compatibilidad** | Chrome, Firefox, Edge, Safari |
| **Mantenibilidad** | Código modular, comentado en español |
| **Disponibilidad** | ≥ 99.5% uptime |
| **Respaldo** | Backup diario de BD |

---

### 8. Arquitectura Técnica

#### 8.1 Stack

| Capa | Tecnología |
|------|-----------|
| Frontend | HTML5, CSS3, Bootstrap 5, JavaScript, Chart.js |
| Backend | PHP 8+ |
| Base de datos | MySQL 8 / MariaDB |
| IA | Groq API (GPT-OSS 120B) |
| Servidor | Apache (XAMPP) |
| Versionamiento | Git + GitHub |

#### 8.2 Modelo de Datos
customers (1) ──┬── (N) transactions
│
├── (N) interactions
│
└── (1) users [opcional]

ai_cache (independiente)

text

---

### 9. Cronograma (Scrum)

| Sprint | Duración | Entregable |
|--------|----------|-----------|
| Sprint 0 | 1 semana | Setup, BD, arquitectura |
| Sprint 1 | 2 semanas | Backend base + APIs |
| Sprint 2 | 2 semanas | Frontend dashboard + clientes |
| Sprint 3 | 2 semanas | Churn + recomendaciones |
| Sprint 4 | 2 semanas | Segmentos + reportes |
| Sprint 5 | 1 semana | QA, documentación, deploy |

**Total: 10 semanas**

---

### 10. Riesgos

| Riesgo | Probabilidad | Impacto | Mitigación |
|--------|:------------:|:-------:|------------|
| Datos inconsistentes | Alta | Alto | Normalización previa |
| Bajo rendimiento con datos masivos | Media | Alto | Índices, caché |
| Baja adopción | Media | Alto | Capacitación + UX simple |
| Dependencia de Groq | Baja | Medio | Fallback con reglas |
| Cambios de alcance | Media | Medio | Backlog priorizado |

---

### 11. Criterios de Aceptación

- ✅ Todas las funcionalidades del MVP funcionan sin errores
- ✅ Los 4 roles pueden autenticarse y ver sus vistas
- ✅ Los reportes se exportan correctamente
- ✅ El dashboard carga en < 2 segundos
- ✅ Las APIs responden en < 500 ms (p95)
- ✅ Documentación técnica completa
- ✅ Manual de usuario entregado

---

**Última actualización:** [07/10/2026]