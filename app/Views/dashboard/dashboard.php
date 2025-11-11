<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- Bootstrap & Custom Style -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

  <!-- Main Content -->
  <main class="main-content">
    <nav class="navbar navbar-glass shadow-sm mb-4 px-4">
      <h3 class="fw-bold text-primary m-0">📊 Dashboard</h3>
    </nav>

    <div class="container-fluid">
      <h4 class="fw-bold mb-4 text-secondary">Selamat datang, <?= esc($user['username']) ?> 👋</h4>

      <?php if($user['role'] === 'administrator'): ?>
        <!-- Statistik Boxes -->
        <div class="row g-3 mb-4">
          <div class="col-md-4"><div class="stat-box bg-gradient-primary">👤 Total Users: <?= esc($totalUsers) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-success">🏢 Total Ruang: <?= esc($totalRuang) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-warning text-dark">📘 Total Peminjaman: <?= esc($totalPeminjaman) ?></div></div>
        </div>

        <!-- 📊 Statistik Diagram -->
<div class="row mb-4">
  <div class="col-lg-7">
    <div class="glass-card p-4 shadow-sm">
      <h5 class="fw-bold text-primary mb-3">📈 Jumlah Peminjaman per Bulan</h5>
      <canvas id="chartPeminjaman" height="140"></canvas>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="glass-card p-4 shadow-sm">
      <h5 class="fw-bold text-primary mb-3">📊 Distribusi Status Peminjaman</h5>
      <canvas id="chartStatus" height="140"></canvas>
    </div>
  </div>
</div>

        <!-- Peminjaman Terbaru -->
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
                <?php foreach($recentPeminjaman as $p): ?>
                <tr>
                  <td><?= esc($p['username']) ?></td>
                  <td><?= esc($p['nama_room']) ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_mulai']))) ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_selesai']))) ?></td>
                  <td><span class="status-badge <?= $p['status'] ?>"><?= esc(ucfirst($p['status'])) ?></span></td>
                  <td><?= esc($p['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif($user['role'] === 'petugas'): ?>
        <!-- Dashboard Petugas -->
        <div class="glass-card p-4">
          <div class="info-summary">
            <p><strong>Total Peminjaman Pending:</strong> <?= esc($totalPeminjamanPending) ?></p>
          </div>
          <h5 class="fw-bold mb-3 text-primary">📋 Jadwal Ruangan</h5>
          <div class="table-responsive">
            <table class="modern-table table-hover">
              <thead>
                <tr>
                  <th>Ruangan</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($jadwalRuang as $j): ?>
                <tr>
                  <td><?= esc($j['nama_room'] ?? '-') ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($j['tanggal_mulai']))) ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($j['tanggal_selesai']))) ?></td>
                  <td><span class="status-badge <?= $j['status'] ?>"><?= esc(ucfirst($j['status'] ?? '-')) ?></span></td>
                  <td><?= esc($j['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php elseif($user['role'] === 'peminjam'): ?>
        <!-- Dashboard Peminjam -->
        <div class="glass-card p-4">
          <h5 class="fw-bold mb-3 text-primary">📑 Pengajuan Peminjaman Saya</h5>
          <div class="table-responsive">
            <table class="modern-table table-hover">
              <thead>
                <tr>
                  <th>Ruang</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($myPeminjaman as $p): ?>
                <tr>
                  <td><?= esc($p['nama_room']) ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_mulai']))) ?></td>
                  <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_selesai']))) ?></td>
                  <td><span class="status-badge <?= $p['status'] ?>"><?= esc(ucfirst($p['status'])) ?></span></td>
                  <td><?= esc($p['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if($user['role'] === 'administrator'): ?>
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
        'rgba(99, 102, 241, 0.8)', // indigo
        'rgba(34, 197, 94, 0.7)',  // green
        'rgba(249, 115, 22, 0.7)', // orange
        'rgba(239, 68, 68, 0.7)'   // red
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
</body>
</html>
