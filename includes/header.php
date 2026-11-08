<?php
// $judul_halaman diisi dari tiap halaman
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul_halaman ?? 'Mini Digital Library') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<?php if (!empty($_SESSION['user_id'])): ?>
<nav class="navbar navbar-expand-md topbar">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-book-half me-2"></i>Mini Digital Library</a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white-50 small d-none d-sm-inline">Masuk sebagai <strong class="text-white"><?= e($_SESSION['nama']) ?></strong></span>
            <form action="logout.php" method="post" class="m-0">
                <?= csrf_input() ?>
                <button class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
            </form>
        </div>
    </div>
</nav>
<?php endif; ?>
<main class="container py-4">
