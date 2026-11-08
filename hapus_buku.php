<?php
require 'config/koneksi.php';
require 'config/auth.php';
require 'helpers/upload.php';
wajib_login();

// Hapus hanya lewat POST + CSRF agar tidak bisa dipicu dari link biasa
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}
csrf_cek();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT judul, sampul FROM buku WHERE id = ?');
$stmt->execute([$id]);
$buku = $stmt->fetch();

if ($buku) {
    $hapus = $pdo->prepare('DELETE FROM buku WHERE id = ?');
    $hapus->execute([$id]);
    hapus_sampul($buku['sampul']); // unlink file gambar
    set_flash('success', 'Buku "' . $buku['judul'] . '" dan file sampulnya berhasil dihapus.');
} else {
    set_flash('danger', 'Buku tidak ditemukan.');
}
header('Location: dashboard.php');
exit;
