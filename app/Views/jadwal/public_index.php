<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Reguler & Booking | SmartRoom</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #0066ff;
      --bg-dark: #0f172a;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f1f5f9;
      color: #1e293b;
    }

    /* Navbar gaya landing */
    .navbar {
      background: rgba(15, 23, 42, 0.85);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(15, 23, 42, 0.95);
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 700;
    }

    .nav-link {
      color: #e2e8f0 !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: var(--primary-color) !important;
    }

    /* Konten utama */
    .main-content {
      padding-top: 100px;
      padding-bottom: 60px;
      padding-left: 1.5rem;
      padding-right: 1.5rem;
      max-width: 1100px;
      margin: 0 auto;
    }

    .table-responsive {
      border-radius: 12px;
      overflow-x: auto;
      padding: 0.5rem 0.5rem;
      background: #ffffff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table thead {
      background-color: var(--primary-color);
      color: #fff;
    }

    .filter-btn.active {
      background-color: var(--primary-color) !important;
      color: white !important;
    }

    footer {
      text-align: center;
      padding: 20px 0;
      color: #64748b;
      font-size: 0.9rem;
    }

    /* Responsif tambahan */
    @media (max-width: 768px) {
      .main-content {
        padding-left: 1rem;
        padding-right: 1rem;
      }
      h3 { font-size: 1.2rem; }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('/') ?>">SmartRoom</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten utama -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <h3 class="fw-bold text-primary mb-0">📅 Jadwal Reguler & Booking</h3>
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
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="text-center">
          <tr>
            <th>Ruangan</th>
            <th>Nama Kegiatan</th>
            <th>Peminjam</th>
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
              ?>
              <tr class="<?= esc($rowClass) ?>">
                <td><?= esc($j['nama_ruang'] ?? '-') ?></td>
                <td><?= esc($j['nama_kegiatan'] ?? '-') ?></td>
                <td><?= esc($j['peminjam'] ?? '-') ?></td>
                <td><?= esc($j['tanggal'] ?? '-') ?></td>
                <td><?= esc($j['jam_mulai'] ?? '-') ?></td>
                <td><?= esc($j['jam_selesai'] ?? '-') ?></td>
                <td class="text-center text-capitalize fw-semibold"><?= esc($j['status'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-3">Tidak ada jadwal ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    © <?= date('Y') ?> SmartRoom — Sistem Peminjaman Ruang.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // efek navbar scroll
    window.addEventListener('scroll', () => {
      document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>
</body>
</html>
