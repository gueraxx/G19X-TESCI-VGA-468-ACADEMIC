# 📝 Changelog — Customer 360

Todos los cambios notables del proyecto.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es/1.0.0/).

---

## [1.0.0] — 2025-XX-XX

### ✨ Añadido

- Autenticación con roles (admin, analyst, sales, viewer)
- Dashboard ejecutivo con KPIs y 4 gráficos
- Gestión de clientes con búsqueda
- Perfil 360° con timeline de interacciones
- Predicción de churn heurística
- Segmentación automática por LTV
- Recomendaciones con IA generativa (Groq + GPT-OSS 120B)
- Caché de respuestas de IA (24 horas)
- Sistema de notificaciones inteligentes
- Exportación a CSV y PDF
- Modo oscuro con persistencia
- Gestión de usuarios (solo admin)
- Diseño responsive
- Documentación completa (PRD, MVP, Manual, Arquitectura)

### 🔧 Cambiado

- Migración de reglas de negocio a IA generativa
- Refactorización de archivos JS con IIFE para evitar colisiones
- Optimización de consultas SQL con índices

### 🐛 Corregido

- Error de `BASE_URL` duplicada en múltiples archivos JS
- Modo oscuro en tarjetas del perfil 360°
- Dropdown de notificaciones sin estilos
- Rutas de `require_once` en páginas raíz
- Codificación de archivos JS a UTF-8

---

## [0.5.0] — 2025-XX-XX (Beta)

### ✨ Añadido

- Estructura base del proyecto (PHP + Bootstrap)
- Conexión a MySQL
- Dashboard inicial con KPIs
- Listado de clientes
- Perfil básico del cliente
- Predicción de churn inicial
- Recomendaciones con reglas de negocio

### 🐛 Corregido

- Estilos de tablas en modo oscuro
- Carga de Chart.js

---

## [0.1.0] — 2025-XX-XX (Alpha)

### ✨ Añadido

- Setup inicial del proyecto
- Estructura de carpetas
- Base de datos con datos de prueba
- Documentación inicial (PRD, MVP)

---

**Última actualización:** [07/10/26]