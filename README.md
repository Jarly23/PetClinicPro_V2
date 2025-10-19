# PetClinicPro V2 - Sistema de Gestión Veterinaria

![PetClinicPro V2](https://img.shields.io/badge/Laravel-10.x-red.svg)
![Livewire](https://img.shields.io/badge/Livewire-3.x-orange.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-blue.svg)

## 📋 Descripción del Proyecto

PetClinicPro V2 es un sistema completo de gestión para clínicas veterinarias desarrollado en Laravel 10 con Livewire y Tailwind CSS. El sistema permite gestionar clientes, mascotas, consultas, reservas, inventario, ventas y reportes de manera eficiente e intuitiva.

### 🚀 Características Principales

- **Gestión de Clientes**: Registro y administración completa de clientes con validación de DNI/RUC
- **Gestión de Mascotas**: Historial médico completo, vacunas y tratamientos
- **Consultas Veterinarias**: Sistema completo de consultas con historial médico
- **Sistema de Reservas**: Calendario de citas y gestión de horarios
- **Inventario**: Control de productos, proveedores y stock
- **Ventas**: Sistema de facturación y notas de venta
- **Reportes**: Dashboard con estadísticas y reportes personalizados
- **Control de Vacunas**: Seguimiento de vacunas y recordatorios
- **Sistema de Permisos**: Control granular de acceso por roles
- **Notificaciones**: Sistema de alertas y recordatorios

### 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 10.x
- **Frontend**: Livewire 3.x, Tailwind CSS 3.x
- **Autenticación**: Laravel Jetstream con Fortify
- **Base de Datos**: MySQL
- **Permisos**: Spatie Laravel Permission
- **Reportes**: DomPDF, PhpSpreadsheet
- **Charts**: Chart.js

## 🎨 Plantilla Base

Este proyecto utiliza como base la plantilla **Mosaic Lite Laravel** de [Cruip.com](https://cruip.com/), una plantilla de dashboard administrativo moderna y responsive construida con Tailwind CSS y Laravel Jetstream.

- **Plantilla Original**: [Mosaic Lite Laravel](https://cruip.com/mosaic/)
- **Demo en Vivo**: [https://mosaic.cruip.com/](https://mosaic.cruip.com/?template=laravel)
- **Documentación**: [https://github.com/cruip/laravel-tailwindcss-admin-dashboard-template](https://github.com/cruip/laravel-tailwindcss-admin-dashboard-template)

## 📋 Requisitos del Sistema

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 16.0
- NPM >= 8.0
- MySQL >= 8.0
- Servidor web (Apache/Nginx)

## 🚀 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/PetClinicPro_V2.git
cd PetClinicPro_V2
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Instalar Dependencias de Node.js

```bash
npm install
```

### 4. Configurar Variables de Entorno

```bash
cp .env.example .env
```

Editar el archivo `.env` con tu configuración:

```env
APP_NAME="PetClinicPro V2"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petclinicpro_v2
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar Migraciones

```bash
php artisan migrate
```

### 7. Ejecutar Seeders (Datos de Prueba)

```bash
php artisan db:seed
```

### 8. Compilar Assets

```bash
npm run dev
```

Para producción:

```bash
npm run build
```

### 9. Configurar Almacenamiento

```bash
php artisan storage:link
```

### 10. Iniciar el Servidor

```bash
php artisan serve
```

El proyecto estará disponible en: `http://localhost:8000`

## 👤 Credenciales por Defecto

Después de ejecutar los seeders, puedes acceder con:

- **Email**: admin@petclinicpro.com
- **Contraseña**: password

## 📁 Estructura del Proyecto

```
PetClinicPro_V2/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores principales
│   │   ├── Livewire/        # Componentes Livewire
│   │   └── Middleware/      # Middlewares personalizados
│   ├── Models/              # Modelos Eloquent
│   ├── Notifications/       # Notificaciones del sistema
│   └── Providers/           # Proveedores de servicios
├── database/
│   ├── migrations/          # Migraciones de base de datos
│   ├── seeders/             # Seeders con datos de prueba
│   └── factories/           # Factories para testing
├── resources/
│   ├── views/               # Vistas Blade
│   ├── css/                 # Estilos CSS
│   └── js/                  # JavaScript
├── routes/                  # Definición de rutas
└── tests/                   # Tests automatizados
```

## 🔧 Configuración Adicional

### Configurar Permisos de Archivos (Linux/Mac)

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Configurar Queue (Opcional)

```bash
# Configurar supervisor para procesar colas
php artisan queue:work
```

### Configurar Cron Jobs (Opcional)

```bash
# Agregar al crontab para tareas programadas
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 🧪 Testing

### Ejecutar Tests

```bash
php artisan test
```

### Ejecutar Tests con Coverage

```bash
php artisan test --coverage
```

## 📊 Funcionalidades del Sistema

### Módulos Principales

1. **Dashboard**
   - Estadísticas en tiempo real
   - Gráficos de consultas mensuales
   - Resumen de mascotas y clientes
   - Notificaciones de vacunas próximas

2. **Gestión de Clientes**
   - Registro con validación de DNI/RUC
   - Búsqueda avanzada
   - Historial de mascotas por cliente
   - Información de contacto

3. **Gestión de Mascotas**
   - Registro con tipo de animal
   - Historial médico completo
   - Control de vacunas
   - Seguimiento de tratamientos

4. **Consultas Veterinarias**
   - Creación de consultas
   - Historial médico detallado
   - Diagnósticos y tratamientos
   - Generación de reportes PDF

5. **Sistema de Reservas**
   - Calendario de citas
   - Gestión de horarios
   - Confirmaciones automáticas
   - Recordatorios por email

6. **Inventario**
   - Control de productos
   - Gestión de proveedores
   - Alertas de stock mínimo
   - Entradas y salidas

7. **Ventas**
   - Facturación electrónica
   - Notas de venta
   - Control de pagos
   - Reportes de ventas

8. **Administración**
   - Gestión de usuarios
   - Sistema de roles y permisos
   - Configuración del sistema
   - Backup de datos

## 🔒 Seguridad

- Autenticación con Laravel Jetstream
- Sistema de permisos granular con Spatie Laravel Permission
- Validación de datos en todos los formularios
- Protección CSRF en todas las rutas
- Rate limiting para prevenir ataques
- Sanitización de datos de entrada

## 🚀 Despliegue en Producción

### Configuración del Servidor

1. **Configurar el servidor web** (Apache/Nginx)
2. **Configurar SSL** con certificado válido
3. **Optimizar PHP** para producción
4. **Configurar base de datos** con índices optimizados
5. **Configurar colas** para tareas en segundo plano

### Variables de Entorno de Producción

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=tu-host
DB_PORT=3306
DB_DATABASE=petclinicpro_prod
DB_USERNAME=usuario_prod
DB_PASSWORD=password_seguro

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

### Comandos de Despliegue

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

- **Email**: soporte@petclinicpro.com
- **Documentación**: [Wiki del Proyecto](https://github.com/tu-usuario/PetClinicPro_V2/wiki)
- **Issues**: [GitHub Issues](https://github.com/tu-usuario/PetClinicPro_V2/issues)

## 🙏 Agradecimientos

- **Cruip.com** por la plantilla Mosaic Lite Laravel
- **Laravel Team** por el framework
- **Livewire Team** por los componentes reactivos
- **Tailwind CSS** por el framework de estilos

---

**Desarrollado con ❤️ para la comunidad veterinaria**
