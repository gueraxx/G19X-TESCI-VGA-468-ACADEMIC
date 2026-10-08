# 📘 Manual de Usuario — Customer 360

**Versión:** 1.0
**Última actualización:** [Fecha]
**Audiencia:** Usuarios finales (Admin, Analyst, Sales, Viewer)
**Plataforma:** Aplicación web (Chrome, Firefox, Edge, Safari)

---

## 📋 Tabla de Contenidos

1. [Introducción](#1-introducción)
2. [Requisitos del Sistema](#2-requisitos-del-sistema)
3. [Conceptos Básicos](#3-conceptos-básicos)
4. [Acceso al Sistema](#4-acceso-al-sistema)
5. [Roles y Permisos](#5-roles-y-permisos)
6. [Dashboard Ejecutivo](#6-dashboard-ejecutivo)
7. [Módulo de Clientes](#7-módulo-de-clientes)
8. [Perfil 360° del Cliente](#8-perfil-360°-del-cliente)
9. [Predicción de Churn](#9-predicción-de-churn)
10. [Segmentación de Clientes](#10-segmentación-de-clientes)
11. [Recomendaciones con IA](#11-recomendaciones-con-ia)
12. [Reportes y Exportación](#12-reportes-y-exportación)
13. [Notificaciones](#13-notificaciones)
14. [Menú de Usuario](#14-menú-de-usuario)
15. [Modo Oscuro](#15-modo-oscuro)
16. [Gestión de Usuarios (Admin)](#16-gestión-de-usuarios-admin)
17. [Preguntas Frecuentes](#17-preguntas-frecuentes)
18. [Solución de Problemas](#18-solución-de-problemas)
19. [Glosario](#19-glosario)
20. [Contacto y Soporte](#20-contacto-y-soporte)

---

## 1. Introducción

### 1.1 ¿Qué es Customer 360?

**Customer 360** es una plataforma web inteligente que te permite ver **toda la información de tus clientes en un solo lugar**, integrando datos de CRM, ERP, ventas, marketing y soporte.

### 1.2 ¿Para qué sirve?

- 📊 **Visualizar** el estado general del negocio con dashboards en tiempo real
- 👤 **Conocer** a cada cliente en profundidad con perfiles 360°
- 🔮 **Anticipar** el abandono de clientes con predicciones de churn
- 🎯 **Recibir** recomendaciones personalizadas generadas por IA
- 📈 **Analizar** tendencias y generar reportes ejecutivos
- 🚀 **Optimizar** las decisiones comerciales basadas en datos

### 1.3 Beneficios principales

| Beneficio | Impacto |
|-----------|---------|
| **Visión unificada** | Un solo lugar para toda la info del cliente |
| **Reducción de churn** | Detección temprana de clientes en riesgo |
| **Aumento de ventas** | Recomendaciones inteligentes de upsell/cross-sell |
| **Ahorro de tiempo** | Reportes automáticos en segundos |
| **Decisiones informadas** | KPIs actualizados en tiempo real |

---

## 2. Requisitos del Sistema

### 2.1 Hardware

- **Procesador:** Intel Core i3 o superior
- **RAM:** 4 GB mínimo (8 GB recomendado)
- **Disco:** 100 MB libres
- **Pantalla:** 1366x768 mínimo (1920x1080 recomendado)

### 2.2 Software

| Componente | Versión mínima | Notas |
|-----------|----------------|-------|
| **Navegador** | Chrome 90+, Firefox 88+, Edge 90+, Safari 14+ | Actualizado |
| **JavaScript** | Habilitado | Requerido |
| **Cookies** | Habilitadas | Para sesiones |
| **Conexión a internet** | Requerida | Para la IA |

### 2.3 Navegadores soportados

| Navegador | Versión | Estado |
|-----------|---------|:------:|
| Chrome | 90+ | ✅ Recomendado |
| Firefox | 88+ | ✅ |
| Edge | 90+ | ✅ |
| Safari | 14+ | ✅ |
| Internet Explorer | Cualquiera | ❌ No soportado |

---

## 3. Conceptos Básicos

### 3.1 Glosario rápido

| Término | Significado |
|---------|-------------|
| **Cliente** | Persona o empresa que compra tus productos/servicios |
| **LTV** | *Lifetime Value* — Valor total que un cliente aporta |
| **Churn** | Riesgo de abandono del cliente (0% a 100%) |
| **Segmento** | Clasificación por valor: Bronce, Plata, Oro, Platino |
| **Upsell** | Vender un plan superior al que ya tiene |
| **Cross-sell** | Vender productos complementarios |
| **Retención** | Acciones para evitar que el cliente se vaya |
| **IA** | Inteligencia Artificial que genera recomendaciones |
| **Fallback** | Modo alternativo si la IA falla (usa reglas) |

### 3.2 Estructura de la información

```
Cliente
  ├── Datos básicos (nombre, email, empresa)
  ├── Segmento (Bronce → Platino)
  ├── LTV (Valor de vida)
  ├── Churn Risk (% abandono)
  ├── Transacciones (compras)
  └── Interacciones (llamadas, emails, tickets)
```

---

## 4. Acceso al Sistema

### 4.1 Cómo iniciar sesión

**Paso 1:** Abre tu navegador

**Paso 2:** Ve a la URL del sistema:
```
http://localhost/customer360
```

**Paso 3:** Serás redirigido a la pantalla de login

**Paso 4:** Ingresa tus credenciales:
- **Email:** tu correo registrado
- **Contraseña:** tu contraseña

**Paso 5:** Clic en **Iniciar Sesión**

![Login](screenshots/login.png)
*Figura 1: Pantalla de login*

### 4.2 Credenciales de prueba

| Rol | Email | Contraseña |
|-----|-------|-----------|
| 🔴 Admin | admin@customer360.com | admin123 |
| 🔵 Analyst | analyst@customer360.com | analyst123 |
| 🟢 Sales | sales@customer360.com | sales123 |
| ⚪ Viewer | viewer@customer360.com | viewer123 |

> 💡 **Tip:** Usa las credenciales de prueba para explorar el sistema con cada rol.

### 4.3 Recuperar acceso

Si olvidaste tu contraseña:
1. Contacta al administrador del sistema
2. El admin puede resetear tu contraseña desde `Usuarios`

### 4.4 Cerrar sesión

**Formas de cerrar sesión:**

1. **Menú de usuario:** Clic en tu avatar (arriba a la derecha) → **Cerrar sesión**
2. **Cierre automático:** después de 8 horas de inactividad

### 4.5 Sesión expirada

Si ves este mensaje:
> ⏰ *"Tu sesión ha expirado. Vuelve a iniciar sesión."*

Simplemente ingresa tus credenciales de nuevo. La sesión dura 8 horas.

---

## 5. Roles y Permisos

El sistema tiene **4 roles** con permisos diferenciados:

### 5.1 🔴 Administrador (Admin)

**Puede hacer todo:**
- ✅ Ver y editar todos los módulos
- ✅ Crear, editar y eliminar clientes
- ✅ Recalcular churn y segmentos
- ✅ Gestionar usuarios (crear, editar, eliminar)
- ✅ Exportar reportes

**Uso típico:** Gerentes, CTO, dueños del negocio

### 5.2 🔵 Analista (Analyst)

**Enfocado en análisis:**
- ✅ Ver dashboard, clientes, reportes
- ✅ Recalcular churn y segmentos
- ✅ Exportar reportes
- ❌ No puede editar clientes
- ❌ No puede gestionar usuarios

**Uso típico:** Analistas de datos, BI

### 5.3 🟢 Ventas (Sales)

**Enfocado en clientes:**
- ✅ Ver dashboard y clientes
- ✅ Crear y editar clientes
- ✅ Ver recomendaciones IA
- ❌ No puede eliminar clientes
- ❌ No puede recalcular churn/segmentos

**Uso típico:** Ejecutivos comerciales, vendedores

### 5.4 ⚪ Observador (Viewer)

**Solo lectura:**
- ✅ Ver todo
- ❌ No puede modificar nada
- ❌ No puede exportar

**Uso típico:** Directivos, invitados, auditoría

### 5.5 Tabla resumen

| Función | Admin | Analyst | Sales | Viewer |
|---------|:-----:|:-------:|:-----:|:------:|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Ver clientes | ✅ | ✅ | ✅ | ✅ |
| Crear clientes | ✅ | ❌ | ✅ | ❌ |
| Editar clientes | ✅ | ❌ | ✅ | ❌ |
| Eliminar clientes | ✅ | ❌ | ❌ | ❌ |
| Ver churn | ✅ | ✅ | ❌ | ❌ |
| Recalcular churn | ✅ | ✅ | ❌ | ❌ |
| Ver segmentos | ✅ | ✅ | ❌ | ❌ |
| Recomendaciones IA | ✅ | ✅ | ✅ | ✅ |
| Exportar PDF/CSV | ✅ | ✅ | ✅ | ✅ |
| Gestionar usuarios | ✅ | ❌ | ❌ | ❌ |

---

## 6. Dashboard Ejecutivo

### 6.1 Descripción

Es la **primera pantalla** después de iniciar sesión. Muestra un resumen visual del estado del negocio.

![Dashboard](screenshots/dashboard.png)
*Figura 2: Dashboard ejecutivo*

### 6.2 KPIs (arriba de la pantalla)

| KPI | Descripción | Ejemplo |
|-----|-------------|---------|
| **Total Clientes** | Cantidad de clientes registrados | `150` |
| **Clientes Activos** | Clientes con estado activo | `142` |
| **Alto Riesgo Churn** | Clientes con riesgo ≥ 70% | `8` |
| **Ingresos Totales** | Suma de todas las transacciones | `$1,250,000` |

Cada KPI muestra:
- 🔢 Número animado (cuenta al cargar)
- 📈 Tendencia vs mes anterior (+12.5% / -3.1%)
- 🎨 Color según tipo

### 6.3 Gráficos disponibles

#### 📊 Gráfico de Segmentos (Dona)
Muestra la distribución de clientes por segmento:
- 🟤 Bronce
- ⚪ Plata
- 🟡 Oro
- 🟣 Platino

#### 📊 Gráfico de Interacciones (Barras)
Muestra cuántas interacciones por tipo:
- 📞 Llamadas
- ✉️ Emails
- 💬 Chats
- 🎫 Tickets
- 📅 Reuniones

#### 📈 Evolución de Ingresos (Línea)
Tendencia de ingresos de los últimos 6 meses.

#### 🎯 Ingresos por Canal (Polar)
Distribución de ingresos por:
- Web, Mobile, Store, Phone, Partner

### 6.4 Secciones adicionales

#### 🏆 Top 5 Clientes por LTV
Tabla con los 5 clientes más valiosos.

#### 📊 Actividad Reciente
Últimas 8 transacciones registradas.

### 6.5 Cómo interpretar el dashboard

**Ejemplo práctico:**

Imagina que ves:
- Total Clientes: **150**
- Clientes Activos: **142**
- Alto Riesgo Churn: **12**
- Ingresos: **$1,250,000**

**Análisis:**
- 🎯 Tasa de actividad: 94.6% (bien)
- ⚠️ 12 clientes en riesgo: requieren atención inmediata
- 💰 Ticket promedio: $8,333 por cliente

**Acciones sugeridas:**
1. Ir a **Churn** para ver los 12 clientes en riesgo
2. Ir a **Recomendaciones** para generar acciones
3. Contactar a los clientes críticos

---

## 7. Módulo de Clientes

### 7.1 Acceso

Menú lateral → **Clientes**

![Listado de clientes](screenshots/customers.png)
*Figura 3: Listado de clientes*

### 7.2 Estructura de la tabla

| Columna | Descripción |
|---------|-------------|
| **Cliente** | Avatar + nombre completo |
| **Email** | Correo electrónico |
| **Empresa** | Empresa donde trabaja |
| **Segmento** | Bronce / Plata / Oro / Platino (badge de color) |
| **LTV** | Valor total del cliente |
| **Churn** | Riesgo de abandono (%) con color |
| **Acciones** | Botones de ver, editar, eliminar |

### 7.3 Cómo buscar un cliente

**Opción 1: Buscador**
1. Clic en el campo de búsqueda (arriba a la derecha)
2. Escribe nombre, email o empresa
3. La tabla se filtra **automáticamente** (con 300ms de espera)

**Ejemplo:**
- Escribe `Juan` → muestra todos los clientes con "Juan"
- Escribe `acme` → muestra clientes de ACME Corp
- Escribe `@gmail.com` → muestra clientes con Gmail

### 7.4 Cómo crear un cliente

**Requisito:** Rol Admin o Sales

**Paso 1:** Clic en **+ Nuevo Cliente** (arriba a la derecha)

**Paso 2:** Se abre el modal con el formulario:

![Modal de cliente](screenshots/customer-modal.png)
*Figura 4: Modal de crear cliente*

**Paso 3:** Llena los campos:

| Campo | Requerido | Ejemplo |
|-------|:---------:|---------|
| Nombre | ✅ | Juan |
| Apellido | ✅ | Pérez |
| Email | ✅ | juan@acme.com |
| Teléfono | ❌ | +52 555 123 4567 |
| Empresa | ❌ | ACME Corp |
| Industria | ❌ | Tecnología |
| País | ❌ | México |
| Ciudad | ❌ | CDMX |
| Segmento | ❌ | Bronce (por defecto) |
| Estado | ❌ | Activo (por defecto) |

**Paso 4:** Clic en **Guardar**

**Paso 5:** Verás un toast verde confirmando la creación

### 7.5 Cómo editar un cliente

**Requisito:** Rol Admin o Sales

**Paso 1:** Busca el cliente en la tabla

**Paso 2:** Clic en el botón ✏️ (lápiz) de la fila

**Paso 3:** Se abre el modal con los datos precargados

**Paso 4:** Modifica los campos necesarios

**Paso 5:** Clic en **Guardar**

**Paso 6:** Toast verde confirma la actualización

### 7.6 Cómo eliminar un cliente

**Requisito:** Rol Admin

**Paso 1:** Busca el cliente

**Paso 2:** Clic en el botón 🗑️ (papelera)

**Paso 3:** Aparece un diálogo de confirmación:
> ¿Eliminar a "Juan Pérez"?

**Paso 4:** Confirma con **Aceptar**

**Modo de eliminación:**
- Por defecto: **Soft delete** (el cliente queda como `blocked`)
- El cliente deja de aparecer activo pero sus datos se conservan

### 7.7 Validaciones del sistema

El sistema valida automáticamente:

✅ **Nombre y apellido** son obligatorios
✅ **Email** debe ser válido (`usuario@dominio.com`)
✅ **Email** no puede estar duplicado
✅ **Campos** respetan longitud máxima

**Ejemplos de errores:**

| Error | Causa | Solución |
|-------|-------|----------|
| "Ya existe un cliente con ese email" | Email duplicado | Usa otro email |
| "Email inválido" | Formato incorrecto | Corrige el formato |
| "El campo 'first_name' es requerido" | Falta nombre | Llena el campo |

---

## 8. Perfil 360° del Cliente

### 8.1 Acceso

**Opción 1:** Desde el listado, clic en 👁️ (ojo)

**Opción 2:** Desde una notificación, clic en el cliente

**Opción 3:** URL directa:
```
http://localhost/customer360/customer-detail.php?id=1
```

![Perfil 360](screenshots/customer-detail.png)
*Figura 5: Perfil 360° de un cliente*

### 8.2 Estructura del perfil

#### 📊 Métricas superiores (4 tarjetas)

| Métrica | Descripción |
|---------|-------------|
| **Gasto total** | Suma de todas las transacciones |
| **Ticket promedio** | Promedio por transacción |
| **Transacciones** | Número de compras |
| **Interacciones** | Número de contactos |

#### 📋 Tarjeta: Datos del cliente

Muestra:
- ✉️ Email
- 📞 Teléfono
- 🏢 Empresa
- 🏭 Industria
- 📍 Ubicación (Ciudad, País)
- 🏷️ Segmento (badge)
- 🟢 Estado

#### 🎯 Tarjeta: Recomendaciones IA

Muestra:
- 💡 **Próxima mejor acción** (sugerencia principal)
- 📝 **Resumen** del cliente
- 🎯 **Lista de recomendaciones**:
  - Retención
  - Upsell
  - Cross-sell

#### 💳 Historial de transacciones

Tabla con:
- Fecha
- Monto
- Canal
- Estado

#### 📅 Timeline de interacciones

Vista cronológica con:
- 🔵 Icono por tipo (llamada, email, chat, etc.)
- 📝 Asunto
- 💬 Descripción
- 😊 Sentimiento (smile, neutral, frown)
- 🕐 Fecha y hora

### 8.3 Acciones disponibles

| Acción | Cómo |
|--------|------|
| **Exportar PDF** | Botón rojo "Exportar PDF" |
| **Volver al listado** | Botón "Volver" |
| **Editar cliente** | Botón "Editar" (si tienes permiso) |

### 8.4 Cómo interpretar el perfil

**Ejemplo práctico:**

Cliente: **Ana Martínez** de Umbrella

**Datos:**
- LTV: $800
- Churn: 75%
- Segmento: Bronce

**Análisis:**
- 🚨 Cliente en **alto riesgo** de abandono
- 💡 Recomendación IA: "Llamar en las próximas 48h con plan de retención"
- 📉 LTV bajo: oportunidad de cross-sell

**Acciones sugeridas:**
1. Contactar inmediatamente
2. Ofrecer descuento de retención
3. Sugerir producto complementario

---

## 9. Predicción de Churn

### 9.1 ¿Qué es el churn?

**Churn** = probabilidad de que un cliente **abandone** el servicio.

Se mide de **0% a 100%**:
- 🟢 **Bajo:** 0% - 39%
- 🟡 **Medio:** 40% - 69%
- 🔴 **Alto:** 70% - 100%

### 9.2 Acceso

Menú lateral → **Churn**

**⚠️ Disponible solo para Admin y Analyst**

![Churn](screenshots/churn.png)
*Figura 6: Módulo de churn*

### 9.3 Información mostrada

| Columna | Descripción |
|---------|-------------|
| Cliente | Nombre completo |
| Empresa | Empresa del cliente |
| Segmento | Badge de color |
| LTV | Valor del cliente |
| Riesgo | Porcentaje (ej. 75%) |
| Nivel | ALTO / MEDIO / BAJO |

### 9.4 Cómo se calcula el churn

El sistema analiza **múltiples factores**:

| Factor | Peso |
|--------|------|
| Días desde la última compra | Alto |
| Frecuencia de transacciones | Medio |
| Ticket promedio | Bajo |
| Estado del cliente | Alto |

**Fórmula simplificada:**
```
Score = suma ponderada de factores
Churn = min(score, 1.0)
```

### 9.5 Cómo recalcular el churn

**Requisito:** Rol Admin o Analyst

**Paso 1:** Clic en **Recalcular Churn**

**Paso 2:** Espera a que termine (2-5 segundos)

**Paso 3:** La tabla se actualiza automáticamente

### 9.6 Interpretación y acciones

| Nivel | Riesgo | Acción sugerida |
|-------|:------:|-----------------|
| 🟢 **BAJO** | < 40% | Monitoreo regular |
| 🟡 **MEDIO** | 40-69% | Contacto proactivo |
| 🔴 **ALTO** | ≥ 70% | Intervención inmediata |

**Protocolo para alto riesgo:**
1. 📞 Llamar en las próximas 48 horas
2. 💰 Ofrecer descuento o beneficio
3. 📊 Revisar historial de soporte
4. 🎯 Aplicar plan de retención personalizado

---

## 10. Segmentación de Clientes

### 10.1 ¿Qué es un segmento?

Un **segmento** clasifica a los clientes según su **valor total** (LTV):

| Segmento | LTV | Descripción |
|----------|-----|-------------|
| 🟤 **Bronce** | < $5,000 | Cliente básico |
| ⚪ **Plata** | $5,000 - $19,999 | Cliente recurrente |
| 🟡 **Oro** | $20,000 - $49,999 | Cliente valioso |
| 🟣 **Platino** | ≥ $50,000 | Cliente VIP |

### 10.2 Acceso

Menú lateral → **Segmentos**

**⚠️ Disponible solo para Admin y Analyst**

![Segmentos](screenshots/segments.png)
*Figura 7: Análisis de segmentos*

### 10.3 Secciones

#### 📊 Distribución por Segmento (Dona)
Gráfico visual de la composición de tu cartera.

#### 📊 Clientes por Industria (Barras)
Top 10 industrias con más clientes.

#### 📋 Resumen por Segmento (Tabla)

| Segmento | Clientes | LTV Promedio | LTV Total | Churn Promedio |
|----------|:--------:|:------------:|:---------:|:--------------:|

#### 🏆 Top 10 Clientes por LTV
Los clientes más valiosos de cada segmento.

### 10.4 Cómo recalcular segmentos

**Requisito:** Rol Admin o Analyst

Clic en **Recalcular Segmentos** → espera → los datos se actualizan.

---

## 11. Recomendaciones con IA

### 11.1 ¿Qué son las recomendaciones?

Son **sugerencias generadas por inteligencia artificial** para cada cliente, basadas en:
- Historial de compras
- Comportamiento
- Segmento
- Riesgo de abandono

### 11.2 Tipos de recomendaciones

| Tipo | Icono | Cuándo aparece |
|------|:-----:|----------------|
| **Retención** | 🛡️ | Cliente con churn ≥ 60% |
| **Upsell** | ⬆️ | Cliente Oro/Platino con bajo churn |
| **Cross-sell** | 🔄 | Cliente Bronce/Plata |

### 11.3 Acceso

Menú lateral → **Recomendaciones**

![Recomendaciones](screenshots/recommendations.png)
*Figura 8: Recomendaciones IA*

### 11.4 Banner de estado

En la parte superior verás un banner que indica el modo:

**🤖 IA Generativa activa:**
```
[🤖] IA Generativa activa                        ⚡ Powered by Groq
     5 recomendaciones generadas con openai/gpt-oss-120b
     ⚡ 3 desde caché
```

**⚙️ Modo reglas de negocio:**
```
[⚙️] Modo reglas de negocio
      La IA no está configurada. Se generan con reglas heurísticas.
```

### 11.5 Filtros disponibles

| Filtro | Opciones |
|--------|----------|
| **Tipo** | Todos, Upsell, Cross-sell, Retención |
| **Segmento** | Todos, Bronce, Plata, Oro, Platino |
| **Límite** | 10, 20, 50, 100 clientes |

### 11.6 Badges de origen

Cada recomendación muestra su origen:

| Badge | Significado |
|-------|-------------|
| 🤖 **IA** | Generada por inteligencia artificial |
| ⚙️ **Reglas** | Generada por reglas de negocio |
| ⚡ **desde caché** | Recuperada de caché (rápida) |

### 11.7 Cómo interpretar una recomendación

Cada tarjeta muestra:

```
┌─────────────────────────────────────────────────────┐
│  🛡️ RETENCIÓN    Plan de retención personalizado   │
│                                                     │
│  Alto riesgo de abandono detectado (75%).          │
│  Contactar en las próximas 48 hrs.                  │
│                                                     │
│  [Prioridad: alta] [Confianza: 85%] [🤖 IA]        │
└─────────────────────────────────────────────────────┘
```

**Componentes:**
- 🏷️ **Tipo** (con icono)
- 📦 **Producto/acción** recomendada
- 📝 **Razón** (por qué)
- 🎯 **Prioridad** (alta/media/baja)
- 📊 **Confianza** (% de certeza)
- 🤖 **Origen** (IA o Reglas)

### 11.8 Forzar modo reglas

Si quieres comparar con reglas de negocio, agrega `?rules=1` a la URL:

```
http://localhost/customer360/recomendaciones.php?rules=1
```

---

## 12. Reportes y Exportación

### 12.1 Acceso

Menú lateral → **Reportes**

![Reportes](screenshots/reports.png)
*Figura 9: Reportes*

### 12.2 KPIs del reporte

- 💰 Ingresos totales
- 👥 Total clientes
- 📈 LTV promedio
- ⚠️ Clientes en alto riesgo

### 12.3 Botones de exportación

| Botón | Formato | Contenido |
|-------|---------|-----------|
| 📄 Clientes (CSV) | CSV | Todos los clientes |
| 📄 Transacciones (CSV) | CSV | Todas las transacciones |
| 📄 Churn (CSV) | CSV | Clientes con churn |
| 🖨️ Imprimir / PDF | PDF | Reporte completo |

### 12.4 Cómo exportar a CSV

**Paso 1:** Clic en el botón deseado

**Paso 2:** El archivo se descarga automáticamente

**Paso 3:** Ábrelo con Excel, Google Sheets o cualquier editor

**Formato del CSV:**
- Codificación: UTF-8 con BOM (compatible con Excel)
- Separador: coma
- Primera fila: encabezados

### 12.5 Cómo exportar a PDF

**Paso 1:** Clic en **Exportar PDF**

**Paso 2:** Aparece un toast indicando "Guardando como PDF..."

**Paso 3:** Se abre el diálogo de impresión del navegador

**Paso 4:** En **Destino** selecciona **"Guardar como PDF"**

**Paso 5:** Clic en **Guardar**

**El PDF incluye:**
- ✅ Título y fecha
- ✅ KPIs
- ✅ Tablas con datos
- ✅ Gráficos
- ❌ Sin menú lateral
- ❌ Sin botones

### 12.6 Gráficos del reporte

#### 📈 Ingresos por Mes
Evolución de los últimos 12 meses.

#### 🎯 Ingresos por Canal
Distribución por canal de venta (polar area).

### 12.7 Tabla resumen por segmento

| Segmento | Clientes | Ingresos | Churn Promedio |
|----------|:--------:|:--------:|:--------------:|

---

## 13. Notificaciones

### 13.1 ¿Qué son?

Alertas automáticas sobre eventos importantes del sistema.

### 13.2 Acceso

🔔 **Campana en el topbar** (arriba a la derecha)

![Notificaciones](screenshots/notifications.png)
*Figura 10: Panel de notificaciones*

### 13.3 Tipos de notificaciones

| Tipo | Color | Cuándo aparece |
|------|:-----:|----------------|
| 🔴 **Cliente en riesgo alto** | Rojo | Cuando churn ≥ 70% |
| 🟢 **Nueva transacción** | Verde | Últimas 48 horas |
| 🔵 **Cliente nuevo** | Azul | Últimos 7 días |
| 🟡 **Ticket negativo** | Amarillo | Ticket con sentimiento negativo |

### 13.4 Cómo usar las notificaciones

**Ver notificaciones:**
1. Clic en la campana 🔔
2. Se abre un dropdown con las notificaciones

**Navegar a un cliente:**
1. Clic en cualquier notificación
2. Se abre el perfil 360° de ese cliente

**Marcar como leídas:**
- **Una:** al hacer clic en ella
- **Todas:** botón "Marcar todas leídas"

### 13.5 El badge rojo

Sobre la campana aparece un **badge rojo** con el número de notificaciones no leídas.

- Si dice `3` → 3 notificaciones nuevas
- Si dice `9+` → más de 9
- Si no aparece → todas leídas

### 13.6 Auto-refresh

Las notificaciones se **actualizan automáticamente** cada **60 segundos** mientras la pestaña esté activa.

---

## 14. Menú de Usuario

### 14.1 Acceso

Clic en tu **avatar** (círculo con tus iniciales) en el topbar, arriba a la derecha.

![Menú de usuario](screenshots/user-menu.png)
*Figura 11: Menú de usuario*

### 14.2 Opciones disponibles

#### 👤 Información de usuario
Muestra:
- Tu nombre completo
- Tu email
- Tu rol (con badge de color)

#### 🔑 Cambiar contraseña

**Paso 1:** Clic en **Cambiar contraseña**

**Paso 2:** Se abre el modal

**Paso 3:** Ingresa:
- Contraseña actual
- Nueva contraseña (mínimo 6 caracteres)
- Confirmar nueva contraseña

**Paso 4:** Clic en **Guardar cambios**

**Validaciones:**
- ✅ La contraseña actual debe ser correcta
- ✅ La nueva debe tener al menos 6 caracteres
- ✅ Ambas deben coincidir

#### 🎨 Cambiar tema
Alterna entre modo claro y oscuro.

#### 🚪 Cerrar sesión
Cierra tu sesión y te redirige al login.

---

## 15. Modo Oscuro

### 15.1 Cómo activarlo

**Opción 1:** Clic en el botón 🌙 del topbar
**Opción 2:** Menú de usuario → "Cambiar tema"

### 15.2 Comportamiento

- 🌙 **Modo claro:** fondo blanco, texto oscuro
- ☀️ **Modo oscuro:** fondo oscuro, texto claro
- 💾 **Persistencia:** recuerda tu preferencia
- 🚫 **Sin flash:** el cambio es instantáneo al recargar

### 15.3 Qué cambia

En modo oscuro:
- Todos los fondos se oscurecen
- Los textos se aclaran
- Los gráficos se adaptan
- Los badges mantienen contraste

### 15.4 Recomendaciones

- 🌙 Usa modo oscuro de noche
- ☀️ Usa modo claro de día
- 🎨 El cambio es **instantáneo**

---

## 16. Gestión de Usuarios (Admin)

### 16.1 Acceso

Menú lateral → **Usuarios**

**⚠️ Solo visible para Admin**

![Usuarios](screenshots/users.png)
*Figura 12: Gestión de usuarios*

### 16.2 Información de la tabla

| Columna | Descripción |
|---------|-------------|
| Usuario | Avatar + nombre completo |
| Email | Correo del usuario |
| Rol | Badge con color según rol |
| Estado | Activo / Inactivo |
| Último acceso | Fecha y hora |
| Acciones | Editar, eliminar |

### 16.3 Cómo crear un usuario

**Paso 1:** Clic en **+ Nuevo Usuario**

**Paso 2:** Llena el formulario:

| Campo | Requerido | Ejemplo |
|-------|:---------:|---------|
| Nombre completo | ✅ | Juan Pérez |
| Email | ✅ | juan@customer360.com |
| Rol | ✅ | Viewer |
| Contraseña | ✅ | mínimo 6 caracteres |

**Paso 3:** Clic en **Guardar**

**Paso 4:** El usuario puede iniciar sesión inmediatamente

### 16.4 Cómo editar un usuario

**Paso 1:** Clic en ✏️ del usuario

**Paso 2:** Puedes modificar:
- Nombre
- Rol
- Contraseña (dejar en blanco para no cambiar)

**Paso 3:** Clic en **Guardar**

### 16.5 Cómo eliminar un usuario

**Paso 1:** Clic en 🗑️

**Paso 2:** Confirma

**⚠️ Restricciones:**
- ❌ No puedes eliminarte a ti mismo
- ❌ No puedes desactivar tu propia cuenta

### 16.6 Roles disponibles

| Rol | Descripción |
|-----|-------------|
| **Admin** | Acceso total + gestión de usuarios |
| **Analyst** | Churn, segmentos, reportes |
| **Sales** | Clientes, edición, recomendaciones |
| **Viewer** | Solo lectura |

---

## 17. Preguntas Frecuentes

### ❓ ¿Por qué no veo el menú de "Churn"?

Tu rol no tiene permiso. Solo **Admin** y **Analyst** pueden verlo.

### ❓ ¿Por qué la IA no genera recomendaciones?

Posibles causas:
1. No hay clave de Groq configurada → usa reglas como fallback
2. Se agotó el límite de Groq → espera 1 minuto
3. La clave es inválida → contacta al admin

### ❓ ¿Qué significa el badge "⚡ desde caché"?

La recomendación ya se había generado antes. Se recupera de la caché para **ahorrar tiempo y tokens**.

### ❓ ¿Cómo exporto un reporte?

1. **CSV:** clic en el botón correspondiente
2. **PDF:** clic en "Exportar PDF" y elige "Guardar como PDF"
3. **Rápido:** `Ctrl + P` desde cualquier página

### ❓ ¿Cómo cierro sesión?

Clic en tu avatar → **Cerrar sesión**.

### ❓ ¿Puedo cambiar mi contraseña?

Sí. Menú de usuario → **Cambiar contraseña**.

### ❓ ¿Cuánto dura mi sesión?

**8 horas** desde el último login.

### ❓ ¿Qué pasa si la IA falla?

El sistema automáticamente usa **reglas de negocio** como fallback. Verás el badge **⚙️ Reglas**.

### ❓ ¿Puedo recuperar un cliente eliminado?

Sí, si fue un **soft delete**. Los clientes quedan con estado `blocked`. Contacta al admin.

### ❓ ¿Cómo reporto un bug?

Contacta a soporte: soporte@plurione.com

---

## 18. Solución de Problemas

### 🔴 No puedo iniciar sesión

**Posibles causas:**
1. Email o contraseña incorrectos
2. Tu cuenta está desactivada
3. Sesión expirada

**Solución:**
1. Verifica tus credenciales
2. Contacta al admin
3. Intenta de nuevo

### 🔴 La página no carga

**Posibles causas:**
1. Apache/MySQL no están corriendo
2. Error 500 en PHP
3. Problema de red

**Solución:**
1. Abre XAMPP Control Panel → verifica que Apache y MySQL estén verdes
2. Revisa `C:\xampp\apache\logs\error.log`
3. Reinicia Apache

### 🔴 Los gráficos no se ven

**Posibles causas:**
1. Chart.js no cargó
2. Los canvas no existen
3. Error en JS

**Solución:**
1. Recarga con `Ctrl + Shift + R`
2. Abre F12 → Console → revisa errores
3. Verifica que Chart.js esté en `header.php`

### 🔴 La IA no funciona

**Solución:**
1. Verifica que `config/ai.local.php` exista
2. Confirma que la API key de Groq sea válida
3. Revisa `C:\xampp\apache\logs\error.log`
4. El sistema usará reglas como fallback

### 🔴 No puedo editar clientes

**Posible causa:** tu rol no lo permite.

**Solución:** Solo **Admin** y **Sales** pueden editar.

### 🔴 Las notificaciones no aparecen

**Solución:**
1. Recarga la página
2. Verifica que `api/notifications.php` responda
3. Revisa F12 → Network

---

## 19. Glosario

| Término | Definición |
|---------|-----------|
| **API** | Interfaz de programación que conecta el frontend con el backend |
| **Churn** | Riesgo de abandono de un cliente (0-100%) |
| **Cross-sell** | Vender productos complementarios |
| **CSV** | Formato de archivo separado por comas (compatible con Excel) |
| **Dashboard** | Panel visual con KPIs y gráficos |
| **Fallback** | Modo alternativo cuando algo falla |
| **Groq** | Proveedor de IA generativa usado en el proyecto |
| **IA** | Inteligencia Artificial |
| **KPI** | Indicador clave de rendimiento |
| **LTV** | Lifetime Value — valor total del cliente |
| **PDF** | Formato de documento portátil |
| **Perfil 360°** | Vista unificada con toda la info del cliente |
| **Retención** | Acciones para evitar que un cliente se vaya |
| **Segmento** | Clasificación por valor (Bronce, Plata, Oro, Platino) |
| **Soft delete** | Eliminación lógica (marca como inactivo sin borrar) |
| **Upsell** | Vender un plan superior |

---

## 20. Contacto y Soporte

### 📞 Canales de soporte

| Canal | Contacto |
|-------|----------|
| **Email** | soporte@plurione.com |
| **Documentación** | `/docs` |
| **GitHub** | [github.com/tu-usuario/customer360](https://github.com/tu-usuario/customer360) |

### 🕐 Horario de atención

- Lunes a Viernes: 9:00 - 18:00
- Sábados: 10:00 - 14:00
- Domingos: Cerrado

### 📝 Al reportar un problema, incluye:

1. **Descripción** del problema
2. **Pasos** para reproducirlo
3. **Captura de pantalla** (si es posible)
4. **Navegador** y versión
5. **Fecha y hora** del incidente

---

## 📌 Notas finales

### Versión del manual

- **Versión actual:** 1.0
- **Última actualización:** [Fecha]
- **Próxima revisión:** [Fecha + 3 meses]

### Historial de cambios

| Versión | Fecha | Cambios |
|:-------:|-------|---------|
| 1.0 | [Fecha] | Versión inicial |

---

**© 2026 PluriOne — Todos los derechos reservados**