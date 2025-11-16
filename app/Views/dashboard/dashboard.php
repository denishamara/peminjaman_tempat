<?php
// 🚫 Hapus cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// 🔒 Cek session login
if (!session()->has('user')) {
  header("Location: " . base_url('auth/login'));
  exit;
}

$user = session()->get('user');
?>
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | SmartRoom</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Bootstrap & Custom Style -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  
  <style>
    /* Modern Page Header */
    .page-header-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .welcome-text {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .role-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1.25rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Modern Stats Card */
    .stat-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 1.75rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .stat-card-modern::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--gradient-from), var(--gradient-to));
    }

    .stat-card-modern:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-icon-box {
      width: 70px;
      height: 70px;
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin-bottom: 1rem;
      position: relative;
      background: linear-gradient(135deg, var(--gradient-from), var(--gradient-to));
      color: white;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-icon-box::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: inherit;
      filter: blur(25px);
      opacity: 0.6;
      z-index: -1;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 0.25rem;
      background: linear-gradient(135deg, var(--gradient-from), var(--gradient-to));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-label {
      color: #64748b;
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.75rem;
    }

    .stat-trend {
      font-size: 0.875rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.35rem 0.75rem;
      border-radius: 50px;
    }

    .trend-up {
      background: rgba(16, 185, 129, 0.1);
      color: #10b981;
    }

    .trend-down {
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
    }

    /* Chart Card */
    .chart-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      min-height: 450px;
    }

    .chart-canvas {
      height: 320px !important;
      max-height: 320px !important;
    }

    /* Action Card */
    .action-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      height: 100%;
    }

    .action-card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
    }

    .action-icon-box {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.75rem;
      margin-bottom: 1rem;
    }

    .action-btn-modern {
      background: linear-gradient(135deg, var(--gradient-from), var(--gradient-to));
      border: none;
      color: white;
      padding: 0.85rem 1.5rem;
      border-radius: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .action-btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
      color: white;
    }

    /* Table Modern */
    .table-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .table-header-modern {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid rgba(102, 126, 234, 0.1);
    }

    .table-title {
      font-weight: 800;
      font-size: 1.5rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .count-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Modern Table Styles */
    .modern-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .modern-table thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .modern-table thead th {
      padding: 1.25rem 1rem;
      font-weight: 600;
      text-align: left;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .modern-table thead th:first-child {
      border-top-left-radius: 12px;
    }

    .modern-table thead th:last-child {
      border-top-right-radius: 12px;
    }

    .modern-table tbody tr {
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      transform: scale(1.01);
    }

    .modern-table tbody td {
      padding: 1.25rem 1rem;
      vertical-align: middle;
    }

    /* Status Badges */
    .status-badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .status-badge.Proses,
    .status-badge.proses {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .status-badge.Diterima,
    .status-badge.diterima {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .status-badge.Ditolak,
    .status-badge.ditolak {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .status-badge.Selesai,
    .status-badge.selesai {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Empty State */
    .empty-state-modern {
      text-align: center;
      padding: 3rem 2rem;
    }

    .empty-state-icon {
      font-size: 5rem;
      color: #cbd5e1;
      margin-bottom: 1.5rem;
      opacity: 0.7;
    }

    .empty-state-modern h4 {
      color: #64748b;
      font-weight: 700;
      margin-bottom: 0.75rem;
      font-size: 1.25rem;
    }

    .empty-state-modern p {
      color: #94a3b8;
      margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .welcome-text {
        font-size: 1.75rem;
      }

      .stat-card-modern {
        margin-bottom: 1rem;
      }

      .stat-number {
        font-size: 2rem;
      }

      .stat-icon-box {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
      }

      .chart-card {
        margin-bottom: 1.5rem;
      }
    }
  </style>
</head>

<body class="modern-dashboard">
  <?= view('layouts/sidebar') ?>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Modern Page Header -->
    <div class="page-header-modern">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
          <h1 class="welcome-text">
            <i class="fas fa-hand-sparkles me-3"></i>Selamat Datang, <?= esc($user['username']) ?>!
          </h1>
          <p class="text-muted mb-0 fs-5">
            <i class="far fa-calendar-alt me-2"></i>
            <?= date('l, d F Y') ?>
          </p>
        </div>
        <div>
          <span class="role-badge">
            <i class="fas fa-user-shield"></i>
            <?= esc(ucfirst($user['role'])) ?>
          </span>
        </div>
      </div>
    </div>

      <?php if ($user['role'] === 'administrator'): ?>
        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
          <div class="col-lg-4 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2;">
              <div class="stat-icon-box">
                <i class="fas fa-users-cog"></i>
              </div>
              <div class="stat-number"><?= esc($totalUsers) ?></div>
              <div class="stat-label">Total Pengguna</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-arrow-up"></i>
                Aktif Semua
              </span>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #10b981; --gradient-to: #059669;">
              <div class="stat-icon-box">
                <i class="fas fa-door-open"></i>
              </div>
              <div class="stat-number"><?= esc($totalRuang) ?></div>
              <div class="stat-label">Total Ruangan</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-check-circle"></i>
                Tersedia
              </span>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #f59e0b; --gradient-to: #d97706;">
              <div class="stat-icon-box">
                <i class="fas fa-clipboard-list"></i>
              </div>
              <div class="stat-number"><?= esc($totalPeminjaman) ?></div>
              <div class="stat-label">Total Peminjaman</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-chart-line"></i>
                Semua Status
              </span>
            </div>
          </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
          <div class="col-lg-7">
            <div class="chart-card">
              <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-chart-bar text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0" style="color: #667eea;">Statistik Peminjaman Bulanan</h5>
                  <p class="text-muted small mb-0">Jumlah peminjaman per bulan tahun ini</p>
                </div>
              </div>
              <canvas id="chartPeminjaman" class="chart-canvas"></canvas>
            </div>
          </div>
          
          <div class="col-lg-5">
            <div class="chart-card">
              <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-chart-pie text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0" style="color: #10b981;">Distribusi Status</h5>
                  <p class="text-muted small mb-0">Persentase status peminjaman</p>
                </div>
              </div>
              <canvas id="chartStatus" class="chart-canvas"></canvas>
            </div>
          </div>
        </div>

        <!-- Recent Activities Table -->
        <div class="table-card-modern">
          <div class="table-header-modern">
            <h5 class="table-title">
              <i class="fas fa-history"></i>
              Aktivitas Peminjaman Terbaru
            </h5>
            <span class="count-badge">
              <i class="fas fa-list-ul me-1"></i>
              <?= count($recentPeminjaman) ?> Data
            </span>
          </div>
          <div class="table-responsive">
            <table class="modern-table">
              <thead>
                <tr>
                  <th><i class="fas fa-user me-2"></i>Peminjam</th>
                  <th><i class="fas fa-door-open me-2"></i>Ruangan</th>
                  <th><i class="fas fa-calendar-alt me-2"></i>Waktu Mulai</th>
                  <th><i class="fas fa-calendar-check me-2"></i>Waktu Selesai</th>
                  <th><i class="fas fa-info-circle me-2"></i>Status</th>
                  <th><i class="fas fa-comment-dots me-2"></i>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($recentPeminjaman)): ?>
                  <tr>
                    <td colspan="6">
                      <div class="empty-state-modern">
                        <div class="empty-state-icon">
                          <i class="fas fa-inbox"></i>
                        </div>
                        <h4>Belum Ada Peminjaman</h4>
                        <p>Belum ada aktivitas peminjaman yang tercatat</p>
                      </div>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($recentPeminjaman as $p): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-user text-primary"></i>
                          </div>
                          <strong><?= esc($p['username']) ?></strong>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-door-open text-success me-2"></i>
                          <?= esc($p['nama_room']) ?>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($p['tanggal_mulai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($p['tanggal_mulai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($p['tanggal_selesai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($p['tanggal_selesai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <span class="status-badge <?= esc($p['status']) ?>">
                          <?php if (strtolower($p['status']) === 'proses'): ?>
                            <i class="fas fa-clock"></i>
                          <?php elseif (strtolower($p['status']) === 'diterima'): ?>
                            <i class="fas fa-check-circle"></i>
                          <?php elseif (strtolower($p['status']) === 'ditolak'): ?>
                            <i class="fas fa-times-circle"></i>
                          <?php else: ?>
                            <i class="fas fa-flag-checkered"></i>
                          <?php endif; ?>
                          <?= esc(ucfirst($p['status'])) ?>
                        </span>
                      </td>
                      <td>
                        <span class="text-muted">
                          <i class="fas fa-info-circle me-1"></i>
                          <?= esc($p['keterangan']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif ($user['role'] === 'petugas'): ?>
        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #f59e0b; --gradient-to: #d97706;">
              <div class="stat-icon-box">
                <i class="fas fa-hourglass-half"></i>
              </div>
              <div class="stat-number"><?= esc($totalPeminjamanPending) ?></div>
              <div class="stat-label">Menunggu Persetujuan</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-exclamation-circle"></i>
                Perlu Review
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2;">
              <div class="stat-icon-box">
                <i class="fas fa-calendar-day"></i>
              </div>
              <div class="stat-number"><?= count($jadwalRuang) ?></div>
              <div class="stat-label">Jadwal Hari Ini</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-check-circle"></i>
                Aktif
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #10b981; --gradient-to: #059669;">
              <div class="stat-icon-box">
                <i class="fas fa-check-double"></i>
              </div>
              <div class="stat-number">
                <?= count(array_filter($jadwalRuang, fn($j) => strtolower($j['status']) === 'diterima')) ?>
              </div>
              <div class="stat-label">Disetujui</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-thumbs-up"></i>
                Approved
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #ef4444; --gradient-to: #dc2626;">
              <div class="stat-icon-box">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="stat-number">
                <?= count(array_filter($jadwalRuang, fn($j) => strtolower($j['status']) === 'ditolak')) ?>
              </div>
              <div class="stat-label">Ditolak</div>
              <span class="stat-trend trend-down">
                <i class="fas fa-ban"></i>
                Rejected
              </span>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="action-card-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2;">
              <div class="action-icon-box" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15)); color: #667eea;">
                <i class="fas fa-tasks"></i>
              </div>
              <h5 class="fw-bold mb-2">Kelola Peminjaman</h5>
              <p class="text-muted mb-4">Review dan approve peminjaman yang masuk</p>
              <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="action-btn-modern">
                <i class="fas fa-clipboard-check"></i>
                Lihat Daftar Peminjaman
              </a>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="action-card-modern" style="--gradient-from: #10b981; --gradient-to: #059669;">
              <div class="action-icon-box" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.15)); color: #10b981;">
                <i class="fas fa-history"></i>
              </div>
              <h5 class="fw-bold mb-2">Riwayat Peminjaman</h5>
              <p class="text-muted mb-4">Lihat history peminjaman yang sudah selesai</p>
              <a href="<?= base_url('peminjaman/history') ?>" class="action-btn-modern">
                <i class="fas fa-archive"></i>
                Lihat Riwayat Lengkap
              </a>
            </div>
          </div>
        </div>

        <!-- Jadwal Ruangan Table -->
        <div class="table-card-modern">
          <div class="table-header-modern">
            <h5 class="table-title">
              <i class="fas fa-calendar-alt"></i>
              Jadwal Ruangan Hari Ini
            </h5>
            <span class="count-badge">
              <i class="fas fa-list-ul me-1"></i>
              <?= count($jadwalRuang) ?> Jadwal
            </span>
          </div>
          <div class="table-responsive">
            <table class="modern-table">
              <thead>
                <tr>
                  <th><i class="fas fa-door-open me-2"></i>Ruangan</th>
                  <th><i class="fas fa-calendar-alt me-2"></i>Waktu Mulai</th>
                  <th><i class="fas fa-calendar-check me-2"></i>Waktu Selesai</th>
                  <th><i class="fas fa-info-circle me-2"></i>Status</th>
                  <th><i class="fas fa-comment-dots me-2"></i>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($jadwalRuang)): ?>
                  <tr>
                    <td colspan="5">
                      <div class="empty-state-modern">
                        <div class="empty-state-icon">
                          <i class="fas fa-calendar-times"></i>
                        </div>
                        <h4>Belum Ada Jadwal</h4>
                        <p>Belum ada jadwal ruangan untuk hari ini</p>
                      </div>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($jadwalRuang as $j): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-door-open text-primary"></i>
                          </div>
                          <strong><?= esc($j['nama_room'] ?? '-') ?></strong>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($j['tanggal_mulai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($j['tanggal_mulai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($j['tanggal_selesai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($j['tanggal_selesai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <span class="status-badge <?= esc($j['status']) ?>">
                          <?php if (strtolower($j['status']) === 'proses'): ?>
                            <i class="fas fa-clock"></i>
                          <?php elseif (strtolower($j['status']) === 'diterima'): ?>
                            <i class="fas fa-check-circle"></i>
                          <?php elseif (strtolower($j['status']) === 'ditolak'): ?>
                            <i class="fas fa-times-circle"></i>
                          <?php else: ?>
                            <i class="fas fa-flag-checkered"></i>
                          <?php endif; ?>
                          <?= esc(ucfirst($j['status'] ?? '-')) ?>
                        </span>
                      </td>
                      <td>
                        <span class="text-muted">
                          <i class="fas fa-info-circle me-1"></i>
                          <?= esc($j['keterangan']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif ($user['role'] === 'peminjam'): ?>
        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2;">
              <div class="stat-icon-box">
                <i class="fas fa-file-alt"></i>
              </div>
              <div class="stat-number"><?= count($myPeminjaman) ?></div>
              <div class="stat-label">Total Pengajuan</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-list"></i>
                Semua Status
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #f59e0b; --gradient-to: #d97706;">
              <div class="stat-icon-box">
                <i class="fas fa-hourglass-half"></i>
              </div>
              <div class="stat-number">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'proses')) ?>
              </div>
              <div class="stat-label">Menunggu Approval</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-spinner"></i>
                Proses
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #10b981; --gradient-to: #059669;">
              <div class="stat-icon-box">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="stat-number">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'diterima')) ?>
              </div>
              <div class="stat-label">Disetujui</div>
              <span class="stat-trend trend-up">
                <i class="fas fa-thumbs-up"></i>
                Approved
              </span>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stat-card-modern" style="--gradient-from: #ef4444; --gradient-to: #dc2626;">
              <div class="stat-icon-box">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="stat-number">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'ditolak')) ?>
              </div>
              <div class="stat-label">Ditolak</div>
              <span class="stat-trend trend-down">
                <i class="fas fa-ban"></i>
                Rejected
              </span>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="action-card-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2;">
              <div class="action-icon-box" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15)); color: #667eea;">
                <i class="fas fa-plus-circle"></i>
              </div>
              <h5 class="fw-bold mb-2">Ajukan Peminjaman Baru</h5>
              <p class="text-muted mb-4">Buat pengajuan peminjaman ruangan baru</p>
              <a href="<?= base_url('peminjaman/ajukan') ?>" class="action-btn-modern">
                <i class="fas fa-paper-plane"></i>
                Ajukan Sekarang
              </a>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="action-card-modern" style="--gradient-from: #3b82f6; --gradient-to: #2563eb;">
              <div class="action-icon-box" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.15)); color: #3b82f6;">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <h5 class="fw-bold mb-2">Lihat Jadwal Ruangan</h5>
              <p class="text-muted mb-4">Cek ketersediaan ruangan</p>
              <a href="<?= base_url('jadwal/index') ?>" class="action-btn-modern">
                <i class="fas fa-search"></i>
                Lihat Jadwal Lengkap
              </a>
            </div>
          </div>
        </div>

        <!-- Pengajuan Peminjaman Table -->
        <div class="table-card-modern">
          <div class="table-header-modern">
            <h5 class="table-title">
              <i class="fas fa-list-alt"></i>
              Pengajuan Peminjaman Saya
            </h5>
            <span class="count-badge">
              <i class="fas fa-list-ul me-1"></i>
              <?= count($myPeminjaman) ?> Pengajuan
            </span>
          </div>
          <div class="table-responsive">
            <table class="modern-table">
              <thead>
                <tr>
                  <th><i class="fas fa-door-open me-2"></i>Ruangan</th>
                  <th><i class="fas fa-calendar-alt me-2"></i>Waktu Mulai</th>
                  <th><i class="fas fa-calendar-check me-2"></i>Waktu Selesai</th>
                  <th><i class="fas fa-info-circle me-2"></i>Status</th>
                  <th><i class="fas fa-comment-dots me-2"></i>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($myPeminjaman)): ?>
                  <tr>
                    <td colspan="5">
                      <div class="empty-state-modern">
                        <div class="empty-state-icon">
                          <i class="fas fa-folder-open"></i>
                        </div>
                        <h4>Belum Ada Pengajuan</h4>
                        <p class="mb-4">Anda belum memiliki pengajuan peminjaman ruangan</p>
                        <a href="<?= base_url('peminjaman/ajukan') ?>" class="action-btn-modern" style="--gradient-from: #667eea; --gradient-to: #764ba2; display: inline-flex;">
                          <i class="fas fa-plus-circle"></i>
                          Ajukan Peminjaman Sekarang
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($myPeminjaman as $p): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-door-open text-primary"></i>
                          </div>
                          <strong><?= esc($p['nama_room']) ?></strong>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($p['tanggal_mulai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($p['tanggal_mulai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="fw-semibold"><?= esc(date('d M Y', strtotime($p['tanggal_selesai']))) ?></div>
                          <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= esc(date('H:i', strtotime($p['tanggal_selesai']))) ?>
                          </small>
                        </div>
                      </td>
                      <td>
                        <span class="status-badge <?= esc($p['status']) ?>">
                          <?php if (strtolower($p['status']) === 'proses'): ?>
                            <i class="fas fa-clock"></i>
                          <?php elseif (strtolower($p['status']) === 'diterima'): ?>
                            <i class="fas fa-check-circle"></i>
                          <?php elseif (strtolower($p['status']) === 'ditolak'): ?>
                            <i class="fas fa-times-circle"></i>
                          <?php else: ?>
                            <i class="fas fa-flag-checkered"></i>
                          <?php endif; ?>
                          <?= esc(ucfirst($p['status'])) ?>
                        </span>
                      </td>
                      <td>
                        <span class="text-muted">
                          <i class="fas fa-info-circle me-1"></i>
                          <?= esc($p['keterangan']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  <?php if ($user['role'] === 'administrator'): ?>
  const gradientBar = (ctx) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
    gradient.addColorStop(1, 'rgba(56, 189, 248, 0.4)');
    return gradient;
  };

  const ctx1 = document.getElementById('chartPeminjaman').getContext('2d');
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: <?= $bulanData ?? '[]' ?>,
      datasets: [{
        label: 'Jumlah Peminjaman',
        data: <?= $jumlahData ?? '[]' ?>,
        backgroundColor: gradientBar(ctx1),
        borderRadius: 10,
        borderSkipped: false
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#4B5563', font: { weight: 'bold' } } },
        y: { beginAtZero: true, ticks: { color: '#4B5563' } }
      }
    }
  });

  const ctx2 = document.getElementById('chartStatus');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: <?= $statusLabels ?? '[]' ?>,
      datasets: [{
        data: <?= $statusCounts ?? '[]' ?>,
        backgroundColor: [
          'rgba(99, 102, 241, 0.8)',
          'rgba(34, 197, 94, 0.7)',
          'rgba(249, 115, 22, 0.7)',
          'rgba(239, 68, 68, 0.7)'
        ],
        borderColor: 'rgba(255, 255, 255, 0.6)',
        borderWidth: 2
      }]
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: '#4B5563', font: { weight: '500' } }
        }
      },
      cutout: '70%'
    }
  });
  <?php endif; ?>
  </script>
  <!-- 🚫 Cegah tombol Back -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Simpan posisi state history di dashboard
  history.pushState(null, "", location.href);

  // Saat user klik tombol back
  window.addEventListener("popstate", function () {
    // Tetap di dashboard aja
    history.pushState(null, "", location.href);
    // Reload biar kesannya "nggak bisa mundur"
    location.reload();
  });
});
</script>
</body>
</html>
