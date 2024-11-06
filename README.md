# CASFID - Sistema de Gestión de Libros

Este proyecto es una aplicación web desarrollada en PHP para gestionar una base de datos de libros. Permite realizar operaciones como la creación, actualización, eliminación y búsqueda de libros mediante un sistema de gestión de base de datos. Está protegida contra ataques de inyección SQL, XSS, y CSRF. El proyecto también incluye pruebas unitarias para asegurar el correcto funcionamiento de la aplicación.

## Requisitos

- PHP 8.1 o superior
- Composer
- PHPunit
- MySQL o MariaDB
- Docker (opcional)

## Instalación

### Opción 1: Instalación Local

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/tu-usuario/casfid.git
   cd casfid
   ```

2. **Instalar las dependencias con Composer**

   Si no tienes Composer instalado globalmente, puedes instalarlo desde [aquí](https://getcomposer.org/download/).

   ```bash
   composer install
   ```

3. **Configuración de la base de datos**

   Crea una base de datos MySQL o MariaDB y configura la conexión en el archivo `src/Infrastructure/DatabaseConnection.php` con los detalles correctos (host, usuario, contraseña, base de datos).

4. **Configurar el servidor web**

   Puedes usar Apache o Nginx para servir la aplicación. Si estás usando Apache, asegúrate de que el archivo `.htaccess` esté presente en el directorio `public` para redirigir todas las peticiones al archivo `index.php`.

5. **Ejecutar la aplicación**

   Ahora puedes acceder a la aplicación en tu navegador accediendo a la URL del servidor (por ejemplo, `http://localhost` si estás ejecutando en local).

---

### Opción 2: Uso con Docker

1. **Construir la imagen Docker**

   Si prefieres usar Docker, ejecuta el siguiente comando para construir la imagen:

   ```bash
   docker build -t casfid .
   ```

2. **Ejecutar el contenedor**

   Después de la construcción, ejecuta el contenedor con:

   ```bash
   docker run -p 8080:80 -d casfid
   ```

   Esto iniciará el servidor web dentro del contenedor y lo expondrá en el puerto 8080 de tu máquina local.

3. **Acceder a la aplicación**

   Abre tu navegador y ve a `http://localhost:8080` para ver la aplicación en funcionamiento.

---

## Funcionalidades

1. **Creación de libros**
   - Los usuarios pueden crear nuevos libros proporcionando un título, autor, ISBN y año de publicación.
   - La aplicación valida los datos ingresados para asegurarse de que el ISBN sea válido y único.

2. **Actualización de libros**
   - Los usuarios pueden actualizar la información de un libro, como el título, autor y año de publicación.
   - Se realiza una validación del ISBN para asegurarse de que la actualización sea válida.

3. **Eliminación de libros**
   - Los usuarios pueden eliminar libros existentes proporcionando el ISBN.
   - La eliminación se realiza de forma segura, verificando que el libro exista.

4. **Búsqueda de libros**
   - Los usuarios pueden buscar libros por título o autor.

5. **Protección CSRF y validación de tokens**
   - La aplicación utiliza un sistema de tokens CSRF para proteger los formularios de ataques de tipo Cross-Site Request Forgery (CSRF).
   - Los tokens CSRF son validados en cada solicitud de modificación de datos.

6. **Inyección SQL protegida**
   - La aplicación utiliza consultas preparadas con PDO para evitar vulnerabilidades de inyección SQL.

7. **XSS protegido**
   - Los datos introducidos por el usuario son validados y escapados correctamente para evitar ataques Cross-Site Scripting (XSS).

---

## Pruebas Unitarias

El proyecto incluye pruebas unitarias para verificar el correcto funcionamiento de la aplicación.

1. **Ejecutar las pruebas**

   Para ejecutar las pruebas, usa PHPUnit. Asegúrate de haber instalado PHPUnit en tu proyecto o de tener una versión global instalada.

   ```bash
   vendor/bin/phpunit --bootstrap vendor/autoload.php src/tests
   ```

   Las pruebas están ubicadas en la carpeta `tests`.

2. **Pruebas cubiertas:**
   - Creación de libros (`BookControllerTest::testCreate`)
   - Actualización de libros (`BookControllerTest::testUpdate`)
   - Eliminación de libros (`BookControllerTest::testDelete`)

---
