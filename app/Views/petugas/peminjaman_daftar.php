<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman - Petugas | SmartRoom</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    
    <style>
        /* Page Header Modern */
        .page-header-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .page-title-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0;
        }

        /* Table Card Modern */
        .table-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Modern Table */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 900px;
        }

        .table-modern thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .table-modern thead th {
            padding: 1.25rem 1rem;
            font-weight: 600;
            text-align: left;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            border: none;
        }

        .table-modern thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table-modern thead th:last-child {
            border-top-right-radius: 12px;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background: white;
        }

        .table-modern tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: scale(1.002);
        }

        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Status Badges */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-diterima {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .badge-ditolak {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .badge-selesai {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .badge-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        /* Action Buttons */
        .btn-action-modern {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.75rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
            margin: 0.15rem;
        }

        .btn-detail-modern {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-detail-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            color: white;
        }

        .btn-approve-modern {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-approve-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }

        .btn-reject-modern {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-reject-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
            color: white;
        }

        .btn-delete-modern {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-delete-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-state h4 {
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: #94a3b8;
        }

        /* Responsive Desktop */
        @media (min-width: 1200px) {
            .table-modern {
                min-width: 100%;
            }
        }

        /* Responsive Tablet */
        @media (max-width: 1199px) {
            .page-header-modern {
                padding: 1.75rem;
            }

            .page-title-gradient {
                font-size: 1.75rem;
            }

            .table-card-modern {
                padding: 1.75rem;
            }

            .table-modern {
                min-width: 850px;
            }
        }

        @media (max-width: 992px) {
            .page-header-modern {
                padding: 1.5rem;
            }

            .page-title-gradient {
                font-size: 1.5rem;
            }

            .table-card-modern {
                padding: 1.5rem;
            }

            .table-modern {
                min-width: 800px;
                font-size: 0.875rem;
            }

            .table-modern thead th,
            .table-modern tbody td {
                padding: 0.875rem 0.75rem;
            }
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .page-header-modern {
                padding: 1.25rem;
                border-radius: 15px;
            }

            .page-title-gradient {
                font-size: 1.35rem;
            }

            .table-card-modern {
                padding: 1rem;
                border-radius: 15px;
            }

            .table-modern {
                min-width: 700px;
                font-size: 0.8rem;
            }

            .table-modern thead th,
            .table-modern tbody td {
                padding: 0.75rem 0.5rem;
            }

            .badge-modern {
                font-size: 0.75rem;
                padding: 0.4rem 0.85rem;
            }

            .btn-action-modern {
                font-size: 0.7rem;
                padding: 0.45rem 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .page-header-modern {
                padding: 1rem;
                border-radius: 12px;
            }

            .page-title-gradient {
                font-size: 1.15rem;
            }

            .table-card-modern {
                padding: 0.75rem;
                border-radius: 12px;
            }

            .table-modern {
                min-width: 650px;
                font-size: 0.75rem;
            }

            .table-modern thead th,
            .table-modern tbody td {
                padding: 0.6rem 0.4rem;
            }

            .badge-modern {
                font-size: 0.7rem;
                padding: 0.35rem 0.75rem;
            }

            .btn-action-modern {
                font-size: 0.65rem;
                padding: 0.4rem 0.75rem;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state-icon {
                font-size: 3rem;
            }
        }

        /* Very Small Screens */
        @media (max-width: 400px) {
            .page-title-gradient {
                font-size: 1rem;
            }

            .table-modern {
                min-width: 600px;
                font-size: 0.7rem;
            }

            .table-modern thead th,
            .table-modern tbody td {
                padding: 0.5rem 0.3rem;
            }
        }
    </style>
</head>

<body class="modern-dashboard">
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header-modern">
            <h1 class="page-title-gradient">
                <i class="fas fa-clipboard-list me-2"></i>
                Daftar Peminjaman
            </h1>
            <p class="text-muted mb-0 mt-2">
                <i class="fas fa-info-circle me-2"></i>
                Kelola semua pengajuan peminjaman ruangan
            </p>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Table Card -->
        <div class="table-card-modern">
            <?php if(!empty($peminjaman)): ?>
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 12%;">Username</th>
                                <th style="width: 15%;">Ruangan</th>
                                <th style="width: 13%;">Mulai</th>
                                <th style="width: 13%;">Selesai</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 12%;">Petugas</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($peminjaman as $p): ?>
                                <tr>
                                    <td class="text-center fw-semibold"><?= esc($p['id_booking']) ?></td>
                                    <td>
                                        <span class="fw-semibold text-dark">
                                            <?= esc($p['username'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem;">
                                                <i class="fas fa-door-open"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">
                                                <?= esc($p['nama_room'] ?? '-') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem; color: #1e293b; font-weight: 500;">
                                            <?= !empty($p['tanggal_mulai']) ? date('d M Y', strtotime($p['tanggal_mulai'])) : '-' ?><br>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                <?= !empty($p['tanggal_mulai']) ? date('H:i', strtotime($p['tanggal_mulai'])) : '-' ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem; color: #1e293b; font-weight: 500;">
                                            <?= !empty($p['tanggal_selesai']) ? date('d M Y', strtotime($p['tanggal_selesai'])) : '-' ?><br>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                <?= !empty($p['tanggal_selesai']) ? date('H:i', strtotime($p['tanggal_selesai'])) : '-' ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($p['status'] == 'diterima'): ?>
                                            <span class="badge-modern badge-diterima">
                                                <i class="fas fa-check-circle"></i>
                                                Diterima
                                            </span>
                                        <?php elseif ($p['status'] == 'ditolak'): ?>
                                            <span class="badge-modern badge-ditolak">
                                                <i class="fas fa-times-circle"></i>
                                                Ditolak
                                            </span>
                                        <?php elseif ($p['status'] == 'selesai'): ?>
                                            <span class="badge-modern badge-selesai">
                                                <i class="fas fa-flag-checkered"></i>
                                                Selesai
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-modern badge-pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 0.875rem;">
                                            <?= esc($p['nama_petugas'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="<?= base_url('petugas/detail/'.$p['id_booking']) ?>" 
                                               class="btn-action-modern btn-detail-modern">
                                                <i class="fas fa-info-circle"></i>
                                                Detail
                                            </a>

                                            <?php if($p['status'] == 'pending'): ?>
                                                <a href="<?= base_url('petugas/setuju/'.$p['id_booking']) ?>" 
                                                   class="btn-action-modern btn-approve-modern">
                                                    <i class="fas fa-check"></i>
                                                    Setuju
                                                </a>
                                                <a href="<?= base_url('petugas/tolak/'.$p['id_booking']) ?>" 
                                                   class="btn-action-modern btn-reject-modern">
                                                    <i class="fas fa-times"></i>
                                                    Tolak
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= base_url('petugas/hapus/'.$p['id_booking']) ?>" 
                                               class="btn-action-modern btn-delete-modern"
                                               onclick="return confirm('⚠️ Hapus Peminjaman?\n\nApakah Anda yakin ingin menghapus peminjaman ini?\n\nTindakan ini tidak dapat dibatalkan!')">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Belum Ada Peminjaman</h4>
                    <p>Tidak ada data peminjaman yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
