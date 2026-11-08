<?php
require 'config/koneksi.php';
require 'config/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
csrf_cek();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    set_flash('danger', 'Username dan kata sandi wajib diisi.');
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, username, nama, password FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && $password === $user['password']) {
    session_regenerate_id(true); // cegah session fixation

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama'];

    // Cookie Remember Me hanya menyimpan username, tidak pernah password
    if (!empty($_POST['remember'])) {
        setcookie('remember_username', $user['username'], [
            'expires'  => time() + 60 * 60 * 24 * 7, // 7 hari
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        setcookie('remember_username', '', ['expires' => time() - 3600, 'path' => '/']);
    }

    header('Location: dashboard.php');
    exit;
}

set_flash('danger', 'Username atau kata sandi salah.');
header('Location: index.php');
exit;
