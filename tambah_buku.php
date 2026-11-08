<?php
require 'config/auth.php';
wajib_login();

// Ambil input lama jika sebelumnya validasi gagal
$nilai = $_SESSION['old'] ?? ['judul' => '', 'kategori' => '', 'penulis' => '', 'tahun_terbit' => '', 'stok' => '1'];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);

$judul_halaman = 'Tambah Buku | Mini Digital Library';
$aksi = 'proses_tambah.php';
$teks_tombol = 'Simpan buku';
include 'includes/header.php';
?>
<a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kembali ke dashboard</a>
<h1 class="h3 my-3">Tambah buku</h1>
<?php if ($errors): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $er) echo '<li>' . e($er) . '</li>'; ?></ul></div>
<?php endif; ?>
<?php include 'includes/form_buku.php'; ?>
<?php include 'includes/footer.php'; ?>
