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

  <!-- Bootstrap & Custom Style -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <style>
  /* Samakan tinggi card chart */
  .chart-card {
    min-height: 400px; 
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  /* Samakan ukuran canvas di semua chart */
  .chart-canvas {
    height: 300px !important;
    max-height: 300px !important;
  }
</style>
</head>

<body class="modern-dashboard">
  <?= view('layouts/sidebar') ?>

  <!-- Main Content -->
  <main class="main-content">
    <nav class="navbar navbar-glass shadow-sm mb-4 px-4">
      <h3 class="fw-bold text-primary m-0">📊 Dashboard</h3>
    </nav>

    <div class="container-fluid">
      <h4 class="fw-bold mb-4 text-secondary">
        Selamat datang, <?= esc($user['username']) ?> 👋
      </h4>

      <?php if ($user['role'] === 'administrator'): ?>
        <div class="row g-3 mb-4">
          <div class="col-md-4"><div class="stat-box bg-gradient-primary">👤 Total Users: <?= esc($totalUsers) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-success">🏢 Total Ruang: <?= esc($totalRuang) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-warning text-dark">📘 Total Peminjaman: <?= esc($totalPeminjaman) ?></div></div>
        </div>

        <!-- 📊 Statistik Diagram -->
        <div class="row mb-4">
          <div class="col-lg-7">
            <div class="glass-card p-4 shadow-sm chart-card">
              <h5 class="fw-bold text-primary mb-3">📈 Jumlah Peminjaman per Bulan</h5>
              <canvas id="chartPeminjaman" class="chart-canvas"></canvas>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="glass-card p-4 shadow-sm chart-card">
              <h5 class="fw-bold text-primary mb-3">📊 Distribusi Status Peminjaman</h5>
              <canvas id="chartStatus" class="chart-canvas"></canvas>
            </div>
          </div>
        </div>

        <!-- Tabel Peminjaman Terbaru -->
        <div class="glass-card p-4">
          <h5 class="fw-bold mb-3">📅 Peminjaman Terbaru</h5>
          <div class="table-responsive">
            <table class="modern-table table-hover">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Ruang</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recentPeminjaman as $p): ?>
                  <tr>
                    <td><?= esc($p['username']) ?></td>
                    <td><?= esc($p['nama_room']) ?></td>
                    <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_mulai']))) ?></td>
                    <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_selesai']))) ?></td>
                    <td><span class="status-badge <?= esc($p['status']) ?>"><?= esc(ucfirst($p['status'])) ?></span></td>
                    <td><?= esc($p['keterangan']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif ($user['role'] === 'petugas'): ?>
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-clock text-warning" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-warning mb-1"><?= esc($totalPeminjamanPending) ?></h3>
              <p class="text-muted mb-0 small">Peminjaman Pending</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-calendar-check text-success" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-success mb-1"><?= count($jadwalRuang) ?></h3>
              <p class="text-muted mb-0 small">Total Jadwal</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-clipboard-list text-primary" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-primary mb-1">
                <?= count(array_filter($jadwalRuang, fn($j) => strtolower($j['status']) === 'diterima')) ?>
              </h3>
              <p class="text-muted mb-0 small">Disetujui</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-ban text-danger" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-danger mb-1">
                <?= count(array_filter($jadwalRuang, fn($j) => strtolower($j['status']) === 'ditolak')) ?>
              </h3>
              <p class="text-muted mb-0 small">Ditolak</p>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-tasks text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0">Kelola Peminjaman</h5>
                  <p class="text-muted small mb-0">Review dan approve peminjaman</p>
                </div>
              </div>
              <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="btn btn-primary w-100">
                <i class="fas fa-arrow-right me-2"></i>Lihat Daftar Peminjaman
              </a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-history text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0">Riwayat Peminjaman</h5>
                  <p class="text-muted small mb-0">Lihat history peminjaman selesai</p>
                </div>
              </div>
              <a href="<?= base_url('peminjaman/history') ?>" class="btn btn-success w-100">
                <i class="fas fa-arrow-right me-2"></i>Lihat Riwayat
              </a>
            </div>
          </div>
        </div>

        <!-- Jadwal Ruangan Table -->
        <div class="glass-card p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-primary">
              <i class="fas fa-calendar-alt me-2"></i>Jadwal Ruangan Hari Ini
            </h5>
            <span class="badge bg-primary"><?= count($jadwalRuang) ?> Jadwal</span>
          </div>
          <div class="table-responsive">
            <table class="modern-table table-hover">
              <thead>
                <tr>
                  <th><i class="fas fa-door-open me-2"></i>Ruangan</th>
                  <th><i class="fas fa-calendar me-2"></i>Tanggal Mulai</th>
                  <th><i class="fas fa-calendar-check me-2"></i>Tanggal Selesai</th>
                  <th><i class="fas fa-info-circle me-2"></i>Status</th>
                  <th><i class="fas fa-comment me-2"></i>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($jadwalRuang)): ?>
                  <tr>
                    <td colspan="5" class="text-center py-4">
                      <i class="fas fa-inbox text-muted mb-2" style="font-size: 3rem;"></i>
                      <p class="text-muted mb-0">Belum ada jadwal untuk hari ini</p>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($jadwalRuang as $j): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-door-open text-primary me-2"></i>
                          <strong><?= esc($j['nama_room'] ?? '-') ?></strong>
                        </div>
                      </td>
                      <td><?= esc(date('d M Y, H:i', strtotime($j['tanggal_mulai']))) ?></td>
                      <td><?= esc(date('d M Y, H:i', strtotime($j['tanggal_selesai']))) ?></td>
                      <td><span class="status-badge <?= esc($j['status']) ?>"><?= esc(ucfirst($j['status'] ?? '-')) ?></span></td>
                      <td><?= esc($j['keterangan']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif ($user['role'] === 'peminjam'): ?>
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-clipboard-list text-primary" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-primary mb-1"><?= count($myPeminjaman) ?></h3>
              <p class="text-muted mb-0 small">Total Pengajuan</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-clock text-warning" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-warning mb-1">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'proses')) ?>
              </h3>
              <p class="text-muted mb-0 small">Menunggu Approval</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-success mb-1">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'diterima')) ?>
              </h3>
              <p class="text-muted mb-0 small">Disetujui</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="glass-card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-times-circle text-danger" style="font-size: 2.5rem;"></i>
              </div>
              <h3 class="fw-bold text-danger mb-1">
                <?= count(array_filter($myPeminjaman, fn($p) => strtolower($p['status']) === 'ditolak')) ?>
              </h3>
              <p class="text-muted mb-0 small">Ditolak</p>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-plus-circle text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0">Ajukan Peminjaman Baru</h5>
                  <p class="text-muted small mb-0">Buat pengajuan peminjaman ruangan</p>
                </div>
              </div>
              <a href="<?= base_url('peminjaman/ajukan') ?>" class="btn btn-primary w-100">
                <i class="fas fa-arrow-right me-2"></i>Ajukan Sekarang
              </a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="glass-card p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                  <i class="fas fa-calendar-alt text-info" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-0">Lihat Jadwal Ruangan</h5>
                  <p class="text-muted small mb-0">Cek ketersediaan ruangan</p>
                </div>
              </div>
              <a href="<?= base_url('jadwal/index') ?>" class="btn btn-info w-100">
                <i class="fas fa-arrow-right me-2"></i>Lihat Jadwal
              </a>
            </div>
          </div>
        </div>

        <!-- Pengajuan Peminjaman Table -->
        <div class="glass-card p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-primary">
              <i class="fas fa-list-alt me-2"></i>Pengajuan Peminjaman Saya
            </h5>
            <span class="badge bg-primary"><?= count($myPeminjaman) ?> Pengajuan</span>
          </div>
          <div class="table-responsive">
            <table class="modern-table table-hover">
              <thead>
                <tr>
                  <th><i class="fas fa-door-open me-2"></i>Ruang</th>
                  <th><i class="fas fa-calendar me-2"></i>Tanggal Mulai</th>
                  <th><i class="fas fa-calendar-check me-2"></i>Tanggal Selesai</th>
                  <th><i class="fas fa-info-circle me-2"></i>Status</th>
                  <th><i class="fas fa-comment me-2"></i>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($myPeminjaman)): ?>
                  <tr>
                    <td colspan="5" class="text-center py-4">
                      <i class="fas fa-inbox text-muted mb-2" style="font-size: 3rem;"></i>
                      <p class="text-muted mb-3">Belum ada pengajuan peminjaman</p>
                      <a href="<?= base_url('peminjaman/ajukan') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman
                      </a>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($myPeminjaman as $p): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-door-open text-primary me-2"></i>
                          <strong><?= esc($p['nama_room']) ?></strong>
                        </div>
                      </td>
                      <td><?= esc(date('d M Y, H:i', strtotime($p['tanggal_mulai']))) ?></td>
                      <td><?= esc(date('d M Y, H:i', strtotime($p['tanggal_selesai']))) ?></td>
                      <td><span class="status-badge <?= esc($p['status']) ?>"><?= esc(ucfirst($p['status'])) ?></span></td>
                      <td><?= esc($p['keterangan']) ?></td>
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
