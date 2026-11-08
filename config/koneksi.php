<?php
// Koneksi database memakai PDO. Ubah nilai di bawah sesuai server lokal kamu.
$db_host = 'localhost';
$db_nama = 'db_perpustakaan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_nama;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Pesan detail sengaja tidak ditampilkan agar info server tidak bocor
    die('Koneksi database gagal. Cek file config/koneksi.php');
}
