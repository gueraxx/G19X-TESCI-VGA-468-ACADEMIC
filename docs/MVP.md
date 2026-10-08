# 🚀 MVP — Minimum Viable Product

## Customer 360 — Versión 1.0

---

### 1. Definición del MVP

El **MVP** de Customer 360 es la versión más pequeña funcional que:

1. **Resuelve el problema core:** unificar la visión del cliente
2. **Entrega valor inmediato:** dashboards + predicciones + recomendaciones IA
3. **Es entregable en 10 semanas**
4. **Permite validar** con usuarios reales antes de invertir más

---

### 2. Hipótesis a Validar

| # | Hipótesis | Validación |
|---|-----------|------------|
| H1 | Los usuarios comerciales necesitan vista 360° unificada | Entrevistas + uso |
| H2 | La predicción de churn anticipa acciones | Reducción de churn en 3 meses |
| H3 | Las recomendaciones IA aumentan venta cruzada | Comparativa antes/después |
| H4 | Los dashboards aceleran decisiones | Encuestas de satisfacción |

---

### 3. Funcionalidades del MVP

#### ✅ Incluidas

| # | Módulo | Prioridad |
|---|--------|:---------:|
| 1 | Autenticación con roles | 🔴 Crítica |
| 2 | Dashboard con KPIs + 4 gráficos | 🔴 Crítica |
| 3 | Clientes con búsqueda | 🔴 Crítica |
| 4 | Perfil 360° con timeline | 🔴 Crítica |
| 5 | Churn heurístico | 🔴 Crítica |
| 6 | Recomendaciones con IA generativa | 🔴 Crítica |
| 7 | Segmentación automática | 🟡 Alta |
| 8 | Reportes CSV + PDF | 🟡 Alta |
| 9 | Notificaciones inteligentes | 🟡 Alta |
| 10 | Modo oscuro | 🟢 Media |
| 11 | Gestión de usuarios (admin) | 🟡 Alta |

#### ❌ Excluidas (v2+)

- Login con Entra ID (SSO)
- Integración real con CRM/ERP
- App móvil nativa
- Notificaciones por email
- Multi-idioma
- Chatbot

---

### 4. User Stories

| ID | Como... | Quiero... | Para... | Prioridad |
|----|---------|-----------|---------|:---------:|
| US-01 | Analista | Ver KPIs en un dashboard | Monitorear el negocio | 🔴 |
| US-02 | Ventas | Ver el perfil 360° de un cliente | Preparar mi reunión | 🔴 |
| US-03 | Analista | Ver clientes con alto churn | Anticipar acciones | 🔴 |
| US-04 | Ventas | Recibir recomendaciones IA | Ofrecer productos relevantes | 🔴 |
| US-05 | Analista | Ver segmentación de clientes | Priorizar esfuerzos | 🟡 |
| US-06 | Admin | Gestionar usuarios | Controlar accesos | 🟡 |
| US-07 | Todos | Exportar reportes | Compartir con dirección | 🟡 |
| US-08 | Todos | Usar modo oscuro | Trabajar cómodo de noche | 🟢 |

---

### 5. Criterios de Aceptación del MVP

#### Funcionales
- [x] Los 4 roles pueden autenticarse
- [x] El dashboard muestra 4 KPIs + 4 gráficos
- [x] El listado de clientes permite búsqueda
- [x] El perfil 360° carga con datos completos
- [x] El cálculo de churn clasifica correctamente
- [x] Las recomendaciones se generan con IA
- [x] La segmentación se recalcula sin errores
- [x] Los CSV y PDF se exportan correctamente
- [x] Las notificaciones funcionan en tiempo real
- [x] El admin puede gestionar usuarios

#### No Funcionales
- [x] APIs responden < 500 ms (p95)
- [x] La BD soporta 1,000+ clientes
- [x] La app es usable en móvil
- [x] Sin errores en consola
- [x] Código documentado

---

### 6. Definition of Done (DoD)

- ✅ Código implementado y funcionando
- ✅ Sin errores en consola
- ✅ Probado en Chrome y Firefox
- ✅ Responsive en móvil
- ✅ Código comentado en español
- ✅ Commiteado a GitHub con mensaje descriptivo
- ✅ Documentado en README

---

### 7. Entregables

| # | Entregable | Formato |
|---|-----------|---------|
| 1 | Código fuente | Repositorio GitHub |
| 2 | Base de datos | Script SQL |
| 3 | Manual de instalación | README.md |
| 4 | Manual de usuario | docs/manual-usuario.md |
| 5 | Documentación técnica | docs/*.md |
| 6 | Demo funcional | Localhost / InfinityFree |
| 7 | Presentación | PPT |

---

### 8. Métricas de Éxito

| Métrica | Meta |
|---------|------|
| Usuarios de prueba activos | ≥ 5 |
| Tiempo de carga del dashboard | < 2 s |
| Tasa de satisfacción | ≥ 4/5 |
| Bugs críticos post-release | 0 |
| Cobertura de funcionalidades | 100% del MVP |

---

### 9. Roadmap Post-MVP

| Fase | Duración | Funcionalidad |
|------|----------|--------------|
| v2.1 | 4 semanas | SSO con Entra ID |
| v2.2 | 4 semanas | Integración real CRM/ERP |
| v2.3 | 4 semanas | Power BI embebido |
| v2.4 | 4 semanas | App móvil (PWA) |

---

**Última actualización:** [07/10/26]