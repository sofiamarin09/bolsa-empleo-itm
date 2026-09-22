## Bolsa de Empleo ITM — Sistema de Pre-registro y Validación Académica

Aplicación web para el pre-registro de aspirantes a la Bolsa de Empleo del Instituto Tecnológico Metropolitano (ITM). El sistema permite a estudiantes activos y egresados registrar su información personal, valida automáticamente su estado académico contra el SIA del ITM, y gestiona su vinculación ante el Servicio Público de Empleo (SPE).

Proyecto de grado (Tecnología en Desarrollo de Software), desarrollado en equipo (2 personas) en el marco de un **semillero de investigación** del ITM, cubriendo el ciclo completo: análisis, diseño, base de datos, backend y frontend, bajo metodología ágil SCRUM con 7 sprints.

## Estado del proyecto

Funcional y probado en ambiente de desarrollo local con datos de prueba. Entregado al equipo de Tecnología del ITM para su despliegue en ambiente de producción.

## Descripción

El Programa de Egresados del ITM necesitaba un sistema web para centralizar el pre-registro de aspirantes a la bolsa de empleo, reemplazando un proceso manual basado en archivos Excel. El sistema automatiza la validación académica, envía notificaciones por correo electrónico y permite al personal administrativo gestionar los aspirantes ante el SPE desde un panel de control con gráficos, informes e importación masiva de datos.

## Funcionalidades principales

### Módulo público (aspirante)

- **Formulario de pre-registro** en 6 secciones: identificación, información personal, contacto, datos adicionales, ubicación dinámica (países, departamentos y municipios con datos DANE) y términos y condiciones.
- **Validación académica automática**: consulta al SIA del ITM por número de documento y clasifica al aspirante como estudiante activo, egresado, egresado activo (cursando otro programa) o externo.
- **Notificaciones por correo electrónico**: 4 plantillas diferenciadas según el tipo de usuario, con orientación al SPE para usuarios externos.
- **Página de resultado** con el detalle de la validación.

### Módulo administrativo (panel de control)

- **Dashboard**: estadísticas de registro, notificaciones enviadas/fallidas, gestión SPE y últimos registros.
- **Gestión de usuarios** con filtros múltiples, búsqueda, paginación y vista detallada por aspirante.
- **Gestión SPE**: marcar aspirantes como gestionados con un clic (AJAX), con envío automático de confirmación y trazabilidad de quién gestionó y cuándo.
- **Importación masiva desde Excel** (.xlsx/.xls/.csv): mapeo manual de columnas, normalización automática de datos, detección de duplicados e importación por lotes (hasta 12.000 registros).
- **Exportación de informes** en Excel.
- **Gráficas interactivas** con Chart.js: distribución de registros, notificaciones por correo, registros en el tiempo y resumen de validaciones, con 9 filtros globales.
- **Roles administrativos**: SuperAdmin y Gestor, con activación/inactivación y middleware de control de sesión.
- **Recuperación de contraseña** con token seguro y vencimiento por tiempo.
- **Cierre de sesión automático** por inactividad.

## Tecnologías utilizadas 
Categoría Herramientas Lenguaje PHP 8.4 Framework Laravel 13.4 Base de datos PostgreSQL 15+ Frontend Blade, HTML, CSS, JavaScript Gráficas Chart.js 4.4.1 + chartjs-plugin-datalabels 2.2.0 Excel Maatwebsite/Excel 3.1.68 (exportación) + PhpSpreadsheet (importación) Correo Laravel Mail con SMTP Control de versiones Git / GitHub Metodología Scrum con 7 sprints

## Base de datos

8 tablas en PostgreSQL, con índices de rendimiento, restricciones de validación y llaves foráneas:

- `administradores` — usuarios del sistema con roles y recuperación de contraseña.
- `usuarios_aspirantes` — aspirantes con estados académicos y gestión SPE.
- `validaciones_academicas` — registro de cada validación contra el SIA.
- `notificaciones` — historial de correos enviados con su estado.
- `registro_auditoria` — trazabilidad de eventos del sistema.
- `paises`, `departamentos`, `municipios` — catálogos DANE para ubicación dinámica.

## Mi rol en el proyecto

Desarrollado en equipo por dos personas, con participación en todas las etapas:

- Análisis y levantamiento de requisitos con el cliente (Programa de Egresados del ITM).
- Diseño de la base de datos (modelo relacional, restricciones e índices).
- Desarrollo backend: controladores, servicios de validación académica y notificaciones.
- Desarrollo frontend: formulario de pre-registro y panel administrativo.
- Implementación de cambios solicitados por el cliente a lo largo de los sprints.
- Control de versiones con Git, trabajo por ramas (feature branches) y fusión a main.

## Instalación local

Requisitos previos: PHP 8.4, Composer 2.x, PostgreSQL 15+ y Git.

```bash
# 1. Clonar el repositorio
git clone https://github.com/sofiamarin09/bolsa-empleo-itm.git
cd bolsa-empleo-itm

# 2. Instalar dependencias
composer install

# 3. Configurar el entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar la base de datos en el archivo .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bolsa_empleo_itm
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña

# 5. Crear la base de datos y ejecutar migraciones
php artisan migrate

# 6. Configurar correo SMTP en el archivo .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587

# 7. Levantar el servidor
php artisan serve
```

La aplicación quedará disponible en `http://localhost:8000`.

## Autores

- **Sofía Marín Restrepo** – [github.com/sofiamarin09](https://github.com/sofiamarin09)
- **Andrés Felipe Ortiz Morales** – [github.com/AndresFelipeMorales](https://github.com/AndresFelipeMorales)

Proyecto desarrollado como trabajo de grado para el programa de Tecnología en Desarrollo de Software del Instituto Tecnológico Metropolitano (ITM), Medellín, Colombia.
