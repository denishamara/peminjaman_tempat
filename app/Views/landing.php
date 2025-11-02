<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartRoom | Sistem Peminjaman Ruang</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #0066ff;
      --secondary-color: #6610f2;
      --bg-dark: #0f172a;
      --text-light: #e2e8f0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-light);
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background: rgba(15, 23, 42, 0.85);
      backdrop-filter: blur(12px);
      transition: background 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(15, 23, 42, 0.95);
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 700;
      font-size: 1.3rem;
    }

    .nav-link {
      color: #e2e8f0 !important;
      font-weight: 500;
      margin-left: 15px;
    }

    .nav-link:hover {
      color: var(--primary-color) !important;
    }

    /* Hero Section */
    .hero {
      height: 100vh;
      background: radial-gradient(circle at top left, #0a58ca, #0f172a);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      color: #cbd5e1;
    }

    /* Button styles */
    .btn-glow {
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
      border: none;
      color: #fff;
      padding: 0.75rem 2rem;
      border-radius: 50px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(102, 16, 242, 0.4);
    }

    .btn-glow:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(102, 16, 242, 0.8);
    }

    section {
      padding: 5rem 0;
    }

    .feature-icon {
      font-size: 2rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    footer {
      background: #0b1120;
      padding: 2rem 0;
      text-align: center;
      color: #94a3b8;
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
          <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero" id="home">
    <h1>Selamat Datang di <span class="text-primary">SmartRoom</span></h1>
    <p>Kelola peminjaman ruang dengan mudah, cepat, dan efisien — kapan saja dan di mana saja.</p>
    <div class="mt-4">
      <a href="<?= base_url('jadwal/public') ?>" class="btn btn-glow me-3">
        <i class="bi bi-calendar-event"></i> Lihat Jadwal
      </a>
      <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-light rounded-pill px-4">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </a>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="bg-light text-dark">
    <div class="container text-center">
      <h2 class="fw-bold mb-5">Kenapa Memilih SmartRoom?</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="p-4 border rounded-4 bg-white shadow-sm h-100">
            <i class="bi bi-calendar-check feature-icon"></i>
            <h5 class="fw-semibold">Manajemen Jadwal</h5>
            <p>Mengelola jadwal pemakaian ruang secara otomatis dan real-time.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 border rounded-4 bg-white shadow-sm h-100">
            <i class="bi bi-person-badge feature-icon"></i>
            <h5 class="fw-semibold">Akses Pengguna</h5>
            <p>Setiap pengguna memiliki peran berbeda untuk keamanan dan keteraturan.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 border rounded-4 bg-white shadow-sm h-100">
            <i class="bi bi-graph-up feature-icon"></i>
            <h5 class="fw-semibold">Statistik Peminjaman</h5>
            <p>Pantau data ruang yang sering digunakan melalui grafik dan laporan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About -->
  <section id="about">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Tentang SmartRoom</h2>
      <p class="mx-auto" style="max-width: 700px;">
        SmartRoom adalah sistem peminjaman ruang berbasis web yang dikembangkan untuk mendukung efisiensi 
        dalam pengelolaan fasilitas kampus atau kantor. Dengan tampilan modern dan fitur lengkap, 
        pengguna dapat melakukan peminjaman ruang dengan mudah dan cepat.
      </p>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>© <?= date('Y') ?> SmartRoom — Sistem Peminjaman Ruang. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>
</body>
</html>
