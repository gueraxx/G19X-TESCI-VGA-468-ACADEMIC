# 🚀 MVP — Minimum Viable Product

## Customer 360 — Versión 1.1

---

### 1. Definición del MVP

El **MVP** de Customer 360 es la versión más pequeña funcional que:

1. **Resuelve el problema core:** unificar la visión del cliente
2. **Entrega valor inmediato:** dashboards + predicciones + recomendaciones IA
3. **Es entregable en 10 semanas**
4. **Permite validar** con usuarios reales antes de invertir más

---

### 2. Hipótesis a Validar

| # | Hipótesis | Cómo se valida |
|---|-----------|----------------|
| H1 | Los usuarios comerciales necesitan una vista 360° unificada | Entrevistas + uso real |
| H2 | La predicción de churn permite anticipar acciones | Reducción de churn en 3 meses |
| H3 | Las recomendaciones IA aumentan la venta cruzada | Comparativa antes/después |
| H4 | Los dashboards aceleran la toma de decisiones | Encuestas de satisfacción |

> ⚠️ **Nota:** estas hipótesis se validarán una vez que el sistema esté en uso real. Actualmente solo se valida con datos de prueba.

---

### 3. Funcionalidades del MVP

#### ✅ Incluidas (implementadas)

| # | Módulo | Prioridad | Estado |
|---|--------|:---------:|:------:|
| 1 | Autenticación con roles | 🔴 Crítica | ✅ |
| 2 | Dashboard con KPIs + 4 gráficos | 🔴 Crítica | ✅ |
| 3 | Clientes con búsqueda y CRUD | 🔴 Crítica | ✅ |
| 4 | Perfil 360° con timeline | 🔴 Crítica | ✅ |
| 5 | Churn heurístico | 🔴 Crítica | ✅ |
| 6 | Recomendaciones con IA generativa (con fallback) | 🔴 Crítica | ✅ |
| 7 | Segmentación automática | 🟡 Alta | ✅ |
| 8 | Reportes CSV + PDF | 🟡 Alta | ✅ |
| 9 | Notificaciones inteligentes | 🟡 Alta | ✅ |
| 10 | Modo oscuro | 🟢 Media | ✅ |
| 11 | Gestión de usuarios (admin) | 🟡 Alta | ✅ |

#### ❌ Excluidas (quedan para v2+)

- Login con Entra ID (SSO)
- Integración real con CRM/ERP
- App móvil nativa
- Notificaciones por email
- Multi-idioma
- Chatbot
- Paginación server-side

---

### 4. User Stories

| ID | Como... | Quiero... | Para... | Prioridad | Estado |
|----|---------|-----------|---------|:---------:|:------:|
| US-01 | Analista | Ver KPIs en un dashboard | Monitorear el negocio | 🔴 | ✅ |
| US-02 | Ventas | Ver el perfil 360° de un cliente | Preparar mi reunión | 🔴 | ✅ |
| US-03 | Analista | Ver clientes con alto churn | Anticipar acciones | 🔴 | ✅ |
| US-04 | Ventas | Recibir recomendaciones IA | Ofrecer productos relevantes | 🔴 | ✅ |
| US-05 | Analista | Ver segmentación de clientes | Priorizar esfuerzos | 🟡 | ✅ |
| US-06 | Admin | Gestionar usuarios | Controlar accesos | 🟡 | ✅ |
| US-07 | Todos | Exportar reportes | Compartir con dirección | 🟡 | ✅ |
| US-08 | Todos | Usar modo oscuro | Trabajar cómodo de noche | 🟢 | ✅ |

---

### 5. Criterios de Aceptación del MVP

#### ✅ Funcionales (verificados después de instalación desde cero)

- [x] La base de datos se crea correctamente desde `customer360.sql` (incluye `users` y `ai_cache`)
- [x] Los 4 usuarios de prueba pueden iniciar sesión
- [x] El dashboard muestra los KPIs y los 4 gráficos sin errores
- [x] El listado de clientes permite buscar y filtrar
- [x] El perfil 360° carga con datos y timeline
- [x] El cálculo de churn funciona y clasifica correctamente
- [x] La segmentación se recalcula sin errores
- [x] Los CSV y PDF se exportan correctamente
- [x] Las notificaciones cargan
- [x] El admin puede gestionar usuarios

#### ⏳ Pendientes / En verificación

- [ ] **Las recomendaciones con IA generan resultados sin errores fatales** (se detectó un conflicto con `env()` en el corte 2, corregido en la v1.1)
- [ ] **Todas las rutas son relativas** (se están reemplazando las rutas fijas `/customer360/` por `basePath()`)
- [ ] **No hay errores en consola** en todos los flujos (pendiente de prueba exhaustiva con las correcciones aplicadas)

---

### 6. Definition of Done (DoD)

Cada historia se considera **Done** cuando:

- ✅ El código está implementado
- ✅ Funciona en el flujo principal probado manualmente
- ✅ Es responsive (verificado en vista móvil 375px)
- ✅ El código está comentado en español
- ✅ Está commiteado a GitHub con mensaje descriptivo
- ✅ Está documentado en README y docs/

---

### 7. Entregables

| # | Entregable | Formato | Estado |
|---|-----------|---------|:------:|
| 1 | Código fuente | Repositorio GitHub | ✅ |
| 2 | Base de datos completa | Script SQL | ✅ |
| 3 | Manual de instalación | README.md | ✅ |
| 4 | Manual de usuario | docs/manual-usuario.md | ✅ |
| 5 | Documentación técnica | docs/*.md | ✅ |
| 6 | Demo funcional | URL en vivo (InfinityFree) | ⏳ Pendiente |
| 7 | Presentación | PPT | ⏳ Pendiente |

---

### 8. Métricas de Éxito

| Métrica | Meta | Estado actual |
|---------|------|:-------------:|
| Usuarios de prueba activos | ≥ 5 | 4 (admin, analyst, sales, viewer) |
| Tiempo de carga del dashboard | < 2 s | ✅ Verificado |
| Tasa de satisfacción | ≥ 4/5 | ⏳ Pendiente (encuestas) |
| Bugs críticos post-release | 0 | ⏳ Pendiente (post-deploy) |
| Cobertura de funcionalidades | 100% del MVP | ✅ 100% |

---

### 9. Roadmap Post-MVP

| Fase | Duración estimada | Funcionalidad |
|------|:-----------------:|--------------|
| v2.1 | 4 semanas | SSO con Entra ID |
| v2.2 | 4 semanas | Integración real con CRM/ERP |
| v2.3 | 6 semanas | Power BI embebido + analytics avanzado |
| v2.4 | 4 semanas | App móvil (PWA) + notificaciones push |
| v2.5 | 2 semanas | Paginación server-side + filtros avanzados |
| v2.6 | 4 semanas | Multi-idioma + chatbot IA |

---

### 10. Conclusión

El MVP de Customer 360 entrega **valor inmediato** al:

- ✅ Unificar la visión del cliente en una sola plataforma
- ✅ Anticipar el abandono con predicciones de churn
- ✅ Sugerir acciones comerciales con IA generativa
- ✅ Facilitar decisiones con dashboards en tiempo real
- ✅ Exportar datos para análisis externos

**Diseñado para:** validarse con usuarios reales en 10 semanas y evolucionar iterativamente según feedback.

---

**Última actualización:** 20/10/2026
**Versión:** 1.1