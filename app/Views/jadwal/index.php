<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 260px; /* sesuaikan jika ada sidebar */
            padding: 30px;
        }
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        .filter-btn.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">📅 Jadwal Ruangan</h4>
                <div class="btn-group">
                    <a href="?filter=all" class="btn btn-outline-light filter-btn <?= ($filter == 'all') ? 'active' : '' ?>">Gabungan</a>
                    <a href="?filter=reguler" class="btn btn-outline-light filter-btn <?= ($filter == 'reguler') ? 'active' : '' ?>">Reguler</a>
                    <a href="?filter=booking" class="btn btn-outline-light filter-btn <?= ($filter == 'booking') ? 'active' : '' ?>">Booking</a>
                </div>
            </div>
          <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold">📅 Jadwal Reguler & Booking</h3>
      <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-primary">
        <i class="bi bi-calendar3"></i> Lihat Kalender
      </a>
    </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Ruangan</th>
                            <th>Nama Kegiatan</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <tr class="<?= strtolower($j['status']) == 'reguler' ? 'table-primary' : 'table-warning' ?>">
                                    <td><?= esc($j['nama_ruang']) ?></td>
                                    <td><?= esc($j['nama_kegiatan']) ?></td>
                                    <td><?= esc($j['hari']) ?></td>
                                    <td><?= esc($j['jam_mulai']) ?></td>
                                    <td><?= esc($j['jam_selesai']) ?></td>
                                    <td class="text-capitalize"><?= esc($j['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Tidak ada jadwal ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
