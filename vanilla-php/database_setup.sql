-- ==========================================
-- TokoKita Database Setup SQL
-- ==========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS toko_kita;
USE toko_kita;

-- ==========================================
-- USERS TABLE
-- ==========================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'customer',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- PRODUCTS TABLE
-- ==========================================
CREATE TABLE IF NOT EXISTS produks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    stok INT DEFAULT 0,
    deskripsi LONGTEXT NULL,
    gambar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- ORDERS TABLE
-- ==========================================
CREATE TABLE IF NOT EXISTS pesanans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    paket VARCHAR(100) NOT NULL,
    jumlah_sepatu INT NOT NULL,
    layanan_tambahan JSON NULL,
    total_biaya INT NOT NULL,
    status VARCHAR(100) DEFAULT 'Menunggu Pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- INSERT TEST DATA
-- ==========================================

-- Admin User
-- Email: admin@toko.test
-- Password: password123
INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@toko.test', '$2y$10$YJhKaKU8XKfn5.tSBzJHV.K2Mq1G2V6qZ1P0Q1R2S3T4U5V6W7X8', 'admin');

-- Sample Products
INSERT INTO produks (nama_produk, harga, stok, deskripsi) VALUES
('Sepatu Olahraga Pro', 50000, 20, 'Sepatu olahraga berkualitas tinggi dengan teknologi cushioning terbaru. Cocok untuk berbagai aktivitas olahraga.'),
('Sepatu Casual Komfort', 30000, 15, 'Sepatu casual yang nyaman untuk penggunaan sehari-hari. Material berkualitas dan desain modern.'),
('Sepatu Formal Kulit', 100000, 10, 'Sepatu formal dengan bahan kulit asli untuk acara penting Anda. Desain elegan dan profesional.'),
('Sneaker Trendy', 45000, 25, 'Sneaker dengan desain terkini dan warna-warna menarik. Perfect untuk gaya kasual modern.'),
('Sandal Pantai', 25000, 30, 'Sandal nyaman untuk pantai dan musim panas. Tahan air dan mudah dibersihkan.');

-- ==========================================
-- CREATE INDEXES
-- ==========================================
CREATE INDEX idx_email ON users(email);
CREATE INDEX idx_nama_produk ON produks(nama_produk);

-- ==========================================
-- END OF SETUP
-- ==========================================
