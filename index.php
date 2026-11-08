<?php
require 'config/auth.php';
// Jika sudah login, langsung ke dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
// Isi otomatis username dari cookie Remember Me
$username_cookie = $_COOKIE['remember_username'] ?? '';
$judul_halaman = 'Masuk | Mini Digital Library';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul_halaman) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<div class="login-wrap">
    <section class="login-kiri">
        <i class="bi bi-book-half fs-1 mb-3"></i>
        <h1>Kelola koleksi buku dalam satu tempat.</h1>
        <p class="text-white-50 mt-3 mb-0">Mini Digital Library untuk tugas Pemrograman Web, Sistem Informasi.</p>
    </section>
    <section class="login-kanan">
        <form action="proses_login.php" method="post" novalidate>
            <h2 class="judul-login mb-1">Masuk</h2>
            <p class="text-secondary mb-4">Gunakan akun admin perpustakaan.</p>
            <?php tampil_flash(); ?>
            <?= csrf_input() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= e($username_cookie) ?>" required autofocus autocomplete="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1" <?= $username_cookie ? 'checked' : '' ?>>
                <label class="form-check-label" for="remember">Ingat username saya</label>
            </div>
            <button class="btn btn-utama w-100 py-2" type="submit">Masuk</button>
        </form>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
