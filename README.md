# upsjb_farmacia_laragon

Sistema de Venta de Medicamentos - Farmacia San Juan Bautista (Laravel 13).

El proyecto Laravel está en la carpeta `sistema`.

## Módulos

- Login y cierre de sesión, con acceso por roles (Administrador, Químico farmacéutico y Cajero)
- CRUD de roles, usuarios, categorías, clientes, medicamentos y ventas
- Dashboard con indicadores y gráficos (Chart.js)
- Reporte de ventas con filtros, descarga en PDF (DomPDF) y en Excel (Maatwebsite/Excel)
- PWA (erag/laravel-pwa): se puede instalar como app y muestra una página cuando no hay conexión

## Cómo levantarlo en Laragon

En la terminal de Laragon, dentro de la carpeta `sistema`:

```
composer install
copy .env.example .env
php artisan key:generate
mysql -u root -e "CREATE DATABASE farmacia"
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Abrir http://127.0.0.1:8000

> Para el Excel, PHP necesita la extensión `zip` activada (Laragon → PHP → Extensions → zip).

## Usuarios de prueba

| Correo | Contraseña | Rol |
|---|---|---|
| admin@sanjuan.com | password | Administrador |
| rquispe@sanjuan.com | password | Químico farmacéutico |
| cmendoza@sanjuan.com | password | Cajero |
| ltorres@sanjuan.com | password | Cajero |
