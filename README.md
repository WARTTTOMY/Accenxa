<div align="center" id="top"> 
  <img src="public/admin/img/android-chrome-192x192.png" alt="Control de Asistencias QR" width="200" />

  &#xa0;

  <h1>📱 Sistema de Control de Asistencias con QR</h1>
  
  <p>
    <em>Gestión eficiente de asistencia estudiantil mediante códigos QR dinámicos</em>
  </p>

  <!-- <a href="https://control-asistencias-demo.com">🌐 Ver Demo</a> -->
</div>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/badge/Laravel-9.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  </a>
  <a href="https://www.php.net">
    <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License">
  </a>
  <img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge" alt="Status">
</p>

<p align="center">
  <a href="#-sobre-el-proyecto">Sobre el Proyecto</a> • 
  <a href="#-características">Características</a> • 
  <a href="#-tecnologías">Tecnologías</a> • 
  <a href="#-requisitos">Requisitos</a> • 
  <a href="#-instalación">Instalación</a> • 
  <a href="#-uso">Uso</a> • 
  <a href="#-capturas">Capturas</a> • 
  <a href="#-licencia">Licencia</a> • 
  <a href="#-autor">Autor</a>
</p>

<br>

---

## 📖 Sobre el Proyecto

**Sistema de Control de Asistencias con QR** es una aplicación web desarrollada en Laravel que permite gestionar la asistencia de estudiantes de manera automatizada mediante códigos QR únicos. Cada estudiante recibe su propio código QR que puede ser escaneado con la cámara web para registrar su asistencia de forma rápida y segura.

### 🎯 Objetivo

Modernizar y agilizar el proceso de control de asistencia educativa, eliminando los métodos tradicionales manuales que consumen tiempo y son propensos a errores.

### 💡 Problema que Resuelve

- ✅ **Elimina** el pase de lista manual
- ✅ **Reduce** el tiempo de registro de asistencia
- ✅ **Previene** la suplantación de identidad
- ✅ **Centraliza** los registros históricos
- ✅ **Facilita** la generación de reportes

<br>

---

## ✨ Características

<table>
  <tr>
    <td>
      <h3>🆔 Gestión de Alumnos</h3>
      <ul>
        <li>Registro completo de estudiantes</li>
        <li>Generación automática de códigos QR (SVG)</li>
        <li>Edición y eliminación de registros</li>
        <li>Búsqueda y filtrado avanzado</li>
        <li>Exportación de datos</li>
      </ul>
    </td>
    <td>
      <h3>📸 Registro de Asistencias</h3>
      <ul>
        <li>Escaneo mediante cámara web</li>
        <li>Detección automática de QR</li>
        <li>Registro instantáneo</li>
        <li>Validación anti-duplicados</li>
        <li>Historial completo por alumno</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td>
      <h3>📊 Panel de Visualización</h3>
      <ul>
        <li>Dashboard con estadísticas</li>
        <li>Listado de asistencias por fecha</li>
        <li>Filtros personalizables</li>
        <li>Reportes detallados</li>
        <li>Gráficos interactivos</li>
      </ul>
    </td>
    <td>
      <h3>🔐 Seguridad</h3>
      <ul>
        <li>Autenticación de usuarios</li>
        <li>Códigos QR únicos e irrepetibles</li>
        <li>Validación de permisos</li>
        <li>Protección CSRF</li>
        <li>Encriptación de datos sensibles</li>
      </ul>
    </td>
  </tr>
</table>

<br>

---

## 🛠️ Tecnologías

Este proyecto fue construido con las siguientes tecnologías:

### Backend
[![Laravel][Laravel.com]][Laravel-url]
[![PHP][PHP.com]][PHP-url]
[![MySQL][MySQL.com]][MySQL-url]
[![Composer][Composer.com]][Composer-url]

### Frontend
[![Bootstrap][Bootstrap.com]][Bootstrap-url]
[![jQuery][jQuery.com]][jQuery-url]
[![JavaScript][JavaScript.com]][JavaScript-url]
[![DataTables][DataTables.com]][DataTables-url]

### Librerías Principales
- **SimpleSoftwareIO/simple-qrcode** `^4.2` - Generación de códigos QR
- **Instascan.js** - Escaneo de códigos QR con webcam
- **SweetAlert2** - Alertas elegantes
- **FontAwesome** - Iconografía
- **Select2** - Selects mejorados

<br>

---

## 📋 Requisitos

Antes de comenzar, asegúrate de tener instalado:

### Software Necesario

