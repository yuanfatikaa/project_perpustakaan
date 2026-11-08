<?php
// Partial form. Variabel yang dibutuhkan: $aksi, $nilai (array), $teks_tombol, $sampul_lama (opsional), $id (opsional)
global $DAFTAR_KATEGORI;
?>
<form action="<?= e($aksi) ?>" method="post" enctype="multipart/form-data" class="panel p-4" novalidate>
    <?= csrf_input() ?>
    <?php if (!empty($id)): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <div class="row g-3">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul buku</label>
                <input type="text" class="form-control" id="judul" name="judul" maxlength="150" value="<?= e($nilai['judul']) ?>" required>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <option value="">Pilih kategori</option>
                        <?php foreach ($DAFTAR_KATEGORI as $k): ?>
                            <option value="<?= e($k) ?>" <?= $nilai['kategori'] === $k ? 'selected' : '' ?>><?= e($k) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" maxlength="100" value="<?= e($nilai['penulis']) ?>" required>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="tahun_terbit" class="form-label">Tahun terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" min="1900" max="<?= date('Y') + 1 ?>" value="<?= e($nilai['tahun_terbit']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" min="0" max="1000" value="<?= e($nilai['stok']) ?>" required>
                    <div class="form-text">Stok lebih dari 0 berarti Tersedia. Stok 0 berarti Dipinjam.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label for="sampul" class="form-label">Sampul buku</label>
            <input type="file" class="form-control" id="sampul" name="sampul" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            <div id="infoSampul" class="form-text">Format JPG atau PNG, maksimal 2 MB.<?= !empty($sampul_lama) ? ' Kosongkan jika tidak ingin mengganti.' : '' ?></div>
            <div class="mt-3">
                <?php $ada_lama = !empty($sampul_lama) && is_file(__DIR__ . '/../uploads/' . basename($sampul_lama)); ?>
                <img id="preview" class="sampul-preview <?= $ada_lama ? '' : 'd-none' ?>" alt="Pratinjau sampul"
                     src="<?= $ada_lama ? 'uploads/' . e($sampul_lama) : '' ?>">
            </div>
        </div>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-utama"><?= e($teks_tombol) ?></button>
        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
