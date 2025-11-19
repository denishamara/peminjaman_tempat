<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartRoom | Sistem Peminjaman Ruang Terbaik</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #667eea;
      --secondary: #764ba2;
      --accent: #8b5cf6;
      --light-purple: #a78bfa;
      --dark-purple: #5b21b6;
      --dark: #0f172a;
      --light: #f8fafc;
    }

    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      scroll-behavior: smooth;
      background: var(--dark);
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: rgba(15, 23, 42, 0.95) !important;
      transition: all 0.3s ease;
      padding: 1rem 0;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .navbar.scrolled {
      background: rgba(15, 23, 42, 1) !important;
      padding: 0.5rem 0;
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 800;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: transform 0.3s ease;
      text-shadow: none;
    }

    .navbar-brand:hover {
      transform: scale(1.05);
    }

    .navbar-brand i {
      color: var(--accent);
      font-size: 1.8rem;
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500;
      margin: 0 0.8rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 80%;
    }

    .nav-link:hover {
      color: var(--accent) !important;
    }

    /* ===== HERO SECTION ===== */
    .hero {
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5b21b6 100%);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding-top: 80px;
    }

    .hero::before {
      content: '';
      position: absolute;
      width: 200%;
      height: 200%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      animation: float 30s linear infinite;
      opacity: 0.3;
    }

    @keyframes float {
      0% { transform: translate(0, 0); }
      100% { transform: translate(-50%, -50%); }
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: #fff;
      padding: 4rem 2rem 2rem;
      animation: fadeInUp 1s ease-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-content h1 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-content .gradient-text {
      background: linear-gradient(90deg, #a78bfa, #c4b5fd, #e9d5ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-content p {
      font-size: 1.3rem;
      max-width: 700px;
      margin: 0 auto 2.5rem;
      color: rgba(255, 255, 255, 0.9);
      line-height: 1.8;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-buttons {
      display: flex;
      gap: 1.5rem;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 0;
    }

    .btn-hero {
      padding: 1rem 2.5rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-primary-hero {
      background: #fff;
      color: var(--primary);
    }

    .btn-primary-hero:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
      color: var(--primary);
    }

    .btn-outline-hero {
      background: transparent;
      color: #fff;
      border: 2px solid #fff;
    }

    .btn-outline-hero:hover {
      background: #fff;
      color: var(--primary);
      transform: translateY(-3px);
    }

    /* ===== FEATURES SECTION ===== */
    .features {
      padding: 6rem 0;
      background: linear-gradient(to bottom, #fff, #f8fafc);
    }

    .section-title {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-title h2 {
      font-size: 2.8rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 1rem;
    }

    .section-title p {
      font-size: 1.2rem;
      color: #64748b;
      max-width: 600px;
      margin: 0 auto;
    }

    .feature-card {
      background: #fff;
      border-radius: 20px;
      padding: 2.5rem;
      height: 100%;
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
      border-color: var(--primary);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      font-size: 2rem;
      color: #fff;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .feature-card h5 {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 1rem;
    }

    .feature-card p {
      color: #64748b;
      line-height: 1.7;
      margin: 0;
    }

    /* ===== HOW IT WORKS ===== */
    .how-it-works {
      padding: 6rem 0;
      background: var(--dark);
      color: #fff;
    }

    .step-item {
      text-align: center;
      padding: 2rem;
    }

    .step-number {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 800;
      margin: 0 auto 1.5rem;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
    }

    .step-item h5 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #fff;
    }

    .step-item p {
      color: rgba(255, 255, 255, 0.8);
      line-height: 1.7;
    }

    /* ===== CTA SECTION ===== */
    .cta {
      padding: 6rem 0;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5b21b6 100%);
      color: #fff;
      text-align: center;
    }

    .cta h2 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
    }

    .cta p {
      font-size: 1.2rem;
      margin-bottom: 2.5rem;
      opacity: 0.9;
    }

    /* ===== FOOTER ===== */
    footer {
      background: #0b1120;
      padding: 3rem 0 1.5rem;
      color: #94a3b8;
    }

    .footer-content {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .footer-section h5 {
      color: #fff;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .footer-section ul {
      list-style: none;
      padding: 0;
    }

    .footer-section ul li {
      margin-bottom: 0.5rem;
    }

    .footer-section a {
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer-section a:hover {
      color: var(--accent);
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 1.5rem;
      text-align: center;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      justify-content: center;
      margin-top: 1rem;
    }

    .social-links a {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      transition: all 0.3s ease;
    }

    .social-links a:hover {
      background: linear-gradient(135deg, #667eea, #764ba2);
      transform: translateY(-3px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
      .hero-content h1 {
        font-size: 3rem;
      }

      .hero-content p {
        font-size: 1.2rem;
        padding: 0 1rem;
      }

      .feature-card {
        margin-bottom: 1.5rem;
      }

      .step-card {
        margin-bottom: 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 1.3rem;
      }

      .navbar-brand i {
        font-size: 1.5rem;
      }

      .hero {
        padding-top: 100px;
        min-height: auto;
        padding-bottom: 3rem;
      }

      .hero-content h1 {
        font-size: 2.2rem;
        margin-bottom: 1rem;
      }

      .hero-content p {
        font-size: 1rem;
        padding: 0 0.5rem;
        margin-bottom: 2rem;
      }

      .hero-buttons {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
      }

      .btn-hero {
        width: 100%;
        max-width: 300px;
        justify-content: center;
        padding: 0.9rem 2rem;
        font-size: 1rem;
      }

      .section-title h2 {
        font-size: 1.8rem;
      }

      .section-title p {
        font-size: 1rem;
      }

      .feature-card {
        padding: 2rem 1.5rem;
      }

      .feature-icon {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
      }

      .feature-card h3 {
        font-size: 1.3rem;
      }

      .step-card {
        padding: 2rem 1.5rem;
      }

      .step-number {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
      }

      .cta h2 {
        font-size: 2rem;
        padding: 0 1rem;
      }

      .cta p {
        font-size: 1rem;
        padding: 0 1rem;
      }

      .footer-content {
        flex-direction: column;
        gap: 2rem;
      }

      .footer-section {
        text-align: center;
      }
    }

    @media (max-width: 576px) {
      .hero {
        min-height: 100vh;
        padding-top: 60px;
      }

      .hero-content {
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: calc(100vh - 60px);
      }

      .hero-content h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
      }

      .hero-content p {
        font-size: 1rem;
        margin-bottom: 2rem;
      }

      .hero-buttons {
        margin-bottom: 0;
      }

      .section-title h2 {
        font-size: 1.8rem;
      }

      .btn-hero {
        padding: 0.9rem 1.8rem;
        font-size: 1rem;
      }

      .feature-card,
      .step-card {
        padding: 1.5rem 1rem;
      }

      .cta {
        padding: 3rem 0;
      }

      .cta h2 {
        font-size: 1.6rem;
      }

      .social-links a {
        width: 35px;
        height: 35px;
        font-size: 1rem;
      }
    }

    @media (max-width: 400px) {
      .hero {
        padding-top: 56px;
      }

      .hero-content {
        padding: 1.5rem 1rem;
        min-height: calc(100vh - 56px);
      }

      .hero-content h1 {
        font-size: 1.8rem;
        margin-bottom: 0.8rem;
      }

      .hero-content p {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
      }

      .navbar-brand {
        font-size: 1.2rem;
      }

      .navbar-brand i {
        font-size: 1.3rem;
      }

      .btn-hero {
        max-width: 100%;
        padding: 0.8rem 1.5rem;
        font-size: 0.95rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
          <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
          <li class="nav-item"><a class="nav-link" href="#how-it-works">Cara Kerja</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('jadwal/public') ?>">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="home">
    <div class="hero-content">
      <h1>
        Kelola Ruangan dengan<br>
        <span class="gradient-text">SmartRoom</span>
      </h1>
      <p>
        Platform peminjaman ruang terbaik untuk kampus dan kantor modern. 
        Mudah, cepat, dan efisien — kelola semua kebutuhan ruangan Anda dalam satu sistem.
      </p>
      
      <div class="hero-buttons">
        <a href="<?= base_url('auth/register') ?>" class="btn-hero btn-primary-hero">
          <i class="bi bi-rocket-takeoff"></i>
          Mulai Sekarang
        </a>
        <a href="<?= base_url('jadwal/public') ?>" class="btn-hero btn-outline-hero">
          <i class="bi bi-calendar-event"></i>
          Lihat Jadwal
        </a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container">
      <div class="section-title">
        <h2>Fitur Unggulan SmartRoom</h2>
        <p>Kenapa memilih SmartRoom untuk mengelola peminjaman ruang Anda?</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-calendar-check"></i>
            </div>
            <h5>Manajemen Jadwal Real-Time</h5>
            <p>Pantau ketersediaan ruang secara real-time dengan kalender interaktif yang mudah digunakan dan update otomatis.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <h5>Sistem Role & Keamanan</h5>
            <p>Akses berbasis peran untuk administrator, petugas, dan peminjam dengan enkripsi data yang aman.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h5>Statistik & Laporan</h5>
            <p>Dapatkan insight lengkap dengan grafik statistik dan generate laporan PDF untuk analisis peminjaman.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <h5>Proses Cepat & Mudah</h5>
            <p>Ajukan peminjaman hanya dalam beberapa klik tanpa perlu formulir manual yang rumit.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-headset"></i>
            </div>
            <h5>Bantuan Cepat</h5>
            <p>Butuh bantuan segera? Hubungi petugas kami untuk pertanyaan urgent terkait peminjaman.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-phone"></i>
            </div>
            <h5>Mobile Responsive</h5>
            <p>Akses dari perangkat apapun — desktop, tablet, atau smartphone dengan tampilan yang optimal.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works" id="how-it-works">
    <div class="container">
      <div class="section-title">
        <h2 style="color: #fff;">Cara Kerja SmartRoom</h2>
        <p style="color: rgba(255,255,255,0.8);">Mudah dan cepat dalam 3 langkah sederhana</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="step-item">
            <div class="step-number">1</div>
            <h5>Daftar & Login</h5>
            <p>Buat akun gratis dan login ke sistem SmartRoom menggunakan username dan password Anda.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-item">
            <div class="step-number">2</div>
            <h5>Pilih Ruang & Jadwal</h5>
            <p>Lihat ketersediaan ruang, pilih waktu yang diinginkan, dan ajukan peminjaman dengan mudah.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-item">
            <div class="step-number">3</div>
            <h5>Konfirmasi & Gunakan</h5>
            <p>Tunggu approval dari petugas, dan ruang siap digunakan sesuai jadwal yang telah disetujui!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="container">
      <h2>Siap Memulai dengan SmartRoom?</h2>
      <p>Bergabunglah dengan ratusan pengguna yang sudah merasakan kemudahan mengelola peminjaman ruang</p>
      <a href="<?= base_url('auth/register') ?>" class="btn-hero btn-primary-hero">
        <i class="bi bi-person-plus"></i>
        Daftar Gratis Sekarang
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h5><i class="bi bi-building"></i> SmartRoom</h5>
          <p>Sistem peminjaman ruang berbasis web yang modern, efisien, dan mudah digunakan.</p>
          <div class="social-links">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="footer-section">
          <h5>Menu Cepat</h5>
          <ul>
            <li><a href="#home">Beranda</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="#how-it-works">Cara Kerja</a></li>
            <li><a href="<?= base_url('jadwal/public') ?>">Jadwal</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h5>Akun</h5>
          <ul>
            <li><a href="<?= base_url('auth/login') ?>">Login</a></li>
            <li><a href="<?= base_url('auth/register') ?>">Daftar</a></li>
            <li><a href="<?= base_url('kontak') ?>">Kontak</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h5>Kontak</h5>
          <ul>
            <li><i class="bi bi-envelope"></i> info@smartroom.id</li>
            <li><i class="bi bi-phone"></i> +62 812-3456-7890</li>
            <li><i class="bi bi-geo-alt"></i> Indonesia</li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>© <?= date('Y') ?> SmartRoom. All Rights Reserved. Made with <i class="bi bi-heart-fill" style="color: #a78bfa;"></i></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Animate on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
        }
      });
    }, observerOptions);

    document.querySelectorAll('.feature-card, .step-item').forEach(el => {
      observer.observe(el);
    });
  </script>
</body>
</html>