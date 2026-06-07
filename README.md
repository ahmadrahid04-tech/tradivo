# Tradivo — Forum Jual Beli Online

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

**Tradivo** adalah platform marketplace / forum jual beli online mirip OLX dan Facebook Marketplace. Dibangun dengan Laravel 12, Blade Templates, dan desain premium responsif.

## ✨ Fitur Utama

### 👤 Autentikasi & Pengguna
- Registrasi, Login, Logout
- Profil pengguna (avatar, bio, telepon, lokasi)
- Role-based access: **Admin** dan **User**
- Sistem ban/unban pengguna

### 📦 Iklan / Listing
- CRUD lengkap (buat, lihat, edit, hapus)
- Multi-image upload (hingga 5 gambar)
- Kategori & sub-kategori
- Kondisi barang (Baru/Bekas)
- Status: Aktif, Terjual, Nonaktif

### 🔍 Pencarian & Filter
- Cari by keyword (judul, deskripsi)
- Filter: kategori, harga, kondisi, lokasi
- Sort: terbaru, termurah, termahal, populer
- Pagination

### 💬 Chat / Pesan
- Pesan langsung antar pembeli & penjual
- Notifikasi pesan belum dibaca
- Riwayat percakapan

### ❤️ Favorit / Wishlist
- Simpan iklan favorit (toggle AJAX)
- Halaman daftar favorit

### 🚩 Laporan
- Laporkan iklan tidak pantas
- Alasan: spam, terlarang, penipuan, duplikat

### ⚙️ Panel Admin
- Dashboard statistik
- Manajemen pengguna (ban/unban/hapus)
- Manajemen iklan (ubah status/hapus)
- CRUD kategori (parent-child)
- Review laporan pengguna

### 🎨 Desain
- UI premium & modern (glassmorphism, animasi)
- Responsif (mobile-first)
- Sistem notifikasi toast
- Empty states & loading indicators

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 12 (PHP 8.2+) |
| Template Engine | Blade |
| Database | SQLite (default) / MySQL 8 |
| ORM | Eloquent |
| CSS | Custom Design System (Vanilla CSS) |
| JavaScript | Vanilla JS |
| Font | Plus Jakarta Sans (Google Fonts) |

---

## 📋 Instalasi

### Persyaratan
- PHP 8.2+
- Composer
- Node.js 18+ (opsional, untuk asset bundling)

### Langkah Instalasi

```bash
# 1. Masuk ke folder proyek
cd tradivo

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Buat symbolic link untuk storage
php artisan storage:link

# 6. Jalankan migrasi & seeder
php artisan migrate:fresh --seed

# 7. Jalankan development server
php artisan serve
```

Buka browser: **http://localhost:8000**

### Konfigurasi MySQL (Opsional)

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tradivo
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🔑 Akun Demo

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@tradivo.com | admin123 |
| **User** | user@tradivo.com | user123 |

---

## 📁 Struktur Folder

```
tradivo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── ListingController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ListingController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ConversationController.php
│   │   │   ├── MessageController.php
│   │   │   ├── WishlistController.php
│   │   │   └── ReportController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── BannedMiddleware.php
│   │   └── Requests/ (6 form requests)
│   ├── Models/ (8 models)
│   └── Policies/ (2 policies)
├── database/
│   ├── migrations/ (11 migrations)
│   ├── factories/ (2 factories)
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── layouts/ (app, admin, guest)
│   ├── auth/ (login, register)
│   ├── listings/ (index, show, create, edit, my-listings)
│   ├── profile/ (show, edit)
│   ├── conversations/ (index, show)
│   ├── wishlists/index.blade.php
│   ├── admin/ (dashboard, users, listings, categories, reports)
│   ├── components/listing-card.blade.php
│   └── home.blade.php
├── public/
│   ├── css/app.css
│   └── js/app.js
├── routes/web.php
└── README.md
```

---

## 🛣️ Routes

### Public
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/` | Beranda |
| GET | `/listings` | Jelajahi iklan |
| GET | `/listings/{id}` | Detail iklan |
| GET | `/user/{id}` | Profil pengguna |

### Auth (Guest)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET/POST | `/login` | Masuk |
| GET/POST | `/register` | Daftar |
| POST | `/logout` | Keluar |

### User (Auth)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/listings/create/new` | Form iklan baru |
| POST | `/listings` | Simpan iklan |
| GET | `/listings/{id}/edit` | Form edit iklan |
| PUT | `/listings/{id}` | Update iklan |
| DELETE | `/listings/{id}` | Hapus iklan |
| GET | `/my-listings` | Iklan saya |
| GET/PUT | `/profile/edit` | Edit profil |
| PUT | `/profile/password` | Ubah password |
| GET | `/wishlists` | Daftar favorit |
| POST | `/listings/{id}/wishlist` | Toggle favorit |
| GET | `/conversations` | Daftar chat |
| GET | `/conversations/{id}` | Detail chat |
| POST | `/conversations` | Mulai chat |
| POST | `/messages` | Kirim pesan |
| POST | `/listings/{id}/report` | Laporkan iklan |

### Admin
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/admin/dashboard` | Dashboard |
| GET | `/admin/users` | Kelola pengguna |
| PATCH | `/admin/users/{id}/ban` | Ban/unban |
| DELETE | `/admin/users/{id}` | Hapus user |
| GET | `/admin/listings` | Kelola iklan |
| PATCH | `/admin/listings/{id}/status` | Ubah status |
| DELETE | `/admin/listings/{id}` | Hapus iklan |
| Resource | `/admin/categories` | CRUD kategori |
| GET | `/admin/reports` | Daftar laporan |
| GET | `/admin/reports/{id}` | Detail laporan |
| PATCH | `/admin/reports/{id}` | Update status |

---

## 🔒 Keamanan
- ✅ CSRF protection pada semua form
- ✅ Eloquent ORM (prepared statements)
- ✅ Blade auto-escape (XSS protection)
- ✅ Mass assignment protection ($fillable)
- ✅ Password hashing (bcrypt)
- ✅ File upload validation (MIME, size)
- ✅ Role-based middleware
- ✅ Policy-based authorization
- ✅ Banned user middleware

---

## 📝 Lisensi

Proyek ini dibuat untuk keperluan akademis / tugas sekolah.

---

*Made with ❤️ by Tradivo Team*
