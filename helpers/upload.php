<?php
// Fungsi upload dan hapus file sampul buku.
const UPLOAD_DIR  = __DIR__ . '/../uploads/';
const MAKS_UKURAN = 2 * 1024 * 1024; // 2 MB

/**
 * Validasi dan simpan sampul. Return nama file baru, atau null jika tidak ada file.
 * Pesan kesalahan dimasukkan ke array $errors.
 */
function simpan_sampul(array $file, array &$errors)
{
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        $errors[] = 'Ukuran sampul melebihi batas server (maksimal 2 MB).';
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Upload sampul gagal. Coba pilih file lain.';
        return null;
    }
    if ($file['size'] > MAKS_UKURAN) {
        $errors[] = 'Ukuran sampul maksimal 2 MB.';
        return null;
    }

    $ekstensi_boleh = ['jpg', 'jpeg', 'png'];
    $mime_boleh     = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensi_boleh, true)) {
        $errors[] = 'Sampul harus berformat .jpg atau .png.';
        return null;
    }

    // Cek isi file sebenarnya, bukan hanya ekstensi
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!isset($mime_boleh[$mime]) || @getimagesize($file['tmp_name']) === false) {
        $errors[] = 'Isi file bukan gambar JPG atau PNG yang valid.';
        return null;
    }

    $nama_baru = 'sampul_' . bin2hex(random_bytes(8)) . '.' . $mime_boleh[$mime];
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $nama_baru)) {
        $errors[] = 'Gagal menyimpan file ke folder uploads.';
        return null;
    }
    return $nama_baru;
}

function hapus_sampul($nama_file)
{
    if (!$nama_file) {
        return;
    }
    // basename() mencegah path traversal
    $path = UPLOAD_DIR . basename($nama_file);
    if (is_file($path)) {
        unlink($path);
    }
}
