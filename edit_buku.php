<?php
require 'config/koneksi.php';
require 'config/auth.php';
wajib_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    set_flash('danger', 'ID buku tidak valid.');
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM buku WHERE id = ?');
$stmt->execute([$id]);
$buku = $stmt->fetch();
if (!$buku) {
    set_flash('danger', 'Buku tidak ditemukan.');
    header('Location: dashboard.php');
    exit;
}

$nilai = $_SESSION['old'] ?? $buku;
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);

$judul_halaman = 'Edit Buku | Mini Digital Library';
$aksi = 'proses_edit.php';
$teks_tombol = 'Simpan perubahan';
$sampul_lama = $buku['sampul'];
include 'includes/header.php';
?>
<a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kembali ke dashboard</a>
<h1 class="h3 my-3">Edit buku</h1>
<?php if ($errors): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $er) echo '<li>' . e($er) . '</li>'; ?></ul></div>
<?php endif; ?>
<?php include 'includes/form_buku.php'; ?>
<?php include 'includes/footer.php'; ?>
