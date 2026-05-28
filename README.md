# [cite_start]🅿️ Parqueadero Boyacá - API REST & Panel de Control [cite: 1, 304]

Sistema de gestión para el control de entradas, salidas y cobros de un parqueadero. [cite_start]Este proyecto fue desarrollado como parte del programa de Análisis y Desarrollo de Software (ADSO) del SENA CIMM[cite: 92].

[cite_start]El sistema implementa una arquitectura cliente-servidor, separando la lógica de negocio en una **API REST construida con Java** y un **Frontend interactivo desarrollado en PHP, HTML, CSS y JavaScript**[cite: 10, 321, 358].

---

## 🚀 Características Principales

* [cite_start]**Control de Acceso:** Registro rápido de entradas y salidas de vehículos[cite: 107, 334].
* [cite_start]**Gestión de Vehículos (CRUD):** Administración completa de clientes y sus vehículos registrados (Carro, Moto, Camión)[cite: 14, 93, 266].
* [cite_start]**Cálculo Automático de Tarifas:** El sistema calcula el tiempo de estancia (mínimo 1 hora) y genera el cobro según el tipo de vehículo[cite: 151, 166, 167]:
  * [cite_start]🚗 Carro: $3.000 COP/hora [cite: 152]
  * [cite_start]🏍️ Moto: $1.500 COP/hora [cite: 153]
  * [cite_start]🚛 Camión: $5.000 COP/hora [cite: 153]
* [cite_start]**Panel en Tiempo Real:** Dashboard interactivo con un cronómetro vivo (JavaScript) que muestra el tiempo de estancia de cada vehículo dentro del parqueadero[cite: 256, 303].
* [cite_start]**Reportes y Comprobantes:** Generación de recibos de salida (imprimibles) y un panel de reporte con los ingresos totales del día[cite: 252, 295].

---

## 🛠️ Tecnologías y Herramientas

### [cite_start]Backend (API REST) [cite: 1]
* [cite_start]**Lenguaje:** Java [cite: 10]
* [cite_start]**Arquitectura:** Servlets (Java EE) con patrón DAO (Data Access Object)[cite: 14, 131].
* [cite_start]**Servidor:** Apache Tomcat (Puerto 8080)[cite: 10, 306].
* [cite_start]**Seguridad/Red:** Implementación de Filtro CORS manual para permitir peticiones desde el frontend en Apache[cite: 1, 9].
* [cite_start]**Base de Datos:** MySQL (vía XAMPP), conectada mediante JDBC[cite: 4, 6].

### [cite_start]Frontend (Cliente UI) [cite: 10, 303]
* [cite_start]**Servidor de Interfaz:** PHP (Apache en XAMPP)[cite: 10, 358]. [cite_start]PHP actúa como intermediario consumiendo la API Java usando `cURL`[cite: 358].
* [cite_start]**Diseño:** HTML5 y CSS3 puro (variables CSS, flexbox, grid, badges y diseño responsivo)[cite: 194, 198, 208, 222].
* [cite_start]**Interactividad:** Vanilla JavaScript para búsqueda en tiempo real, cronómetros y overlays de carga[cite: 256, 262, 263].

---

## ⚙️ Instalación y Despliegue

### 1. Base de Datos
1. [cite_start]Inicia el servicio de MySQL en XAMPP[cite: 4].
2. [cite_start]Crea una base de datos llamada `parqueadero_boyaca`[cite: 4].
3. [cite_start]Importa el script SQL (no incluido en este repo, debes generarlo en base a los modelos) que crea las tablas `vehiculos` y `registros`[cite: 131, 151].
4. [cite_start]Las credenciales por defecto son usuario `root` sin contraseña[cite: 5].

### 2. Backend (Java)
1. Abre el proyecto en tu IDE (como Eclipse, IntelliJ o NetBeans).
2. [cite_start]Asegúrate de tener el driver `mysql-connector-j` en tus librerías[cite: 6].
3. [cite_start]Despliega la aplicación en un servidor Tomcat corriendo en el puerto `8080`[cite: 306].

### 3. Frontend (PHP)
1. [cite_start]Inicia el servicio de Apache en XAMPP[cite: 10].
2. [cite_start]Copia la carpeta del frontend en el directorio `htdocs`[cite: 10].
3. [cite_start]Verifica que el archivo `config.php` esté apuntando correctamente a `http://localhost:8080/api`[cite: 358].
4. [cite_start]Accede en tu navegador a `http://localhost/tu-carpeta-frontend/index.php`[cite: 10].

---

## 📡 Endpoints de la API (Referencia)

El backend expone las siguientes rutas principales:

**Vehículos**
* [cite_start]`GET /api/vehiculos` - Lista todos [cite: 14]
* [cite_start]`GET /api/vehiculos?placa=XX` - Busca por placa [cite: 14]
* [cite_start]`POST /api/vehiculos` - Registra nuevo [cite: 14]
* [cite_start]`DELETE /api/vehiculos/{id}` - Elimina un vehículo [cite: 14]

**Registros (Entradas y Salidas)**
* [cite_start]`GET /api/registros` - Lista vehículos activos en el parqueadero [cite: 303]
* [cite_start]`GET /api/registros?estado=FINALIZADO` - Lista el historial [cite: 321]
* [cite_start]`POST /api/registros` - Registra una nueva entrada [cite: 338]
* [cite_start]`PUT /api/registros/{id}/salida` - Registra salida y calcula el total a pagar [cite: 285]
* [cite_start]`GET /api/registros/reporte` - Obtiene el consolidado del día [cite: 295]

---
*Desarrollado con ☕ y código para la regional Casanare / Boyacá.*
