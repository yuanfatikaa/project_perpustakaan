<?php
require 'config/auth.php';

// Logout hanya lewat POST + token CSRF agar tidak bisa dipicu dari link luar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_cek();

    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    // Hapus cookie Remember Me juga
    setcookie('remember_username', '', ['expires' => time() - 3600, 'path' => '/']);
    session_destroy();

    // Mulai sesi baru hanya untuk membawa pesan flash
    session_start();
    set_flash('success', 'Kamu sudah keluar dengan aman.');
}
header('Location: index.php');
exit;
