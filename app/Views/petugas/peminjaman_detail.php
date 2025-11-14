<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Ruang utama menyesuaikan sidebar */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* Tombol aksi biar seragam dan sejajar */
        .action-btn {
            min-width: 130px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .action-btn i {
            margin-right: 6px;
        }

        /* Warna tombol diseragamkan */
        .btn-success { background-color: #28a745; border: none; }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-warning { background-color: #ffc107; border: none; color: #000; }

        .btn-success:hover { background-color: #218838; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-warning:hover { background-color: #e0a800; color: #000; }

        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">ℹ Detail Peminjaman</h2>
        </div>

        <!-- Notifikasi Flash -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

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

        <!-- Tombol Aksi -->
        <div class="mt-4 d-flex flex-wrap gap-3">
            <?php if (in_array(strtolower($peminjaman['status']), ['pending','proses'])): ?>
                <a href="<?= base_url('petugas/setuju/'.$peminjaman['id_booking']) ?>" 
                   class="btn btn-success action-btn">✔ Setujui</a>
                <a href="<?= base_url('petugas/tolak/'.$peminjaman['id_booking']) ?>" 
                   class="btn btn-danger action-btn">✖ Tolak</a>
            <?php endif; ?>
            
            <a href="<?= base_url('petugas/hapus/'.$peminjaman['id_booking']) ?>" 
               onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')" 
               class="btn btn-warning action-btn">🗑 Hapus</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
