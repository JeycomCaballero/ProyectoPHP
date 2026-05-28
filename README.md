# 🅿️ Parqueadero Boyacá - API REST & Panel de Control

Sistema de gestión para el control de entradas, salidas y cobros de un parqueadero. Este proyecto fue desarrollado como parte del programa de Análisis y Desarrollo de Software (ADSO) del SENA CIMM.

El sistema implementa una arquitectura cliente-servidor, separando la lógica de negocio en una **API REST construida con Java** y un **Frontend interactivo desarrollado en PHP, HTML, CSS y JavaScript**.

---

## 🚀 Características Principales

* **Control de Acceso:** Registro rápido de entradas y salidas de vehículos.
* **Gestión de Vehículos (CRUD):** Administración completa de clientes y sus vehículos registrados (Carro, Moto, Camión).
* **Cálculo Automático de Tarifas:** El sistema calcula el tiempo de estancia (mínimo 1 hora) y genera el cobro según el tipo de vehículo:
  * 🚗 Carro: $3.000 COP/hora
  * 🏍️ Moto: $1.500 COP/hora
  * 🚛 Camión: $5.000 COP/hora
* **Panel en Tiempo Real:** Dashboard interactivo con un cronómetro vivo (JavaScript) que muestra el tiempo de estancia de cada vehículo dentro del parqueadero.
* **Reportes y Comprobantes:** Generación de recibos de salida (imprimibles) y un panel de reporte con los ingresos totales del día.

---

## 🛠️ Tecnologías y Herramientas

### Backend (API REST)
* **Lenguaje:** Java
* **Arquitectura:** Servlets (Java EE) con patrón DAO (Data Access Object).
* **Servidor:** Apache Tomcat (Puerto 8080).
* **Seguridad/Red:** Implementación de Filtro CORS manual para permitir peticiones desde el frontend en Apache.
* **Base de Datos:** MySQL (vía XAMPP), conectada mediante JDBC.

### Frontend (Cliente UI)
* **Servidor de Interfaz:** PHP (Apache en XAMPP). PHP actúa como intermediario consumiendo la API Java usando `cURL`.
* **Diseño:** HTML5 y CSS3 puro (variables CSS, flexbox, grid, badges y diseño responsivo).
* **Interactividad:** Vanilla JavaScript para búsqueda en tiempo real, cronómetros y overlays de carga.

---

## ⚙️ Instalación y Despliegue

### 1. Base de Datos
1. Inicia el servicio de MySQL en XAMPP.
2. Crea una base de datos llamada `parqueadero_boyaca`.
3. Importa el script SQL (no incluido en este repo, debes generarlo en base a los modelos) que crea las tablas `vehiculos` y `registros`.
4. Las credenciales por defecto son usuario `root` sin contraseña.

### 2. Backend (Java)
1. Abre el proyecto en tu IDE (como Eclipse, IntelliJ o NetBeans).
2. Asegúrate de tener el driver `mysql-connector-j` en tus librerías.
3. Despliega la aplicación en un servidor Tomcat corriendo en el puerto `8080`.

### 3. Frontend (PHP)
1. Inicia el servicio de Apache en XAMPP.
2. Copia la carpeta del frontend en el directorio `htdocs`.
3. Verifica que el archivo `config.php` esté apuntando correctamente a `http://localhost:8080/api`.
4. Accede en tu navegador a `http://localhost/tu-carpeta-frontend/index.php`.

---

## 📡 Endpoints de la API (Referencia)

El backend expone las siguientes rutas principales:

**Vehículos**
* `GET /api/vehiculos` - Lista todos
* `GET /api/vehiculos?placa=XX` - Busca por placa
* `POST /api/vehiculos` - Registra nuevo
* `DELETE /api/vehiculos/{id}` - Elimina un vehículo

**Registros (Entradas y Salidas)**
* `GET /api/registros` - Lista vehículos activos en el parqueadero
* `GET /api/registros?estado=FINALIZADO` - Lista el historial
* `POST /api/registros` - Registra una nueva entrada
* `PUT /api/registros/{id}/salida` - Registra salida y calcula el total a pagar
* `GET /api/registros/reporte` - Obtiene el consolidado del día

---
*Desarrollado con ☕ y código para la regional Casanare / Boyacá.*
