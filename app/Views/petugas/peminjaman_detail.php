<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman | SmartRoom</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        /* Page Header Modern */
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.75rem 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 1.75rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-back {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.65rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            color: white;
        }

        /* Alert Modern */
        .alert {
            border-radius: 14px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Detail Card Modern */
        .detail-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .detail-card .card-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-table {
            width: 100%;
            margin-bottom: 0;
        }

        .detail-table tr {
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table th {
            padding: 1rem 0;
            font-weight: 600;
            color: #64748b;
            width: 200px;
            vertical-align: top;
        }

        .detail-table td {
            padding: 1rem 0;
            color: #334155;
            font-weight: 500;
        }

        /* Status Badge Modern */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-badge.badge-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .status-badge.badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .status-badge.badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .status-badge.badge-secondary {
            background: linear-gradient(135deg, #94a3b8, #64748b);
            color: white;
            box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3);
        }

        /* Action Section Modern */
        .action-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem 1.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            max-width: 650px;
        }

        .action-section .card-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .action-btn {
            min-width: 180px;
            padding: 1.1rem 2.5rem;
            font-weight: 700;
            font-size: 1.05rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            border-radius: 16px;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .action-btn i {
            font-size: 1.25rem;
        }

        .btn-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.45);
        }

        .btn-approve:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 35px rgba(16, 185, 129, 0.65);
            color: white;
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 6px 25px rgba(239, 68, 68, 0.45);
        }

        .btn-reject:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 35px rgba(239, 68, 68, 0.65);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 6px 25px rgba(245, 158, 11, 0.45);
        }

        .btn-delete:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 35px rgba(245, 158, 11, 0.65);
            color: white;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .detail-card,
            .action-section {
                padding: 1.5rem;
                max-width: 100%;
            }

            .detail-table th {
                width: 150px;
            }

            .action-section .card-title {
                font-size: 1.25rem;
            }

            .action-buttons {
                gap: 1rem;
            }

            .action-btn {
                min-width: 170px;
                padding: 1rem 2.2rem;
                font-size: 1rem;
            }

            .action-btn i {
                font-size: 1.15rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 1.25rem;
                border-radius: 15px;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .btn-back {
                padding: 0.6rem 1.25rem;
                font-size: 0.875rem;
            }

            .detail-card,
            .action-section {
                padding: 1.25rem;
                border-radius: 15px;
            }

            .action-section .card-title {
                font-size: 1.15rem;
            }

            .detail-table th,
            .detail-table td {
                display: block;
                width: 100% !important;
                padding: 0.75rem 0;
            }

            .detail-table th {
                color: #667eea;
                font-weight: 700;
                padding-bottom: 0.25rem;
            }

            .detail-table td {
                padding-top: 0.25rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            }

            .detail-table tr {
                border-bottom: none;
            }

            .detail-table tr:last-child td {
                border-bottom: none;
            }

            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .action-btn {
                width: 100%;
                min-width: 100%;
                padding: 1.05rem 1.75rem;
                font-size: 1rem;
            }

            .action-btn i {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 1.1rem;
            }

            .detail-card .card-title,
            .action-section .card-title {
                font-size: 1.05rem;
            }

            .detail-table {
                font-size: 0.875rem;
            }

            .status-badge {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .action-btn {
                padding: 1rem 1.5rem;
                font-size: 0.95rem;
            }

            .action-btn i {
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .action-btn {
                padding: 0.95rem 1.3rem;
                font-size: 0.9rem;
                letter-spacing: 0.3px;
            }

            .action-btn i {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-info-circle"></i>
                Detail Peminjaman
            </h2>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Detail Card -->
        <div class="detail-card">
            <h3 class="card-title">
                <i class="fas fa-clipboard-list"></i>
                Informasi Peminjaman
            </h3>
            <table class="detail-table">
                <tr>
                    <th><i class="fas fa-hashtag text-muted me-2"></i>ID Peminjaman</th>
                    <td><strong><?= esc($peminjaman['id_booking']) ?></strong></td>
                </tr>
                <tr>
                    <th><i class="fas fa-user text-muted me-2"></i>Username</th>
                    <td><?= esc($peminjaman['username'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th><i class="fas fa-door-open text-muted me-2"></i>Ruang</th>
                    <td><?= esc($peminjaman['nama_room'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th><i class="fas fa-calendar-alt text-muted me-2"></i>Tanggal Mulai</th>
                    <td>
                        <i class="fas fa-clock text-primary me-1"></i>
                        <?= esc(date('d-m-Y H:i', strtotime($peminjaman['tanggal_mulai']))) ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fas fa-calendar-check text-muted me-2"></i>Tanggal Selesai</th>
                    <td>
                        <i class="fas fa-clock text-primary me-1"></i>
                        <?= esc(date('d-m-Y H:i', strtotime($peminjaman['tanggal_selesai']))) ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fas fa-flag text-muted me-2"></i>Status</th>
                    <td>
                        <?php if($peminjaman['status'] == 'diterima'): ?>
                            <span class="status-badge badge-success">
                                <i class="fas fa-check-circle"></i>
                                Diterima
                            </span>
                        <?php elseif($peminjaman['status'] == 'ditolak'): ?>
                            <span class="status-badge badge-danger">
                                <i class="fas fa-times-circle"></i>
                                Ditolak
                            </span>
                        <?php elseif(in_array(strtolower($peminjaman['status']), ['proses','pending'])): ?>
                            <span class="status-badge badge-warning">
                                <i class="fas fa-clock"></i>
                                Proses
                            </span>
                        <?php else: ?>
                            <span class="status-badge badge-secondary">
                                <i class="fas fa-minus-circle"></i>
                                -
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fas fa-comment-alt text-muted me-2"></i>Keterangan</th>
                    <td><?= esc($peminjaman['keterangan'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th><i class="fas fa-user-tie text-muted me-2"></i>Petugas</th>
                    <td><?= esc($peminjaman['nama_petugas'] ?? '-') ?></td>
                </tr>
            </table>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <h3 class="card-title">
                <i class="fas fa-cogs"></i>
                Aksi
            </h3>
            <div class="action-buttons">
                <?php if (in_array(strtolower($peminjaman['status']), ['pending','proses'])): ?>
                    <a href="<?= base_url('petugas/setuju/'.$peminjaman['id_booking']) ?>" 
                       class="action-btn btn-approve">
                        <i class="fas fa-check-circle"></i>
                        Setujui
                    </a>
                    <a href="<?= base_url('petugas/tolak/'.$peminjaman['id_booking']) ?>" 
                       class="action-btn btn-reject">
                        <i class="fas fa-times-circle"></i>
                        Tolak
                    </a>
                <?php endif; ?>
                
                <a href="<?= base_url('petugas/hapus/'.$peminjaman['id_booking']) ?>" 
                   onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')" 
                   class="action-btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    Hapus
                </a>
            </div>
        </div>
    </div>

    <!-- Auto dismiss alerts -->
    <script>
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
