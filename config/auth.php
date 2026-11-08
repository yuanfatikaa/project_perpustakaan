<?php
// Helper sesi, proteksi halaman, CSRF, dan flash message.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Array daftar kategori buku (dipakai di form tambah dan edit)
$DAFTAR_KATEGORI = ['Pemrograman', 'Basis Data', 'Jaringan', 'Sistem Informasi', 'Desain', 'Umum'];

function e($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function wajib_login()
{
    if (empty($_SESSION['user_id'])) {
        $_SESSION['flash'] = ['danger', 'Silakan login dulu untuk membuka halaman itu.'];
        header('Location: index.php');
        exit;
    }
}

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_input()
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_cek()
{
    $kirim = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $kirim)) {
        http_response_code(403);
        die('Token keamanan tidak valid. Kembali lalu muat ulang halaman.');
    }
}

function set_flash($tipe, $pesan)
{
    $_SESSION['flash'] = [$tipe, $pesan];
}

function tampil_flash()
{
    if (!empty($_SESSION['flash'])) {
        [$tipe, $pesan] = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($tipe) . ' alert-dismissible fade show" role="alert">'
            . e($pesan)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>';
    }
}

// Logika bisnis: label status ditentukan dari stok
function label_status($stok)
{
    if ($stok > 0) {
        return ['Tersedia', 'success'];
    }
    return ['Dipinjam', 'warning'];
}
