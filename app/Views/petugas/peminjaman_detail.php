<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">ℹ Detail Peminjaman</h2>
    </div>

    <!-- Detail Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th width="200">ID Peminjaman</th>
                    <td><?= esc($peminjaman['id_booking']) ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= esc($peminjaman['username'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Ruang</th>
                    <td><?= esc($peminjaman['nama_room'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td><?= esc(date('d-m-Y H:i', strtotime($peminjaman['tanggal_mulai']))) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td><?= esc(date('d-m-Y H:i', strtotime($peminjaman['tanggal_selesai']))) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if($peminjaman['status'] == 'diterima'): ?>
                            <span class="badge bg-success">✔ Diterima</span>
                        <?php elseif($peminjaman['status'] == 'ditolak'): ?>
                            <span class="badge bg-danger">✖ Ditolak</span>
                        <?php elseif(in_array(strtolower($peminjaman['status']), ['proses','pending'])): ?>
                        <span class="badge bg-warning text-dark">⏳ Proses</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= esc($peminjaman['keterangan'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td><?= esc($peminjaman['nama_petugas'] ?? '-') ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4">
        <?php if (in_array(strtolower($peminjaman['status']), ['pending','proses'])): ?>
            <a href="<?= base_url('petugas/setuju/'.$peminjaman['id_booking']) ?>" class="btn btn-success me-2">✔ Setujui</a>
            <a href="<?= base_url('petugas/tolak/'.$peminjaman['id_booking']) ?>" class="btn btn-danger me-2">✖ Tolak</a>
        <?php endif; ?>
        <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="btn btn-outline-secondary btn-sm">
            ⬅ Kembali
        </a>
        <a href="<?= base_url('petugas/hapus/'.$peminjaman['id_booking']) ?>" 
           onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')" 
           class="btn btn-warning">🗑 Hapus</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
