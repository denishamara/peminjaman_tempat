<?php
// Pastikan user dari session terbaca
$user = isset($user) ? $user : session()->get('user');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#60a5fa',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
            }
          }
        }
      }
    }
  </script>

  <style>
  /* =======================================================
     🌐 DASHBOARD STYLE (Sidebar + Layout + Responsif)
     ======================================================= */
  body {
    background-color: #f5f7fb;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
  }

  /* ====== SIDEBAR ====== */
  .sidebar {
    width: 250px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(16px);
    border-right: 1px solid rgba(0,0,0,0.05);
    padding: 1.8rem 1.2rem;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    box-shadow: 4px 0 15px rgba(0,0,0,0.05);
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
    transition: left 0.3s ease;
    z-index: 1000;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling di iOS */
  }

  /* Scrollbar (Chrome, Edge, Safari) */
  .sidebar::-webkit-scrollbar { width: 6px; }
  .sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
  }
  .sidebar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0, 0, 0, 0.3);
  }

  /* ====== SIDEBAR ISI ====== */
  .sidebar-header h4 {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 1.2rem;
    text-align: center;
  }

  .sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
  }

  .sidebar-link {
    color: #334155;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .sidebar-link:hover,
  .sidebar-link.active {
    background: rgba(13,110,253,0.12);
    color: #0d6efd;
    transform: translateX(6px);
  }

  /* ====== SIDEBAR FOOTER ====== */
  .sidebar-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid rgba(0,0,0,0.08);
    text-align: center;
  }

  /* Sidebar Profile Image */
  .profile-img-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .sidebar-profile-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 2px solid #0d6efd;
    object-fit: cover;
    background-color: #f8f9fa;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .sidebar-profile-img:hover {
    transform: scale(1.08);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  }

  /* ====== MAIN CONTENT (opsional untuk halaman utama) ====== */
  .main-content {
    margin-left: 260px;
    padding: 2rem;
    width: calc(100% - 260px);
    transition: all 0.3s ease;
  }

  /* ====== NAVBAR KECIL (untuk layar kecil) ====== */
  .navbar {
    height: 56px;
    z-index: 1100;
  }

  .menu-toggle {
    background: none;
    border: none;
    font-size: 1.8rem;
    color: #0d6efd;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s ease;
  }

  .menu-toggle:hover {
    color: #0b5ed7;
  }

  /* ====== RESPONSIVE ====== */
  @media (max-width: 992px) {
    .sidebar {
      left: -260px;
      position: fixed;
      top: 56px; /* biar gak ketimpa navbar kecil */
      height: calc(100vh - 56px);
      overflow-y: auto !important; /* Pastikan bisa scroll */
      overflow-x: hidden !important;
      -webkit-overflow-scrolling: touch; /* Smooth scroll iOS */
    }
    .sidebar.show { left: 0; }
    .main-content {
      margin-left: 0;
      width: 100%;
      padding: 1.5rem;
      margin-top: 60px; /* beri jarak dari navbar */
    }
  }

  @media (max-width: 576px) {
    .sidebar {
      width: 220px;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
    }
    .sidebar-link {
      font-size: 0.9rem;
      padding: 0.6rem 0.8rem;
    }
    .sidebar-profile-img {
      width: 60px;
      height: 60px;
    }
  }
  </style>
</head>

<body>
  <!-- Navbar kecil (hanya muncul di layar kecil) -->
  <nav class="navbar bg-white shadow-sm px-3 d-lg-none d-flex align-items-center fixed-top">
    <div class="d-flex align-items-center">
      <button class="menu-toggle me-2" onclick="toggleSidebar()">☰</button>
      <span class="fw-bold text-primary fs-5">Menu</span>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
        <h3 class="fw-bold text-primary mb-0" style="font-size: 1.5rem;">🏫 Sistem Peminjaman</h3>
    </div>

    <nav class="sidebar-menu mt-4">
        <a href="<?= base_url('dashboard') ?>" class="sidebar-link">🏠 Home</a>

        <?php if (isset($user) && $user['role'] === 'administrator'): ?>
            <a href="<?= base_url('administrator/users/index') ?>" class="sidebar-link">👥 Manajemen User</a>
            <a href="<?= base_url('ruang/index') ?>" class="sidebar-link">🏫 Manajemen Ruang</a>
            <a href="<?= base_url('laporan') ?>" class="sidebar-link">📄 Generate Laporan</a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link">📋 Daftar Peminjaman</a>

        <?php elseif (isset($user) && $user['role'] === 'petugas'): ?>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link">📋 Daftar Peminjaman</a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
            <a href="<?= base_url('laporan') ?>" class="sidebar-link">📄 Generate Laporan</a>

        <?php elseif (isset($user) && $user['role'] === 'peminjam'): ?>
            <a href="<?= base_url('ruang') ?>" class="sidebar-link">🏫 Daftar Ruang</a>
            <a href="<?= base_url('peminjaman/ajukan') ?>" class="sidebar-link">📝 Pengajuan Peminjaman</a>
        <?php endif; ?>

        <a href="<?= base_url('jadwal/index') ?>" class="sidebar-link">📅 Jadwal Ruang</a>

        <?php if ($user): ?>
            <a href="<?= base_url('profile') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(1) === 'profile' ? 'active' : '' ?>">👤 Profile</a>
        <?php endif; ?>

        <a href="<?= base_url('kontak') ?>" class="sidebar-link text-danger fw-semibold">📞 Kontak Petugas</a>
    </nav>

    <?php if ($user): ?>
      <div class="sidebar-footer mt-auto pt-4 text-center">
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

  <script>
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('show');
    }
  </script>
</body>
</html>
