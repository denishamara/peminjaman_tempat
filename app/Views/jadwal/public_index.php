<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Reguler & Booking | SmartRoom</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #0d6efd;
      --secondary: #0a58ca;
      --dark: #0f172a;
      --light: #f8fafc;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
      color: #1e293b;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      background: rgba(15, 23, 42, 0.95) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(15, 23, 42, 1) !important;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand i {
      color: var(--primary);
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      padding: 0.5rem 1rem !important;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 80%;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--primary) !important;
    }

    /* Main Content */
    .main-content {
      padding-top: 100px;
      padding-bottom: 60px;
      padding-left: 1.5rem;
      padding-right: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Page Header */
    .page-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 40px rgba(13, 110, 253, 0.2);
      color: #fff;
    }

    .page-header h3 {
      font-weight: 700;
      margin-bottom: 0.5rem;
      font-size: 2rem;
    }

    .page-header p {
      margin-bottom: 0;
      opacity: 0.95;
      font-size: 1.1rem;
    }

    /* Filter Buttons */
    .filter-section {
      background: #fff;
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .filter-btn {
      border: 2px solid var(--primary);
      color: var(--primary);
      background: transparent;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .filter-btn:hover {
      background: var(--primary);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .filter-btn.active {
      background: var(--primary) !important;
      color: #fff !important;
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
    }

    .btn-calendar {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
      border: none;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-calendar:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
      color: #fff;
    }

    /* Table Container */
    .table-container {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .table-responsive {
      padding: 0;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: #fff;
    }

    .table thead th {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      padding: 1rem;
      border: none;
    }

    .table tbody td {
      padding: 1rem;
      vertical-align: middle;
      border-color: #e2e8f0;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(13, 110, 253, 0.05);
      transform: scale(1.01);
    }

    .table-primary {
      background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .table-warning {
      background-color: rgba(255, 193, 7, 0.15) !important;
    }

    .badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.85rem;
    }

    .badge-reguler {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: #fff;
    }

    .badge-booking {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
      color: #fff;
    }

    /* Footer */
    footer {
      background: var(--dark);
      color: rgba(255, 255, 255, 0.8);
      text-align: center;
      padding: 2rem 0;
      font-size: 0.95rem;
    }

    footer i {
      color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .main-content {
        padding: 80px 1rem 40px;
      }

      .page-header {
        padding: 1.5rem;
      }

      .page-header h3 {
        font-size: 1.5rem;
      }

      .page-header p {
        font-size: 0.95rem;
      }

      .filter-section {
        flex-direction: column;
        align-items: stretch;
      }

      .btn-group {
        width: 100%;
      }

      .filter-btn {
        flex: 1;
        text-align: center;
      }

      .btn-calendar {
        width: 100%;
        justify-content: center;
      }

      .table {
        font-size: 0.85rem;
      }

      .table thead th,
      .table tbody td {
        padding: 0.75rem 0.5rem;
      }
    }

    @media (max-width: 576px) {
      .page-header h3 {
        font-size: 1.3rem;
      }

      .table {
        font-size: 0.8rem;
      }

      .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('/') ?>">
        <i class="bi bi-building"></i>
        SmartRoom
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="bi bi-house-door me-1"></i>Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-calendar-check me-1"></i>Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
      <h3><i class="bi bi-calendar-event me-2"></i>Jadwal Reguler & Booking</h3>
      <p>Lihat semua jadwal ruangan yang tersedia dan booking yang telah dibuat</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="btn-group">
        <a href="?filter=all" class="filter-btn <?= ($filter == 'all') ? 'active' : '' ?>">
          <i class="bi bi-list-ul me-1"></i>Semua Jadwal
        </a>
        <a href="?filter=reguler" class="filter-btn <?= ($filter == 'reguler') ? 'active' : '' ?>">
          <i class="bi bi-calendar3 me-1"></i>Reguler
        </a>
        <a href="?filter=booking" class="filter-btn <?= ($filter == 'booking') ? 'active' : '' ?>">
          <i class="bi bi-bookmark-check me-1"></i>Booking
        </a>
      </div>
      <a href="<?= base_url('jadwal/kalender') ?>" class="btn-calendar">
        <i class="bi bi-calendar3"></i>
        Lihat Kalender
      </a>
    </div>

    <!-- Table -->
    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="text-center">
            <tr>
              <th><i class="bi bi-door-open me-1"></i>Ruangan</th>
              <th><i class="bi bi-info-circle me-1"></i>Kegiatan</th>
              <th><i class="bi bi-person me-1"></i>Peminjam</th>
              <th><i class="bi bi-calendar-date me-1"></i>Tanggal</th>
              <th><i class="bi bi-clock me-1"></i>Jam Mulai</th>
              <th><i class="bi bi-clock-fill me-1"></i>Jam Selesai</th>
              <th><i class="bi bi-tag me-1"></i>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($jadwal)): ?>
              <?php foreach ($jadwal as $j): ?>
                <?php
                  $status = strtolower($j['status'] ?? 'reguler');
                  $rowClass = $status === 'reguler' ? 'table-primary' : 'table-warning';
                  $badgeClass = $status === 'reguler' ? 'badge-reguler' : 'badge-booking';
                ?>
                <tr class="<?= esc($rowClass) ?>">
                  <td><strong><?= esc($j['nama_ruang'] ?? '-') ?></strong></td>
                  <td><?= esc($j['nama_kegiatan'] ?? '-') ?></td>
                  <td><?= esc($j['peminjam'] ?? '-') ?></td>
                  <td class="text-center"><?= esc($j['tanggal'] ?? '-') ?></td>
                  <td class="text-center"><strong><?= esc($j['jam_mulai'] ?? '-') ?></strong></td>
                  <td class="text-center"><strong><?= esc($j['jam_selesai'] ?? '-') ?></strong></td>
                  <td class="text-center">
                    <span class="badge <?= esc($badgeClass) ?> text-capitalize">
                      <?= esc($j['status'] ?? '-') ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity: 0.3;"></i>
                  <p class="mb-0">Tidak ada jadwal ditemukan.</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="mb-0">© <?= date('Y') ?> SmartRoom — Sistem Peminjaman Ruang. Made with <i class="bi bi-heart-fill"></i></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>
</body>
</html>