| Herramienta | Versión Mínima | Descarga |
|-------------|----------------|----------|
| **PHP** | 8.1.0 | [Descargar](https://www.php.net/downloads) |
| **Composer** | 2.x | [Descargar](https://getcomposer.org/download/) |
| **MySQL** | 5.7+ / 8.0+ | [Descargar](https://dev.mysql.com/downloads/mysql/) |
| **Git** | 2.x | [Descargar](https://git-scm.com/downloads) |
| **Apache/Nginx** | Cualquiera | [XAMPP](https://www.apachefriends.org/) o [Laragon](https://laragon.org/) |

### Extensiones de PHP Requeridas

```bash
php -m
```

Verifica que estén habilitadas:
- ✅ `gd` (para generación de imágenes)
- ✅ `pdo_mysql` (conexión a MySQL)
- ✅ `mbstring`
- ✅ `openssl`
- ✅ `tokenizer`
- ✅ `xml`
- ✅ `ctype`
- ✅ `json`

<br>

---

## 🚀 Instalación

Sigue estos pasos para instalar el proyecto en tu máquina local:

### 1️⃣ Clonar el Repositorio

```bash
# Clonar el proyecto
git clone https://github.com/TU_USUARIO/control-asistencias-qr.git

# Acceder a la carpeta
cd control-asistencias-qr
```

### 2️⃣ Instalar Dependencias

```bash
# Instalar dependencias de PHP
composer install

# (Opcional) Si usas Node.js para assets
npm install
npm run dev
```

### 3️⃣ Configurar Variables de Entorno

```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Generar la clave de la aplicación
php artisan key:generate

# Crear enlace simbólico para storage
php artisan storage:link
```

### 4️⃣ Editar el Archivo `.env`

Abre el archivo `.env` y configura tu base de datos:

```env
APP_NAME="Control de Asistencias QR"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=control_asistencias
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Crear la Base de Datos

```sql
-- En MySQL o phpMyAdmin, ejecuta:
CREATE DATABASE control_asistencias CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6️⃣ Ejecutar Migraciones

```bash
# Crear las tablas de la base de datos
php artisan migrate

# (Opcional) Ejecutar seeders para datos de prueba
php artisan migrate --seed
```

### 7️⃣ Iniciar el Servidor

```bash
# Iniciar el servidor de desarrollo
php artisan serve
```

🎉 **¡Listo!** Abre tu navegador en: [http://localhost:8000](http://localhost:8000)

### 8️⃣ Credenciales de Acceso (si usaste seeders)

```
📧 Email: admin@admin.com
🔒 Password: control1234
```

<br>

---

## 📱 Uso

### Gestión de Alumnos

1. **Accede al panel de administración**
2. Navega a la sección **"Alumnos"**
3. Haz clic en **"Registrar Alumno"**
4. Completa el formulario:
   - **Código:** Identificador único del estudiante
   - **Nombres:** Nombre(s) del estudiante
   - **Apellidos:** Apellido(s) del estudiante
5. Haz clic en **"Guardar"**
6. El código QR se genera automáticamente
7. Para visualizar el QR, haz clic en el ícono del **ojo (👁️)**
8. Puedes **imprimir** o **descargar** el código QR

### Registro de Asistencias

1. Navega a la sección **"Asistencias"**
2. Haz clic en **"Activar Cámara"**
3. Permite el acceso a la cámara web
4. Enfoca el código QR del estudiante
5. El sistema **detectará automáticamente** el QR
6. La asistencia se registra **instantáneamente**
7. Verás una confirmación en pantalla

### Visualización de Reportes

1. Ve a **"Historial de Asistencias"**
2. Filtra por:
   - 📅 Fecha
   - 👤 Alumno específico
   - 📊 Rango de fechas
3. Exporta los datos en formato **Excel** o **PDF**

<br>

---

## 📸 Capturas de Pantalla

<div align="center">

### 🏠 Dashboard Principal
<img src="docs/screenshots/dashboard.png" alt="Dashboard" width="800" />

### 👥 Gestión de Alumnos
<img src="docs/screenshots/alumnos.png" alt="Alumnos" width="800" />

### 📱 Código QR del Estudiante
<img src="docs/screenshots/qr-code.png" alt="QR Code" width="400" />

### ✅ Registro de Asistencias
<img src="docs/screenshots/asistencias.png" alt="Asistencias" width="800" />

</div>

<br>

---

## 🗂️ Estructura del Proyecto

```
control_asistencias/
├── 📁 app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AlumnoController.php       # Gestión de alumnos
│   │       ├── AsistenciaController.php   # Registro de asistencias
│   │       └── HomeController.php         # Dashboard
│   └── Models/
│       ├── Alumno.php                     # Modelo de alumno
│       ├── Asistencia.php                 # Modelo de asistencia
│       └── User.php                       # Modelo de usuario
├── 📁 database/
│   └── migrations/
│       ├── create_alumnos_table.php
│       └── create_asistencias_table.php
├── 📁 public/
│   └── admin/
│       ├── css/                           # Estilos personalizados
│       ├── js/                            # Scripts JavaScript
│       └── plugins/                       # Librerías (DataTables, Select2, etc.)
├── 📁 resources/
│   └── views/
│       ├── alumnos/
│       │   └── index.blade.php            # Vista de alumnos
│       ├── asistencias/
│       │   └── index.blade.php            # Vista de asistencias
│       └── layouts/
│           └── app.blade.php              # Layout principal
├── 📁 routes/
│   └── web.php                            # Rutas de la aplicación
├── .env.example                           # Variables de entorno de ejemplo
├── composer.json                          # Dependencias de PHP
├── artisan                                # CLI de Laravel
└── README.md                              # Este archivo
```

<br>

---

## 🔧 Configuración Avanzada

### Cambiar el Formato del Código QR

Por defecto, el sistema usa **SVG** (recomendado). Para cambiar a PNG:

Edita `app/Models/Alumno.php`:

```php
public function getQrAttribute(){
    return base64_encode(
        QrCode::format('png')  // Cambiar de 'svg' a 'png'
            ->size(200)
            ->generate($this->codigo)
    );
}
```

### Personalizar el Tamaño del QR

```php
->size(300)  // Cambiar a 300x300 píxeles
```

### Configurar Niveles de Corrección de Errores

```php
QrCode::format('svg')
    ->size(200)
    ->errorCorrection('H')  // L, M, Q, H (bajo a alto)
    ->generate($this->codigo);
```

<br>

---

## 🧪 Testing

```bash
# Ejecutar todas las pruebas
php artisan test

# Ejecutar pruebas específicas
php artisan test --filter AlumnoTest
```

<br>

---


### Convenciones de Commits

- `Add:` Nueva funcionalidad
- `Fix:` Corrección de bugs
- `Update:` Actualización de código existente
- `Remove:` Eliminación de código
- `Docs:` Cambios en documentación

<br>

---

## 🐛 Reporte de Bugs

Si encuentras algún error, por favor:

1. Verifica que no exista un [issue](https://github.com/TU_USUARIO/control-asistencias-qr/issues) similar
2. Abre un nuevo issue con:
   - 📝 Descripción detallada del problema
   - 🔢 Pasos para reproducir el error
   - 💻 Entorno (OS, PHP version, etc.)
   - 📸 Capturas de pantalla (si aplica)

<br>

---

## 📚 Recursos Adicionales

- 📖 [Documentación de Laravel](https://laravel.com/docs)
- 📱 [Simple QR Code Docs](https://www.simplesoftware.io/docs/simple-qrcode)
- 🎨 [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.0/)
- 📊 [DataTables Documentation](https://datatables.net/)


---

## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/u/TU_USUARIO?v=4" width="100" style="border-radius: 50%;" alt="Foto de perfil"/>
  <br>
  <strong>Tomas Arias Martinez</strong>
  <br>
  <em>Estudiante ingenieria en software</em>
  <br><br>
  
  [![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/TU_USUARIO)
  [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/TU_PERFIL)
  [![Email](https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:tuemail@ejemplo.com)
</div>

<br>

---

## 🙏 Agradecimientos

- Laravel Framework por su excelente documentación
- SimpleSoftwareIO por la librería de QR codes
- La comunidad de código abierto

<br>

---

## 📊 Estadísticas del Proyecto

<div align="center">

![GitHub repo size](https://img.shields.io/github/repo-size/TU_USUARIO/control-asistencias-qr?style=for-the-badge)
![GitHub stars](https://img.shields.io/github/stars/TU_USUARIO/control-asistencias-qr?style=for-the-badge)
![GitHub forks](https://img.shields.io/github/forks/TU_USUARIO/control-asistencias-qr?style=for-the-badge)
![GitHub issues](https://img.shields.io/github/issues/TU_USUARIO/control-asistencias-qr?style=for-the-badge)

</div>

<br>

---

<div align="center">
  
### ⭐ Si este proyecto te fue útil, considera darle una estrella en GitHub

<br>

**Hecho con ❤️ para la comunidad educativa**

<a href="#top">⬆️ Volver arriba</a>

</div>

<!-- BADGES -->
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[PHP.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[PHP-url]: https://www.php.net
[MySQL.com]: https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com
[Composer.com]: https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white
[Composer-url]: https://getcomposer.org
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[jQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[jQuery-url]: https://jquery.com
[JavaScript.com]: https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black
[JavaScript-url]: https://developer.mozilla.org/en-US/docs/Web/JavaScript
[DataTables.com]: https://img.shields.io/badge/DataTables-1F425F?style=for-the-badge&logo=data&logoColor=white
[DataTables-url]: https://datatables.net