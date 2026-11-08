<?php
require 'config/koneksi.php';
require 'config/auth.php';
require 'helpers/upload.php';
require 'helpers/validasi.php';
wajib_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}
csrf_cek();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT * FROM buku WHERE id = ?');
$stmt->execute([$id]);
$buku = $stmt->fetch();
if (!$buku) {
    set_flash('danger', 'Buku tidak ditemukan.');
    header('Location: dashboard.php');
    exit;
}

[$errors, $data] = validasi_buku($_POST, $DAFTAR_KATEGORI);
$sampul_baru = simpan_sampul($_FILES['sampul'] ?? ['error' => UPLOAD_ERR_NO_FILE], $errors);

if ($errors) {
    hapus_sampul($sampul_baru);
    $_SESSION['old'] = $data;
    $_SESSION['errors'] = $errors;
    header('Location: edit_buku.php?id=' . $id);
    exit;
}

// Jika ada sampul baru pakai itu, jika tidak pertahankan yang lama
$sampul_final = $sampul_baru ?? $buku['sampul'];

try {
    $stmt = $pdo->prepare('UPDATE buku SET judul = ?, kategori = ?, penulis = ?, tahun_terbit = ?, stok = ?, sampul = ? WHERE id = ?');
    $stmt->execute([$data['judul'], $data['kategori'], $data['penulis'], $data['tahun_terbit'], $data['stok'], $sampul_final, $id]);

    // File lama baru dihapus setelah UPDATE berhasil
    if ($sampul_baru !== null) {
        hapus_sampul($buku['sampul']);
    }
    set_flash('success', 'Data buku berhasil diperbarui.');
} catch (PDOException $ex) {
    hapus_sampul($sampul_baru);
    set_flash('danger', 'Perubahan gagal disimpan. Coba lagi.');
}
header('Location: dashboard.php');
exit;
