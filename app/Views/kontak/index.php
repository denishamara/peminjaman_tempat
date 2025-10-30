<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Kontak Petugas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-danger"><?= esc($title) ?></h2>
        <p class="text-muted">Hubungi petugas berikut jika terjadi keadaan mendesak seperti kunci hilang atau jadwal bentrok.</p>
    </div>

    <div class="row justify-content-center">
        <?php foreach ($petugas as $p): ?>
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary fw-bold"><?= esc($p['nama']) ?></h5>
                        <p class="card-text text-muted mb-1"><?= esc($p['jabatan']) ?></p>
                        <p><strong>Shift:</strong> <?= esc($p['shift']) ?></p>
                        <p><strong>Telepon:</strong> <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $p['telepon']) ?>" target="_blank" class="text-success text-decoration-none"><?= esc($p['telepon']) ?></a></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= esc($p['email']) ?>" class="text-decoration-none"><?= esc($p['email']) ?></a></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
