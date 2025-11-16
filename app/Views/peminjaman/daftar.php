<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="fw-bold mb-4" style="font-size: 1.75rem;">📋 Daftar Peminjaman</h2>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID Booking</th>
                <th>Ruang</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($peminjaman)): ?>
                <tr><td colspan="5" class="text-center">Tidak ada data peminjaman.</td></tr>
            <?php else: ?>
                <?php foreach($peminjaman as $p): ?>
                <tr>
                    <td><?= esc($p['id_booking']) ?></td>
                    <td><?= esc($p['nama_room'] ?? $p['ruang']) ?></td>
                    <td>
                        <?php 
                            $mulai = isset($p['tanggal_mulai']) ? date('d-m-Y H:i', strtotime($p['tanggal_mulai'])) : '-';
                            $selesai = isset($p['tanggal_selesai']) ? date('d-m-Y H:i', strtotime($p['tanggal_selesai'])) : '-';
                        ?>
                        <?= $mulai ?> s/d <?= $selesai ?>
                    </td>
                    <td>
                        <?php if($p['status'] === 'proses'): ?>
                            <span class="badge bg-warning text-dark">Proses</span>
                        <?php elseif($p['status'] === 'diterima'): ?>
                            <span class="badge bg-success">Diterima</span>
                        <?php elseif($p['status'] === 'ditolak'): ?>
                            <span class="badge bg-danger">Ditolak</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= ucfirst(esc($p['status'])) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('peminjaman/detail/'.$p['id_booking']) ?>" class="btn btn-info btn-sm">Detail</a>

                        <?php if($user['role'] === 'petugas' && $p['status'] === 'proses'): ?>
                            <a href="<?= base_url('petugas/setuju/'.$p['id_booking']) ?>" class="btn btn-success btn-sm">✔ Terima</a>
                            <a href="<?= base_url('petugas/tolak/'.$p['id_booking']) ?>" class="btn btn-danger btn-sm">✖ Tolak</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
