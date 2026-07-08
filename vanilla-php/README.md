# TokoKita - Vanilla PHP Edition

Versi PHP vanilla dari aplikasi TokoKita yang kompatibel dengan hosting gratis.

## 📋 Fitur

- ✅ Authentication (Login/Logout)
- ✅ Product Management (CRUD untuk admin)
- ✅ Product Listing & Search
- ✅ Order Management
- ✅ Admin Dashboard
- ✅ Image Upload
- ✅ Responsive Design
- ✅ Compatible dengan Free Hosting

## 🖥️ Requirement

- PHP 7.4 atau lebih tinggi
- MySQL / MariaDB
- Web Server (Apache dengan mod_rewrite)

## 📦 Database Setup

### 1. Buat Database

```sql
CREATE DATABASE toko_kita;
USE toko_kita;
```

### 2. Import Tabel

```sql
-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'customer',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE produks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    stok INT DEFAULT 0,
    deskripsi LONGTEXT NULL,
    gambar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE pesanans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    paket VARCHAR(100) NOT NULL,
    jumlah_sepatu INT NOT NULL,
    layanan_tambahan JSON NULL,
    total_biaya INT NOT NULL,
    status VARCHAR(100) DEFAULT 'Menunggu Pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 3. Insert Data Test

```sql
-- Admin User
INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@toko.test', '$2y$10$YJhKaKU8XKfn5.tSBzJHV.K2Mq1G2V6qZ1P0Q1R2S3T4U5V6W7X8', 'admin');

-- Password untuk admin: password123

-- Sample Product
INSERT INTO produks (nama_produk, harga, stok, deskripsi) VALUES
('Sepatu Olahraga Pro', 50000, 20, 'Sepatu olahraga berkualitas tinggi'),
('Sepatu Casual', 30000, 15, 'Sepatu casual untuk penggunaan sehari-hari'),
('Sepatu Formal', 100000, 10, 'Sepatu formal untuk acara penting');
```

## 🚀 Installation

### 1. Upload Files

Upload semua file dari folder `vanilla-php/` ke hosting Anda di folder `public_html/` atau `www/`.

Struktur folder:
```
public_html/
├── vanilla-php/
│   ├── config.php
│   ├── Database.php
│   ├── functions.php
│   ├── index.php
│   ├── .htaccess
│   ├── pages/
│   ├── actions/
│   └── uploads/
```

### 2. Konfigurasi Database

Edit file `config.php` dengan detail database Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'toko_kita');
```

### 3. Buat Folder Upload

Buat folder `uploads/` di dalam folder `vanilla-php/`:

```bash
mkdir vanilla-php/uploads
mkdir vanilla-php/uploads/products
chmod 755 vanilla-php/uploads
chmod 755 vanilla-php/uploads/products
```

### 4. Setup .htaccess

Pastikan file `.htaccess` ada dan mod_rewrite teraktif di server.

## 🔑 Login

Gunakan akun test:
- **Email**: admin@toko.test
- **Password**: password123

## 📝 Struktur Folder

```
vanilla-php/
├── config.php                 # Konfigurasi aplikasi
├── Database.php              # Class database
├── functions.php             # Helper functions
├── index.php                 # Router utama
├── .htaccess                 # Clean URLs
├── pages/                    # Halaman-halaman
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   ├── home.php
│   ├── produk/
│   ├── auth/
│   ├── pesanan/
│   ├── admin/
│   │   ├── produk/
│   │   └── pesanan/
│   └── 404.php
├── actions/                  # Logic untuk form handling
│   ├── login.php
│   ├── pesanan_create.php
│   ├── produk_create.php
│   ├── produk_update.php
│   ├── produk_delete.php
│   └── pesanan_update_status.php
└── uploads/                  # Folder untuk upload gambar
    └── products/
```

## 🌐 URL Routes

### Public Routes
- `/vanilla-php/` - Beranda
- `/vanilla-php/produk` - Daftar Produk
- `/vanilla-php/produk/{id}` - Detail Produk
- `/vanilla-php/login` - Login

### Customer Routes (perlu login)
- `/vanilla-php/pesanan` - Daftar Pesanan
- `/vanilla-php/pesanan/create` - Buat Pesanan
- `/vanilla-php/pesanan/detail?id={id}` - Detail Pesanan

### Admin Routes (perlu login + role admin)
- `/vanilla-php/admin/produk` - Manajemen Produk
- `/vanilla-php/admin/produk/create` - Tambah Produk
- `/vanilla-php/admin/produk/{id}/edit` - Edit Produk
- `/vanilla-php/admin/pesanan` - Manajemen Pesanan
- `/vanilla-php/admin/pesanan/{id}` - Detail & Update Pesanan

## 🔐 Keamanan

- CSRF Protection di semua form
- Password hashing dengan bcrypt
- SQL injection protection dengan prepared statements
- HTML sanitization dengan htmlspecialchars
- Session management yang aman

## 🎨 Customization

### Ubah Nama Aplikasi

Edit file `config.php`:
```php
define('APP_NAME', 'Nama Toko Anda');
define('APP_URL', 'https://domain-anda.com');
```

### Ubah Paket Layanan

Edit di file `pages/pesanan/create.php` bagian `$packages` array.

### Ubah Warna

Edit CSS di file `pages/layouts/header.php` di bagian `<style>`.

## 🐛 Troubleshooting

### 404 Not Found
- Pastikan `.htaccess` ada dan mod_rewrite teraktif
- Hubungi hosting untuk enable mod_rewrite

### Database Connection Error
- Verifikasi kredensial di `config.php`
- Pastikan database sudah dibuat

### Upload File Gagal
- Pastikan folder `uploads/` ada dan writable (chmod 755)
- Pastikan ukuran file < 5MB

### Session Not Working
- Clear browser cookies
- Verifikasi folder `storage/` writable

## 📞 Support

Untuk pertanyaan atau masalah, silakan hubungi tim developer Anda.

## 📄 License

MIT License - Bebas untuk digunakan dan dimodifikasi.

---

**Happy Coding! 🎉**
