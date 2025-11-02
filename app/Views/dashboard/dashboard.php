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

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h4 class="fw-bold text-primary mb-0">🏫 Sistem Peminjaman</h4>
    </div>
    <nav class="sidebar-menu mt-4">
      <a href="<?= base_url('/') ?>" class="sidebar-link">🏠 Home</a>

      <?php if($user['role'] === 'administrator'): ?>
    <a href="<?= base_url('administrator/users/index') ?>" class="sidebar-link">👥 Manajemen User</a>
    <a href="<?= base_url('ruang/index') ?>" class="sidebar-link">🏫 Manajemen Ruang</a>
    <a href="<?= base_url('laporan') ?>" class="sidebar-link">📄 Generate Laporan</a>
    <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
    <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link">📋 Daftar Peminjaman</a>

      <?php elseif($user['role'] === 'petugas'): ?>
    <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link">📋 Daftar Peminjaman</a>
    <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
    <a href="<?= base_url('laporan') ?>" class="sidebar-link">📄 Generate Laporan</a>

      <?php elseif($user['role'] === 'peminjam'): ?>
    <a href="<?= base_url('peminjaman/ajukan') ?>" class="sidebar-link">📝 Pengajuan Peminjaman</a>
      <?php endif; ?>

      <a href="<?= base_url('jadwal/index') ?>" class="sidebar-link">📅 Jadwal Ruang</a>
      <!-- 🔹 Tambahan menu Profile -->
        <a href="<?= base_url('profile') ?>" 
           class="sidebar-link <?= service('uri')->getSegment(1) === 'profile' ? 'active' : '' ?>">👤 Profile</a>
      <a href="<?= base_url('kontak') ?>" class="sidebar-link text-danger fw-semibold">📞 Kontak Petugas</a>
    </nav>

    <?php if($user): ?>
    <div class="sidebar-footer mt-auto pt-4 text-center">
        <!-- 🔹 Tambahkan Foto Profil di sini -->
        <div class="profile-img-container mb-2">
            <img src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
                 alt="Foto Profil" 
                 class="sidebar-profile-img"
                 onerror="this.src='<?= base_url('images/profile/default.jpeg') ?>'">
        </div>

        <div class="fw-semibold text-dark small mb-1"><?= esc($user['username']) ?></div>
        <div class="text-muted small mb-2">(<?= esc($user['role']) ?>)</div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger w-100 btn-sm">Logout</a>
    </div>
    <?php endif; ?>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <nav class="navbar navbar-glass shadow-sm mb-4 px-4">
      <h3 class="fw-bold text-primary m-0">📊 Dashboard</h3>
    </nav>

    <div class="container-fluid">
      <h4 class="fw-bold mb-4 text-secondary">Selamat datang, <?= esc($user['username']) ?> 👋</h4>

      <?php if($user['role'] === 'administrator'): ?>
        <div class="row g-3 mb-4">
          <div class="col-md-4"><div class="stat-box bg-gradient-primary">👤 Total Users: <?= esc($totalUsers) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-success">🏢 Total Ruang: <?= esc($totalRuang) ?></div></div>
          <div class="col-md-4"><div class="stat-box bg-gradient-warning text-dark">📘 Total Peminjaman: <?= esc($totalPeminjaman) ?></div></div>
        </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
