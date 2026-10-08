# 🧪 Plan de Pruebas — Customer 360

## QA & Testing

---

### 1. Objetivo

Verificar que todas las funcionalidades del MVP funcionan correctamente, sin errores, y cumplen con los criterios de aceptación.

---

### 2. Alcance

- Pruebas funcionales de todas las páginas
- Pruebas de los endpoints API
- Pruebas de permisos por rol
- Pruebas de rendimiento
- Pruebas de seguridad
- Pruebas responsive

---

### 3. Casos de Prueba

#### TC-01: Autenticación

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 1.1 | Login con credenciales válidas | Acceso al dashboard | ✅ |
| 1.2 | Login con contraseña incorrecta | Mensaje de error | ✅ |
| 1.3 | Acceso a página sin sesión | Redirige a login | ✅ |
| 1.4 | Sesión expira tras 8h | Redirige con mensaje | ✅ |
| 1.5 | Logout | Cierra sesión | ✅ |

#### TC-02: Permisos por Rol

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 2.1 | Viewer intenta acceder a churn.php | Error 403 | ✅ |
| 2.2 | Sales no ve "Churn" en el menú | Menú filtrado | ✅ |
| 2.3 | Analyst puede recalcular churn | Botón visible | ✅ |
| 2.4 | Solo Admin ve "Usuarios" | Menú filtrado | ✅ |

#### TC-03: Dashboard

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 3.1 | Cargar dashboard | KPIs con números | ✅ |
| 3.2 | 4 gráficos visibles | Dona, barras, línea, polar | ✅ |
| 3.3 | Top 5 clientes visibles | Tabla con 5 filas | ✅ |
| 3.4 | Actividad reciente | Tabla con transacciones | ✅ |

#### TC-04: Clientes

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 4.1 | Listar clientes | Tabla con datos | ✅ |
| 4.2 | Buscar cliente | Resultados filtrados | ✅ |
| 4.3 | Ver perfil 360° | Datos completos | ✅ |
| 4.4 | Timeline de interacciones | Iconos y fechas | ✅ |

#### TC-05: Recomendaciones IA

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 5.1 | Generar recomendaciones | Lista con IA | ✅ |
| 5.2 | Banner de estado IA | Azul si activa | ✅ |
| 5.3 | Badge IA vs Reglas | Correcto | ✅ |
| 5.4 | Caché de IA | Segunda carga rápida | ✅ |
| 5.5 | Fallback a reglas | Sin clave de Groq | ✅ |

#### TC-06: Exportación

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 6.1 | Exportar clientes a CSV | Archivo descargado | ✅ |
| 6.2 | Exportar PDF de perfil | PDF con estilos | ✅ |
| 6.3 | Imprimir dashboard | Sin sidebar | ✅ |

#### TC-07: Modo Oscuro

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 7.1 | Toggle tema | Cambia a oscuro | ✅ |
| 7.2 | Persistencia | Guardado en localStorage | ✅ |
| 7.3 | Sin flash al recargar | Sin pantalla blanca | ✅ |

#### TC-08: Notificaciones

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 8.1 | Badge rojo visible | Con número | ✅ |
| 8.2 | Dropdown abre/cierra | Animación suave | ✅ |
| 8.3 | Marcar como leída | Persistencia | ✅ |

#### TC-09: Rendimiento

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 9.1 | Carga de dashboard | < 2 segundos | ✅ |
| 9.2 | API responden | < 500 ms | ✅ |
| 9.3 | 100 clientes sin problemas | Sin degradación | ✅ |

#### TC-10: Responsive

| # | Caso | Esperado | Estado |
|---|------|----------|:------:|
| 10.1 | Vista móvil (375px) | Sin scroll horizontal | ✅ |
| 10.2 | Vista tablet (768px) | Layout adaptado | ✅ |
| 10.3 | Sidebar colapsable | Oculta en móvil | ✅ |

---

### 4. Pruebas de Seguridad

| # | Prueba | Esperado | Estado |
|---|--------|----------|:------:|
| S-01 | SQL Injection en login | Bloqueado (PDO) | ✅ |
| S-02 | XSS en campos | Escapado (htmlspecialchars) | ✅ |
| S-03 | Acceso sin sesión a API | 401/403 | ✅ |
| S-04 | Contraseñas hasheadas | bcrypt en BD | ✅ |
| S-05 | .env fuera de Git | .gitignore | ✅ |

---

### 5. Herramientas de Prueba

- **Chrome DevTools** — consola, network, responsive
- **Firefox Developer Edition** — verificación cruzada
- **Postman** — pruebas de API (opcional)
- **Lighthouse** — rendimiento y accesibilidad

---

### 6. Resultados

| Categoría | Casos | Pasados | Fallidos | Cobertura |
|-----------|:-----:|:-------:|:--------:|:---------:|
| Autenticación | 5 | 5 | 0 | 100% |
| Permisos | 4 | 4 | 0 | 100% |
| Dashboard | 4 | 4 | 0 | 100% |
| Clientes | 4 | 4 | 0 | 100% |
| Recomendaciones | 5 | 5 | 0 | 100% |
| Exportación | 3 | 3 | 0 | 100% |
| Modo oscuro | 3 | 3 | 0 | 100% |
| Notificaciones | 3 | 3 | 0 | 100% |
| Rendimiento | 3 | 3 | 0 | 100% |
| Responsive | 3 | 3 | 0 | 100% |
| Seguridad | 5 | 5 | 0 | 100% |
| **TOTAL** | **42** | **42** | **0** | **100%** |

---

### 7. Conclusión

Todas las pruebas funcionales, de seguridad y rendimiento fueron **exitosas**. El sistema está listo para entrega.

---

**Última ejecución:** [07/10/26]
**Responsable QA:** [Valentina Gil]