<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Main Content - Example</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    
    <style>
        /* Page Header Modern */
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb-modern {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .breadcrumb-modern .breadcrumb-item {
            color: #64748b;
            font-weight: 500;
        }
        
        .breadcrumb-modern .breadcrumb-item.active {
            color: #667eea;
            font-weight: 600;
        }
        
        /* Icon Box Modern */
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .icon-box::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(20px);
            opacity: 0.5;
            z-index: -1;
        }
        
        .icon-box-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .icon-box-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .icon-box-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .icon-box-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .icon-box-info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        /* Action Button Modern */
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .action-btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .action-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            color: white;
        }
        
        .action-btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .action-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        
        .action-btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .action-btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
            color: white;
        }
        
        /* Badge Modern */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .badge-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .badge-info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }
        
        .empty-state h3 {
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #94a3b8;
        }
    </style>
</head>

<body class="modern-dashboard">
    <?= view('layouts/sidebar') ?>
    
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="gradient-text">
                <i class="fas fa-th-large me-2"></i>
                Dashboard Modern
            </h1>
            <nav class="breadcrumb-modern" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home me-1"></i>Home
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="icon-box icon-box-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="font-size: 2rem;">1,234</h3>
                    <p class="text-muted mb-0">Total Pengguna</p>
                    <div class="mt-2">
                        <small class="text-success fw-semibold">
                            <i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="icon-box icon-box-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="font-size: 2rem;">856</h3>
                    <p class="text-muted mb-0">Peminjaman Selesai</p>
                    <div class="mt-2">
                        <small class="text-success fw-semibold">
                            <i class="fas fa-arrow-up me-1"></i>8% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="icon-box icon-box-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="font-size: 2rem;">45</h3>
                    <p class="text-muted mb-0">Menunggu Approval</p>
                    <div class="mt-2">
                        <small class="text-warning fw-semibold">
                            <i class="fas fa-minus me-1"></i>Sama dengan kemarin
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="icon-box icon-box-info">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="font-size: 2rem;">28</h3>
                    <p class="text-muted mb-0">Total Ruangan</p>
                    <div class="mt-2">
                        <small class="text-muted fw-semibold">
                            <i class="fas fa-info-circle me-1"></i>Data terbaru
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Quick Actions
                </h4>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <button class="action-btn action-btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Peminjaman
                </button>
                <button class="action-btn action-btn-success">
                    <i class="fas fa-calendar-plus"></i>
                    Buat Jadwal
                </button>
                <button class="action-btn action-btn-primary">
                    <i class="fas fa-file-pdf"></i>
                    Generate Laporan
                </button>
            </div>
        </div>

        <!-- Recent Activities Table -->
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-history text-primary me-2"></i>
                    Aktivitas Terbaru
                </h4>
                <a href="#" class="text-decoration-none fw-semibold" style="color: #667eea;">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">John Doe</div>
                                        <small class="text-muted">john@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-door-open text-primary me-2"></i>
                                Ruang Meeting A
                            </td>
                            <td>
                                <div>16 Nov 2025</div>
                                <small class="text-muted">09:00 - 11:00</small>
                            </td>
                            <td>
                                <span class="badge-modern badge-success">
                                    <i class="fas fa-check-circle me-1"></i>Diterima
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Jane Smith</div>
                                        <small class="text-muted">jane@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-door-open text-primary me-2"></i>
                                Aula Utama
                            </td>
                            <td>
                                <div>15 Nov 2025</div>
                                <small class="text-muted">14:00 - 16:00</small>
                            </td>
                            <td>
                                <span class="badge-modern badge-warning">
                                    <i class="fas fa-clock me-1"></i>Proses
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-user text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Bob Johnson</div>
                                        <small class="text-muted">bob@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-door-open text-primary me-2"></i>
                                Lab Komputer
                            </td>
                            <td>
                                <div>14 Nov 2025</div>
                                <small class="text-muted">10:00 - 12:00</small>
                            </td>
                            <td>
                                <span class="badge-modern badge-danger">
                                    <i class="fas fa-times-circle me-1"></i>Ditolak
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State Example (Hidden by default) -->
        <div class="glass-card mt-4" style="display: none;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>Belum Ada Data</h3>
                <p>Belum ada aktivitas peminjaman yang tercatat</p>
                <button class="action-btn action-btn-primary mt-3">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Peminjaman Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animate cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card, .glass-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
