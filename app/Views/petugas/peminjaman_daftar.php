<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peminjaman - Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> <!-- ✅ pastikan file CSS kamu dipanggil -->
</head>

<body class="daftar-peminjaman-body">

    <!-- Sidebar -->
    <?= view('layouts/sidebar') ?>

    <!-- ✅ ubah div utama: hapus class 'container' agar layout tidak terpotong -->
    <div class="daftar-peminjaman-container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold" style="font-size: 1.75rem;">📋 Daftar Peminjaman</h2>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                ✅ <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                ⚠️ <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabel -->
        <?php if(!empty($peminjaman)): ?>
            <div class="table-responsive shadow-sm rounded bg-white">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Ruangan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th width="240">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peminjaman as $p): ?>
                            <tr>
                                <td class="text-center"><?= esc($p['id_booking']) ?></td>
                                <td><?= esc($p['username'] ?? '-') ?></td>
                                <td><?= esc($p['nama_room'] ?? '-') ?></td>
                                <td><?= !empty($p['tanggal_mulai']) ? esc(date('d-m-Y H:i', strtotime($p['tanggal_mulai']))) : '-' ?></td>
                                <td><?= !empty($p['tanggal_selesai']) ? esc(date('d-m-Y H:i', strtotime($p['tanggal_selesai']))) : '-' ?></td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'diterima'): ?>
                                        <span class="badge bg-success">✔ Diterima</span>
                                    <?php elseif ($p['status'] == 'ditolak'): ?>
                                        <span class="badge bg-danger">✖ Ditolak</span>
                                    <?php elseif ($p['status'] == 'selesai'): ?>
                                        <span class="badge bg-secondary">🏁 Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">⏳ Proses</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($p['nama_petugas'] ?? '-') ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('petugas/detail/'.$p['id_booking']) ?>" 
                                       class="btn btn-info btn-sm me-1">ℹ Detail</a>

                                    <?php if($p['status'] == 'pending'): ?>
                                        <a href="<?= base_url('petugas/setuju/'.$p['id_booking']) ?>" 
                                           class="btn btn-success btn-sm me-1">✔ Setuju</a>
                                        <a href="<?= base_url('petugas/tolak/'.$p['id_booking']) ?>" 
                                           class="btn btn-danger btn-sm me-1">✖ Tolak</a>
                                    <?php endif; ?>

                                    <a href="<?= base_url('petugas/hapus/'.$p['id_booking']) ?>" 
                                       class="btn btn-outline-warning btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
                                       🗑 Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info shadow-sm">
                ℹ Belum ada data peminjaman.
            </div>
        <?php endif; ?>

    </div> <!-- end daftar-peminjaman-container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
