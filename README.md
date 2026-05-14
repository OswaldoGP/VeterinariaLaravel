# Veterinaria Laravel

Este es un sistema web de gestión veterinaria desarrollado en **Laravel 12**. 

## 📌 Características Implementadas (Hasta ahora)

### 1. Plantilla e Interfaz de Usuario
- Integración de la plantilla **SB Admin 2** (StartBootstrap) en todo el ecosistema del proyecto.
- Separación de la estructura HTML mediante el uso de plantillas Blade (`layouts` y `partials`) para mantener un código limpio y modular.

### 2. Sistema de Autenticación
- Sistema funcional de **Login** y **Registro** adaptado visualmente con el diseño de SB Admin 2.
- Layout exclusivo de autenticación (`layouts/auth.blade.php`).
- Protección de rutas utilizando middlewares para asegurar que las páginas de sistema no puedan ser vistas sin iniciar sesión y que los usuarios que ya iniciaron sesión no puedan ver el Login.

### 3. Gestión de Roles
Se implementó un sistema de control de acceso básico basado en un campo de la base de datos:
- Modificación en la migración de la tabla `users` para incluir el campo enum **`rol`** con valores permitidos: `'administrador'` y `'veterinario'`.
- Modificación en el `AuthController` para redirigir a los usuarios dependiendo de su perfil al momento de iniciar sesión.

### 4. Paneles y Vistas Independientes
- **Administrador:** Es redirigido a `/admin/home` y cuenta con un Layout especializado (`layouts/admin.blade.php`) que carga sus propios partials (`admin_sidebar` y `admin_topbar`) para mantener la gestión global aislada de la operación diaria.
- **Veterinario:** Es redirigido a `/home` (Dashboard Operativo) y utiliza el layout estándar (`layouts/main.blade.php`).

## 🛠 Instalación y Configuración Local

1. Clona este repositorio:
   ```bash
   git clone git@github.com:OswaldoGP/VeterinariaLaravel.git
   ```
2. Instala las dependencias de Composer y NPM:
   ```bash
   composer install
   npm install
   ```
3. Copia el archivo de entorno y genera la clave de aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Ejecuta las migraciones y los seeders para tener los usuarios de prueba:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Inicia tu servidor local:
   ```bash
   php artisan serve
   ```

## 👥 Usuarios por Defecto (Seeders)

Para facilitar las pruebas, la base de datos se inicializa automáticamente con dos usuarios:

| Rol | Correo Electrónico | Contraseña |
| --- | --- | --- |
| Administrador | `admin@admin.com` | `admin` |
| Veterinario | `vet@vet.com` | `vet` |
