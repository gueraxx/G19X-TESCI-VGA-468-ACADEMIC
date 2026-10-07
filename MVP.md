MVP — Minimum Viable Product
Customer 360 — Versión 1.0
1. Definición del MVP
El MVP (Producto Mínimo Viable) de Customer 360 es la versión más pequeña funcional que:

Resuelve el problema core: unificar la visión del cliente

Entrega valor inmediato: dashboards + predicciones + recomendaciones

Es entregable en 10 semanas con el equipo actual

Permite validar con usuarios reales antes de invertir más

2. Hipótesis a Validar
#	Hipótesis	Cómo se valida
H1	Los usuarios comerciales necesitan una vista 360° unificada	Entrevistas + uso real
H2	La predicción de churn permite anticipar acciones	Reducción de churn en 3 meses
H3	Las recomendaciones IA aumentan venta cruzada	Comparativa antes/después
H4	Los dashboards aceleran la toma de decisiones	Encuestas de satisfacción
3. Funcionalidades del MVP
✅ Incluidas en el MVP
#	Módulo	Funcionalidad	Prioridad
1	Autenticación	Login básico con roles	🔴 Crítica
2	Dashboard	KPIs + 2 gráficos	🔴 Crítica
3	Clientes	Listado + búsqueda	🔴 Crítica
4	Perfil 360°	Datos + transacciones + interacciones + métricas	🔴 Crítica
5	Churn	Cálculo heurístico + nivel de riesgo	🔴 Crítica
6	Recomendaciones	Por reglas de negocio (no IA real)	🟡 Alta
7	Segmentos	Asignación automática por LTV	🟡 Alta
8	Reportes	Exportar CSV (clientes, transacciones, churn)	🟡 Alta
9	Landing	Página de bienvenida	🟢 Media
10	Diseño responsive	Adaptable a móvil/tablet	🟢 Media
❌ Excluidas del MVP (para v2+)
Login con Microsoft Entra ID (SSO)

Integración real con Azure OpenAI

Integración real con CRM/ERP (se usan datos de prueba)

App móvil nativa

Notificaciones push/email

Multi-idioma

Facturación electrónica

Chatbot

4. User Stories del MVP
ID	Como...	Quiero...	Para...	Prioridad
US-01	Analista	Ver KPIs en un dashboard	Monitorear el negocio	🔴
US-02	Ventas	Ver el perfil 360° de un cliente	Preparar mi reunión	🔴
US-03	Analista	Ver clientes con alto churn	Anticipar acciones	🔴
US-04	Ventas	Recibir recomendaciones por cliente	Ofrecer productos relevantes	🟡
US-05	Analista	Ver segmentación de clientes	Priorizar esfuerzos	🟡
US-06	Admin	Exportar reportes	Compartir con dirección	🟡
US-07	Todos	Acceder desde el móvil	Consultar fuera de oficina	🟢
5. Criterios de Aceptación del MVP
El MVP se considera terminado cuando:

5.1 Funcionales
□ Los 5 usuarios de prueba pueden iniciar sesión
□ El dashboard muestra 4 KPIs + 2 gráficos con datos reales
□ El listado de clientes muestra 100 registros con búsqueda funcional
□ El perfil 360° carga en < 2 segundos con datos completos
□ El cálculo de churn funciona y clasifica correctamente
□ Se generan al menos 3 tipos de recomendaciones
□ La segmentación se recalcula sin errores
□ Los 3 CSV se exportan correctamente
5.2 No Funcionales
□ APIs responden < 500 ms (p95)
□ La BD soporta 1,000 clientes sin degradación
□ La app es usable en móvil
□ No hay errores en consola del navegador
□ Código documentado
6. Definición de Done (DoD)
Cada historia se considera Done cuando:

✅ Código implementado y funcionando

✅ Sin errores en consola (frontend/backend)

✅ Probado en Chrome y Firefox

✅ Probado en móvil (responsive)

✅ Código comentado en español

✅ Commiteado a GitHub con mensaje descriptivo

✅ Documentado en README si aplica

7. Entregables del MVP
#	Entregable	Formato	Responsable
1	Código fuente	Repositorio GitHub	Dev
2	Base de datos	Script SQL	Dev
3	Manual de instalación	README.md	Dev
4	Manual de usuario	PDF / MD	Dev
5	Documentación técnica	PDF / MD	Dev
6	Demo funcional	Localhost / Video	Dev
7	Presentación	PPT	Dev
8. Alcance Técnico del MVP
text
📦 Stack MVP
├── PHP 8+
├── MySQL 8
├── Apache (XAMPP)
├── Bootstrap 5
├── Chart.js 4
└── JavaScript vanilla

📁 Módulos
├── 🔐 Autenticación (básica)
├── 📊 Dashboard
├── 👥 Clientes
├── 👤 Perfil 360°
├── 🔮 Churn
├── 🧩 Segmentos
├── 🎯 Recomendaciones
└── 📈 Reportes

🗄️ Base de datos
├── customers
├── transactions
└── interactions
9. Métricas de Éxito del MVP
Métrica	Meta
Usuarios de prueba activos	≥ 5
Tiempo de carga del dashboard	< 2 s
Tasa de satisfacción	≥ 4/5
Bugs críticos post-release	0
Cobertura de funcionalidades	100% del MVP
10. Roadmap Post-MVP (v2)
Fase	Duración	Funcionalidad
v2.1	4 semanas	Login con Entra ID + roles avanzados
v2.2	4 semanas	Integración real con Azure OpenAI
v2.3	6 semanas	Conectores reales CRM/ERP
v2.4	4 semanas	App móvil (PWA)
v2.5	6 semanas	Analytics avanzado + Power BI
11. Conclusión
El MVP de Customer 360 entrega valor inmediato al:

✅ Unificar la visión del cliente

✅ Anticipar el abandono con predicciones

✅ Sugerir acciones comerciales con IA

✅ Facilitar decisiones con dashboards

✅ Exportar datos para análisis externo

Está diseñado para: validarse con usuarios reales en 10 semanas y evolucionar iterativamente según feedback.

📁 Cómo guardarlos
Crea en tu proyecto:

text
customer360/
└── docs/
    ├── PRD.md    ← pega el primer documento
    └── MVP.md    ← pega el segundo documento
Y en tu README.md agrega al final:

markdown
## 📚 Documentación

- [PRD — Product Requirements Document](docs/PRD.md)
- [MVP — Minimum Viable Product](docs/MVP.md)
