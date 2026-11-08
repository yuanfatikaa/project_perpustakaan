# Mini Digital Library

Aplikasi web pengelolaan data buku perpustakaan berbasis PHP Native dan MySQL. Dibuat untuk tugas terstruktur mata kuliah Pemrograman Web, Program Studi Sistem Informasi.

- Nama: (isi nama kamu)
- NPM: (isi NPM kamu)
- Video demo: (tempel link YouTube di sini)

## Fitur

1. Login memakai metode POST, kata sandi disimpan dalam bentuk hash bcrypt
2. Session untuk membatasi akses dashboard dan seluruh halaman kelola buku
3. Cookie Remember Me untuk menyimpan username saja, tidak pernah menyimpan kata sandi
4. Logout menghapus session dan cookie lalu kembali ke halaman login
5. CRUD data buku (judul, kategori, penulis, tahun terbit, stok)
6. Upload sampul buku (jpg atau png, maksimal 2 MB) dengan cek ekstensi, tipe MIME, dan isi gambar
7. Hapus data sekaligus menghapus file sampul di folder uploads
8. Label status otomatis lewat percabangan if-else: stok lebih dari 0 berarti Tersedia, stok 0 berarti Dipinjam
9. Pencarian buku lewat metode GET

## Teknologi

PHP 8 Native, MySQL dengan PDO, Bootstrap 5, Bootstrap Icons, dan JavaScript sederhana untuk pratinjau sampul dan konfirmasi hapus.

## Cara Menjalankan

1. Salin folder project ke `htdocs` (XAMPP) atau `www` (Laragon)
2. Buka phpMyAdmin lalu import file `db_perpustakaan.sql`
3. Cek pengaturan koneksi di `config/koneksi.php`
4. Pastikan folder `uploads/` bisa ditulis oleh server
5. Buka `http://localhost/project_perpustakaan/`
6. Login dengan username `admin` dan kata sandi `admin123`

## Struktur Project

```
project_perpustakaan/
├── config/
│   ├── koneksi.php        Koneksi PDO ke MySQL
│   └── auth.php           Session, proteksi halaman, CSRF, flash message
├── helpers/
│   ├── upload.php         Validasi, simpan, dan hapus file sampul
│   └── validasi.php       Validasi input form buku
├── includes/              Header, footer, dan partial form
├── assets/                CSS dan JS
├── uploads/               Folder sampul buku
├── index.php              Halaman login
├── proses_login.php       Verifikasi login, session, cookie
├── logout.php             Hapus session dan cookie
├── dashboard.php          Tampil data (Read)
├── tambah_buku.php        Form tambah
├── proses_tambah.php      Insert dan upload file
├── edit_buku.php          Form edit
├── proses_edit.php        Update dan penggantian file
├── hapus_buku.php         Delete dan unlink file
└── db_perpustakaan.sql    Ekspor database
```

## Struktur Tabel Database

Tabel `users`

| Kolom    | Tipe         | Keterangan                  |
| -------- | ------------ | --------------------------- |
| id       | INT UNSIGNED | Primary key, auto increment |
| username | VARCHAR(50)  | Unik                        |
| nama     | VARCHAR(100) | Nama tampilan               |
| password | VARCHAR(255) | Hash bcrypt                 |

Tabel `buku`

| Kolom        | Tipe              | Keterangan                         |
| ------------ | ----------------- | ---------------------------------- |
| id           | INT UNSIGNED      | Primary key, auto increment        |
| judul        | VARCHAR(150)      | Judul buku                         |
| kategori     | VARCHAR(50)       | Kategori buku                      |
| penulis      | VARCHAR(100)      | Nama penulis                       |
| tahun_terbit | YEAR              | Tahun terbit                       |
| stok         | SMALLINT UNSIGNED | Jumlah stok, menentukan status     |
| sampul       | VARCHAR(100)      | Nama file sampul di folder uploads |
| created_at   | TIMESTAMP         | Waktu data dibuat                  |

## Keamanan yang Diterapkan

- Prepared statement PDO untuk semua query, jadi aman dari SQL Injection
- `password_hash` dan `password_verify` untuk kata sandi
- `session_regenerate_id` setelah login untuk mencegah session fixation
- Token CSRF pada semua form POST termasuk logout dan hapus
- `htmlspecialchars` pada semua output untuk mencegah XSS
- Nama file upload diacak dan tipe file dicek dari isinya, bukan hanya ekstensi

## Screenshot

Tambahkan gambar ke folder `screenshots/` lalu tampilkan di sini.

| Halaman                 | Gambar                                                            |
| ----------------------- | ----------------------------------------------------------------- |
| Login                   | ![Login](screenshots/1.%20login.png)                              |
| Dashboard               | ![Dashboard](screenshots/2.%20Dashboard.png.png)                  |
| Tambah buku             | ![Tambah](screenshots/3.%20Tambah%20Buku.png.png)                 |
| Edit buku               | ![Edit](screenshots/4.%20Edit%20buku.png.png)                     |
| Konfirmasi hapus        | ![Hapus](screenshots/5.%20Hapus%20Buku.png.png)                   |
| Upload Sampul           | ![Upload](screenshots/6.%20Upload%20Sampul.png.png)               |
| Struktur tabel database | ![Struktur](screenshots/7.%20Struktur%20tabel%20database.png.png) |
| Database Buku           | ![Database](screenshots/8.%20Database%20Buku.png.png)             |

## Video demo

[Tonton di YouTube](https://youtu.be/ajYGg-6BRxM)
