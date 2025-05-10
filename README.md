
> ### Laravel Product & Category CRUD API

Una API RESTful construida en Laravel 10 para gestionar productos y categorías, con autenticación usando Sanctum y control de roles (admin y user).

## 1. Configuración local

### Requisitos previos:
- PHP >= 8.0
- Composer
- MySQL o cualquier base de datos compatible con Laravel

### Pasos para la configuración:
1. Clonar el repositorio
```bash
git clone https://github.com/management_inventory/laravel-products-categories.git
cd laravel-products-categories
```

2. Instalar dependencias
```bash
composer install
```

3. Configurar el archivo .env
```bash
cp .env.example .env
```
Editar el archivo `.env` con la configuración de tu base de datos.

4. Generar la clave de la aplicación
```bash
php artisan key:generate
```

5. Ejecutar las migraciones
```bash
php artisan migrate
```

6. Iniciar el servidor de desarrollo
```bash
php artisan serve
```

La API ahora estará disponible en `http://localhost:8000`.

## 2. Colección Postman / Swagger

- **Postman**: [Descargar colección Postman](http://enlace-a-tu-coleccion-postman.com)

## 3. URL pública de despliegue

Puedes acceder a la API desplegada en el siguiente enlace:

[URL pública](http://url-publica-de-tu-api.com)

## 4. Decisiones de diseño

### Elección de enum vs tabla de roles
Optamos por una tabla de roles en la base de datos, lo cual permite un enfoque más flexible y escalable en comparación con el uso de un `enum` en el modelo. Esto facilita agregar nuevos roles sin necesidad de modificar el código de la aplicación.

### Middleware o paquete de autorización
Se ha utilizado el middleware `auth:sanctum` para la autenticación de usuarios. Para la autorización, se usa un middleware personalizado `role:admin` que restringe el acceso a ciertas rutas a usuarios con el rol de administrador.

### Cambios al esquema de base de datos o endpoints originales
- Se añadió una tabla de `categories` para almacenar las categorías de los productos.
- Se creó una relación entre las tablas `products` y `categories` mediante una clave foránea.
- Los endpoints de productos fueron extendidos para manejar categorías asociadas a cada producto.

## 5. Endpoints

### Productos
#### 1. Obtener todos los productos
- **Método**: `GET`
- **Ruta**: `/api/products`
- **Descripción**: Devuelve una lista de todos los productos.

#### 2. Obtener un producto por ID
- **Método**: `GET`
- **Ruta**: `/api/products/{id}`
- **Descripción**: Devuelve un producto específico.

#### 3. Crear un producto
- **Método**: `POST`
- **Ruta**: `/api/products`
- **Descripción**: Crea un nuevo producto. Solo accesible por usuarios con el rol `admin`.

#### 4. Actualizar un producto
- **Método**: `PUT`
- **Ruta**: `/api/products/{id}`
- **Descripción**: Actualiza los datos de un producto. Solo accesible por usuarios con el rol `admin`.

#### 5. Eliminar un producto
- **Método**: `DELETE`
- **Ruta**: `/api/products/{id}`
- **Descripción**: Elimina un producto. Solo accesible por usuarios con el rol `admin`.

### Categorías
#### 1. Obtener todas las categorías
- **Método**: `GET`
- **Ruta**: `/api/categories`
- **Descripción**: Devuelve una lista de todas las categorías.

#### 2. Obtener una categoría por ID
- **Método**: `GET`
- **Ruta**: `/api/categories/{id}`
- **Descripción**: Devuelve una categoría específica.

#### 3. Crear una categoría
- **Método**: `POST`
- **Ruta**: `/api/categories`
- **Descripción**: Crea una nueva categoría. Solo accesible por usuarios con el rol `admin`.

#### 4. Actualizar una categoría
- **Método**: `PUT`
- **Ruta**: `/api/categories/{id}`
- **Descripción**: Actualiza los datos de una categoría. Solo accesible por usuarios con el rol `admin`.

#### 5. Eliminar una categoría
- **Método**: `DELETE`
- **Ruta**: `/api/categories/{id}`
- **Descripción**: Elimina una categoría. Solo accesible por usuarios con el rol `admin`.

