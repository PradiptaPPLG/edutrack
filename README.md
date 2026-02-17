# EduTrack - Student Activity Management Platform

EduTrack is a starter project built with Laravel 11, designed to help students manage their learning activities and notes. It features a clean, MVC-structured codebase with a minimal and professional UI using Tailwind CSS.

## 🚀 Features

### Core Modules
- **Authentication**: Secure login and registration.
- Composer
- MySQL

## 🚀 Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username/edutrack.git
    cd edutrack
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan (.env)**
    Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan atur:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=edutrack
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi dan Seeding Database**
    Jalankan perintah ini untuk membuat tabel dan mengisi data awal (termasuk akun Siswa):
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Jalankan Server Lokal**
    ```bash
    npm run build
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`.

## 🔑 Akses Login Default

Setelah menjalankan seeding, Anda dapat masuk menggunakan akun berikut:

-   **Email**: `siswa@edutrack.com`
-   **Password**: `password`

## 🏗️ Struktur & Arsitektur

- **Models**: `App\Models\Note` (Business logic and relationships)
- **Controllers**:
  - `NoteController` (CRUD operations)
  - `AuthController` (Login/Register logic)
- **Views**:
  - `resources/views/layouts/app.blade.php` (Master layout)
  - `resources/views/notes/` (Note management views)
  - `resources/views/dashboard.blade.php` (Main dashboard)

## AI Integration

An AI Widget placeholder is located in `resources/views/dashboard.blade.php` (`<div id="ai-widget">`). This area is reserved for future AI features such as study recommendations or automatic note summarization.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
