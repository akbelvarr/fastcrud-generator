# FastCRUD

FastCRUD adalah tools generator CRUD berbasis web yang dikembangkan menggunakan Laravel. Sistem ini dirancang untuk membantu proses pengembangan aplikasi dengan menghasilkan module CRUD Laravel secara otomatis berdasarkan input pengguna.

## ✨ Fitur Utama

- Generate CRUD Laravel otomatis
- Generate Model, Controller, Migration, dan View
- Dukungan berbagai tipe data field
- Fitur timestamps dan soft deletes
- Export hasil generate dalam bentuk ZIP
- Validasi penamaan model dan field

## 🛠️ Teknologi

- Laravel 12
- PHP 8.2
- Blade Template
- Bootstrap
- JavaScript

## 🚀 Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/akbelvarr/fastcrud-generator.git
```

### 2. Masuk Folder Project

```bash
cd fastcrud-generator
```

### 3. Install Dependency

```bash
composer install
npm install
```

### 4. Copy Environment

```bash
cp .env.example .env
```

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Jalankan Server

```bash
php artisan serve
```

## 📦 Hasil Generate

FastCRUD akan menghasilkan:
- Model
- Controller
- Migration
- Views Blade
- Route
- File ZIP

## 📄 License

Project ini dikembangkan untuk kebutuhan penelitian dan pembelajaran.
