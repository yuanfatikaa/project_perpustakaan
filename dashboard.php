<?php
require 'config/koneksi.php';
require 'config/auth.php';
wajib_login();

// Pencarian lewat metode GET
$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $stmt = $pdo->prepare('SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $kata = "%$cari%";
    $stmt->execute([$kata, $kata, $kata]);
} else {
    $stmt = $pdo->query('SELECT * FROM buku ORDER BY id DESC');
}
$daftar_buku = $stmt->fetchAll();

// Ringkasan statistik
$total = (int)$pdo->query('SELECT COUNT(*) FROM buku')->fetchColumn();
$tersedia = (int)$pdo->query('SELECT COUNT(*) FROM buku WHERE stok > 0')->fetchColumn();
$dipinjam = $total - $tersedia;

$judul_halaman = 'Dashboard | Mini Digital Library';
include 'includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h3 m-0">Koleksi buku</h1>
    <a href="tambah_buku.php" class="btn btn-aksen"><i class="bi bi-plus-lg me-1"></i>Tambah buku</a>
</div>

<?php tampil_flash(); ?>

<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="panel stat"><div class="angka"><?= $total ?></div><div class="text-secondary">Total judul</div></div></div>
    <div class="col-md-4"><div class="panel stat hijau"><div class="angka"><?= $tersedia ?></div><div class="text-secondary">Tersedia</div></div></div>
    <div class="col-md-4"><div class="panel stat oranye"><div class="angka"><?= $dipinjam ?></div><div class="text-secondary">Sedang dipinjam</div></div></div>
</div>

<div class="panel p-3">
    <form method="get" action="dashboard.php" class="row g-2 mb-3">
        <div class="col-sm-9 col-md-10">
            <input type="search" name="cari" class="form-control" placeholder="Cari judul, penulis, atau kategori" value="<?= e($cari) ?>" aria-label="Cari buku">
        </div>
        <div class="col-sm-3 col-md-2 d-grid"><button class="btn btn-utama">Cari</button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle tabel-buku mb-0">
            <thead>
                <tr>
                    <th>No</th><th>Sampul</th><th>Judul</th><th>Kategori</th>
                    <th>Penulis</th><th>Tahun</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$daftar_buku): ?>
                <tr><td colspan="9" class="text-center text-secondary py-5">
                    <?= $cari !== '' ? 'Tidak ada buku yang cocok dengan pencarian.' : 'Belum ada buku. Klik "Tambah buku" untuk mulai mengisi koleksi.' ?>
                </td></tr>
            <?php endif; ?>
            <?php foreach ($daftar_buku as $i => $b): ?>
                <?php [$teks_status, $warna] = label_status($b['stok']); ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?php if ($b['sampul'] && is_file('uploads/' . basename($b['sampul']))): ?>
                            <img class="sampul-kecil" src="uploads/<?= e($b['sampul']) ?>" alt="Sampul <?= e($b['judul']) ?>">
                        <?php else: ?>
                            <div class="sampul-kosong"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-semibold"><?= e($b['judul']) ?></td>
                    <td><?= e($b['kategori']) ?></td>
                    <td><?= e($b['penulis']) ?></td>
                    <td><?= e($b['tahun_terbit']) ?></td>
                    <td><?= (int)$b['stok'] ?></td>
                    <td><span class="badge text-bg-<?= $warna ?>"><?= $teks_status ?></span></td>
                    <td class="text-end text-nowrap">
                        <a href="edit_buku.php?id=<?= (int)$b['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="hapus_buku.php" method="post" class="d-inline form-hapus" data-judul="<?= e($b['judul']) ?>">
                            <?= csrf_input() ?>
                            <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
