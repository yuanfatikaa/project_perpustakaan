-- Database Mini Digital Library
CREATE DATABASE IF NOT EXISTS db_perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_perpustakaan;

DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE buku (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    sampul VARCHAR(100) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun awal: username admin, kata sandi admin123 (disimpan dalam bentuk hash bcrypt)
INSERT INTO users (username, nama, password) VALUES
('admin', 'Admin Perpustakaan', '$2y$12$qYJDg2mJH25WiWHabTZHKO5GRQZCQJHjfPtcpuRy6QQjGbYLLYJMu');

INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES
('Pemrograman Web dengan PHP dan MySQL', 'Pemrograman', 'Contoh Penulis', 2021, 3, NULL),
('Perancangan Basis Data Relasional', 'Basis Data', 'Contoh Penulis', 2019, 0, NULL);
