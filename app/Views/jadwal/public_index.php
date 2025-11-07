<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Ruangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url('<?= base_url('images/bg.jpeg') ?>') no-repeat center center fixed;
      background-size: cover;
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
      color: #1e293b;
    }
    .navbar { font-weight: 600; }
    .main-content {
      max-width: 1100px;
      margin: 50px auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 2rem 2.5rem;
      backdrop-filter: blur(10px);
    }
    .filter-btn.active { background-color: #0d6efd !important; color: white !important; }
    table {
      border-radius: 10px;
      overflow: hidden;
      background-color: white;
    }
    th {
      background-color: #0d6efd !important;
      color: white !important;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    td { vertical-align: middle; }
    .table-primary { background-color: #dbeafe !important; }
    .table-warning { background-color: #fef9c3 !important; }
    .alert { border-radius: 10px; text-align: center; }
    @media (max-width: 768px) {
      .main-content { margin: 20px; padding: 1.5rem; }
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">🏫 SmartRoom</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ISI HALAMAN -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-primary">📅 Jadwal Reguler & Booking</h3>
      <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-primary">
        <i class="bi bi-calendar3"></i> Lihat Kalender
      </a>
    </div>

    <!-- Filter -->
    <div class="btn-group mb-3">
      <a href="?filter=all" class="btn btn-outline-primary filter-btn <?= ($filter == 'all') ? 'active' : '' ?>">Gabungan</a>
      <a href="?filter=reguler" class="btn btn-outline-primary filter-btn <?= ($filter == 'reguler') ? 'active' : '' ?>">Reguler</a>
      <a href="?filter=booking" class="btn btn-outline-primary filter-btn <?= ($filter == 'booking') ? 'active' : '' ?>">Booking</a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="text-center">
          <tr>
            <th>Ruangan</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
  <?php if (!empty($jadwal)): ?>
    <?php foreach ($jadwal as $j): ?>
      <?php
        $status = strtolower($j['status'] ?? 'reguler');
        $rowClass = $status === 'reguler' ? 'table-primary' : 'table-warning';

        // Ambil tanggal mulai & selesai
        $tglMulai   = $j['tanggal_mulai'] ?? $j['tgl_pinjam'] ?? $j['tgl_booking'] ?? null;
        $tglSelesai = $j['tanggal_selesai'] ?? null;

        // Format tanggal
        if ($tglMulai && $tglSelesai) {
          $hari = (date('Y-m-d', strtotime($tglMulai)) === date('Y-m-d', strtotime($tglSelesai)))
            ? date('d-m-Y', strtotime($tglMulai))
            : date('d-m-Y', strtotime($tglMulai)) . ' s.d. ' . date('d-m-Y', strtotime($tglSelesai));
        } elseif ($tglMulai) {
          $hari = date('d-m-Y', strtotime($tglMulai));
        } else {
          $hari = '-';
        }

        // Jam
        $jamMulai = $j['jam_mulai'] ?? (!empty($tglMulai) ? date('H:i', strtotime($tglMulai)) : '-');
        $jamSelesai = $j['jam_selesai'] ?? (!empty($tglSelesai) ? date('H:i', strtotime($tglSelesai)) : '-');
      ?>
      <tr class="<?= esc($rowClass) ?>">
        <td><?= esc($j['nama_ruang'] ?? '-') ?></td>
        <td><?= esc($j['nama_kegiatan'] ?? $j['nama_reguler'] ?? $j['keterangan'] ?? '-') ?></td>
        <td><?= esc($hari) ?></td>
        <td><?= esc($jamMulai) ?></td>
        <td><?= esc($jamSelesai) ?></td>
        <td class="text-center text-capitalize fw-semibold"><?= esc($j['status'] ?? '-') ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="6" class="text-center text-muted py-3">Tidak ada jadwal ditemukan.</td>
    </tr>
  <?php endif; ?>
</tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
