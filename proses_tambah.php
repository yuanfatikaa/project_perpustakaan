<?php
require 'config/koneksi.php';
require 'config/auth.php';
require 'helpers/upload.php';
require 'helpers/validasi.php';
wajib_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah_buku.php');
    exit;
}
csrf_cek();

[$errors, $data] = validasi_buku($_POST, $DAFTAR_KATEGORI);
$sampul = simpan_sampul($_FILES['sampul'] ?? ['error' => UPLOAD_ERR_NO_FILE], $errors);

if ($errors) {
    hapus_sampul($sampul); // bersihkan file yang terlanjur tersimpan
    $_SESSION['old'] = $data;
    $_SESSION['errors'] = $errors;
    header('Location: tambah_buku.php');
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$data['judul'], $data['kategori'], $data['penulis'], $data['tahun_terbit'], $data['stok'], $sampul]);
    set_flash('success', 'Buku "' . $data['judul'] . '" berhasil ditambahkan.');
} catch (PDOException $ex) {
    hapus_sampul($sampul);
    set_flash('danger', 'Data gagal disimpan. Coba lagi.');
}
header('Location: dashboard.php');
exit;
