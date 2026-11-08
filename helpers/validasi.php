<?php
// Validasi input form buku, dipakai oleh proses_tambah dan proses_edit.
function validasi_buku(array $post, array $kategori_valid)
{
    $errors = [];
    $data = [
        'judul'       => trim($post['judul'] ?? ''),
        'kategori'    => trim($post['kategori'] ?? ''),
        'penulis'     => trim($post['penulis'] ?? ''),
        'tahun_terbit'=> trim($post['tahun_terbit'] ?? ''),
        'stok'        => trim($post['stok'] ?? ''),
    ];

    if ($data['judul'] === '' || mb_strlen($data['judul']) > 150) {
        $errors[] = 'Judul wajib diisi dan maksimal 150 karakter.';
    }
    if (!in_array($data['kategori'], $kategori_valid, true)) {
        $errors[] = 'Kategori tidak valid.';
    }
    if ($data['penulis'] === '' || mb_strlen($data['penulis']) > 100) {
        $errors[] = 'Penulis wajib diisi dan maksimal 100 karakter.';
    }
    $tahun_maks = (int)date('Y') + 1;
    if (!ctype_digit($data['tahun_terbit']) || $data['tahun_terbit'] < 1900 || $data['tahun_terbit'] > $tahun_maks) {
        $errors[] = "Tahun terbit harus angka antara 1900 dan $tahun_maks.";
    }
    if (!ctype_digit($data['stok']) || (int)$data['stok'] > 1000) {
        $errors[] = 'Stok harus angka bulat 0 sampai 1000.';
    }
    return [$errors, $data];
}
