<?php
// Pastikan user dari session terbaca
$user = isset($user) ? $user : session()->get('user');

// Helper function untuk check active menu
$uri = service('uri');
$segment1 = $uri->getSegment(1) ?? '';
$segment2 = $uri->getSegment(2) ?? '';

function isActive($path, $segment1, $segment2 = '') {
    // Exact match untuk dashboard
    if ($path === 'dashboard' && $segment1 === 'dashboard') {
        return 'active';
    }
    
    // Check administrator routes
    if (strpos($path, 'administrator') !== false) {
        if ($segment1 === 'administrator' && $segment2 === 'users') {
            return 'active';
        }
    }
    
    // Check ruang
    if (($path === 'ruang/index' || $path === 'ruang') && $segment1 === 'ruang') {
        return 'active';
    }
    
    // Check laporan
    if ($path === 'laporan' && $segment1 === 'laporan') {
        return 'active';
    }
    
    // Check peminjaman history
    if ($path === 'peminjaman/history' && $segment1 === 'peminjaman' && $segment2 === 'history') {
        return 'active';
    }
    
    // Check peminjaman ajukan
    if ($path === 'peminjaman/ajukan' && $segment1 === 'peminjaman' && $segment2 === 'ajukan') {
        return 'active';
    }
    
    // Check petugas peminjaman daftar
    if ($path === 'petugas/peminjaman_daftar' && $segment1 === 'petugas' && $segment2 === 'peminjaman_daftar') {
        return 'active';
    }
    
    // Check jadwal
    if (($path === 'jadwal/index' || $path === 'jadwal') && $segment1 === 'jadwal') {
        return 'active';
    }
    
    // Check profile
    if ($path === 'profile' && $segment1 === 'profile') {
        return 'active';
    }
    
    // Check kontak
    if ($path === 'kontak' && $segment1 === 'kontak') {
        return 'active';
    }
    
    return '';
}
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
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
  /* =======================================================
     🌐 DASHBOARD STYLE (Sidebar + Layout + Responsif)
     ======================================================= */
  body {
    background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    min-height: 100vh;
  }

  @keyframes gradientShift {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }

  /* ====== SIDEBAR ====== */
  .sidebar {
    width: 250px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(255, 255, 255, 0.3);
    padding: 1.8rem 1.2rem;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    box-shadow: 
      4px 0 20px rgba(0, 0, 0, 0.08),
      inset -1px 0 0 rgba(255, 255, 255, 0.5);
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(102, 126, 234, 0.3) transparent;
    transition: left 0.3s ease;
    z-index: 1000;
    -webkit-overflow-scrolling: touch;
  }

  /* Scrollbar (Chrome, Edge, Safari) */
  .sidebar::-webkit-scrollbar { width: 6px; }
  .sidebar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #667eea, #764ba2);
    border-radius: 10px;
  }
  .sidebar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #764ba2, #667eea);
  }

  /* ====== SIDEBAR ISI ====== */
  .sidebar-header h3 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    margin-bottom: 0;
    text-align: center;
    font-size: 1.5rem;
    letter-spacing: -0.5px;
  }

  .sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .sidebar-link {
    color: #475569;
    padding: 0.85rem 1.1rem;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
  }

  .sidebar-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: scaleY(0);
    transition: transform 0.3s ease;
  }

  .sidebar-link:hover,
  .sidebar-link.active {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
  }

  .sidebar-link.active::before {
    transform: scaleY(1);
  }

  .sidebar-link i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
  }

  /* ====== SIDEBAR FOOTER ====== */
  .sidebar-footer {
    margin-top: auto;
    padding-top: 1.5rem;
    border-top: 2px solid rgba(102, 126, 234, 0.1);
    text-align: center;
  }

  /* Sidebar Profile Image */
  .profile-img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
  }

  .sidebar-profile-img {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    border: 3px solid transparent;
    background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #667eea, #764ba2) border-box;
    object-fit: cover;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
  }

  .sidebar-profile-img:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
  }

  .sidebar-footer .fw-semibold {
    font-size: 0.95rem;
    color: #1e293b;
    font-weight: 600;
  }

  .sidebar-footer .text-muted {
    font-size: 0.85rem;
    text-transform: capitalize;
    color: #64748b;
  }

  .sidebar-footer .btn-outline-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    padding: 0.65rem 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
  }

  .sidebar-footer .btn-outline-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
  }

  /* ====== MAIN CONTENT ====== */
  .main-content {
    margin-left: 260px;
    padding: 2rem;
    width: calc(100% - 260px);
    transition: all 0.3s ease;
    min-height: 100vh;
  }

  /* ====== NAVBAR KECIL (untuk layar kecil) ====== */
  .navbar {
    height: 60px;
    z-index: 999999;
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(20px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .menu-toggle {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    font-size: 1.4rem;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  .menu-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
  }

  .navbar .text-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
  }

  /* ====== RESPONSIVE ====== */
  @media (max-width: 992px) {
    .sidebar {
      left: -260px;
      position: fixed;
      top: 60px;
      height: calc(100vh - 60px);
      overflow-y: auto !important;
      overflow-x: hidden !important;
      -webkit-overflow-scrolling: touch;
      z-index: 1000000 !important;
    }
    .sidebar.show { 
      left: 0;
      box-shadow: 8px 0 40px rgba(0, 0, 0, 0.2);
    }
    .main-content {
      margin-left: 0;
      width: 100%;
      padding: 1.5rem;
      margin-top: 65px;
    }
  }

  @media (max-width: 576px) {
    .sidebar {
      width: 240px;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
      padding: 1.5rem 1rem;
    }
    .sidebar-link {
      font-size: 0.9rem;
      padding: 0.75rem 0.9rem;
      gap: 0.6rem;
    }
    .sidebar-link i {
      font-size: 1rem;
    }
    .sidebar-profile-img {
      width: 65px;
      height: 65px;
    }
    .navbar {
      height: 56px;
    }
    .menu-toggle {
      width: 40px;
      height: 40px;
      font-size: 1.2rem;
    }
  }

  /* Animated Floating Orbs */
  .floating-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.5;
    animation: float 20s infinite ease-in-out;
    pointer-events: none;
    z-index: 0;
  }

  .orb-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.6), transparent);
    top: -10%;
    left: -10%;
    animation-delay: 0s;
    animation-duration: 25s;
  }

  .orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(240, 147, 251, 0.5), transparent);
    top: 60%;
    right: -10%;
    animation-delay: 5s;
    animation-duration: 20s;
  }

  .orb-3 {
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(79, 172, 254, 0.5), transparent);
    bottom: -10%;
    left: 40%;
    animation-delay: 10s;
    animation-duration: 30s;
  }

  .orb-4 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(118, 75, 162, 0.6), transparent);
    top: 30%;
    right: 30%;
    animation-delay: 15s;
    animation-duration: 22s;
  }

  @keyframes float {
    0%, 100% {
      transform: translate(0, 0) scale(1) rotate(0deg);
    }
    25% {
      transform: translate(50px, -50px) scale(1.1) rotate(90deg);
    }
    50% {
      transform: translate(-30px, 30px) scale(0.9) rotate(180deg);
    }
    75% {
      transform: translate(30px, 50px) scale(1.05) rotate(270deg);
    }
  }
  </style>
</head>

<body>
  <!-- Animated Floating Orbs Background -->
  <div class="floating-orb orb-1"></div>
  <div class="floating-orb orb-2"></div>
  <div class="floating-orb orb-3"></div>
  <div class="floating-orb orb-4"></div>

  <!-- Navbar kecil (hanya muncul di layar kecil) -->
  <nav class="navbar bg-white shadow-sm px-3 d-lg-none d-flex align-items-center fixed-top justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
      </button>
      <span class="text-primary fs-5">
        <i class="fas fa-building me-1"></i>Menu
      </span>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
        <h3 class="fw-bold text-primary mb-0" style="font-size: 1.5rem;">
            <i class="fas fa-building"></i> Sistem Peminjaman
        </h3>
    </div>

    <nav class="sidebar-menu mt-4">
        <a href="<?= base_url('dashboard') ?>" class="sidebar-link <?= isActive('dashboard', $segment1) ?>">
            <i class="fas fa-home"></i> Home
        </a>

        <?php if (isset($user) && $user['role'] === 'administrator'): ?>
            <a href="<?= base_url('administrator/users/index') ?>" class="sidebar-link <?= isActive('administrator/users/index', $segment1, $segment2) ?>">
                <i class="fas fa-users"></i> Manajemen User
            </a>
            <a href="<?= base_url('ruang/index') ?>" class="sidebar-link <?= isActive('ruang/index', $segment1) ?>">
                <i class="fas fa-door-open"></i> Manajemen Ruang
            </a>
            <a href="<?= base_url('laporan') ?>" class="sidebar-link <?= isActive('laporan', $segment1) ?>">
                <i class="fas fa-file-alt"></i> Generate Laporan
            </a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link <?= isActive('peminjaman/history', $segment1, $segment2) ?>">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </a>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link <?= isActive('petugas/peminjaman_daftar', $segment1, $segment2) ?>">
                <i class="fas fa-clipboard-list"></i> Daftar Peminjaman
            </a>

        <?php elseif (isset($user) && $user['role'] === 'petugas'): ?>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link <?= isActive('petugas/peminjaman_daftar', $segment1, $segment2) ?>">
                <i class="fas fa-clipboard-list"></i> Daftar Peminjaman
            </a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link <?= isActive('peminjaman/history', $segment1, $segment2) ?>">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </a>
            <a href="<?= base_url('laporan') ?>" class="sidebar-link <?= isActive('laporan', $segment1) ?>">
                <i class="fas fa-file-alt"></i> Generate Laporan
            </a>

        <?php elseif (isset($user) && $user['role'] === 'peminjam'): ?>
            <a href="<?= base_url('ruang') ?>" class="sidebar-link <?= isActive('ruang', $segment1) ?>">
                <i class="fas fa-door-open"></i> Daftar Ruang
            </a>
            <a href="<?= base_url('peminjaman/ajukan') ?>" class="sidebar-link <?= isActive('peminjaman/ajukan', $segment1, $segment2) ?>">
                <i class="fas fa-edit"></i> Pengajuan Peminjaman
            </a>
        <?php endif; ?>

        <a href="<?= base_url('jadwal/index') ?>" class="sidebar-link <?= isActive('jadwal', $segment1) ?>">
            <i class="fas fa-calendar-alt"></i> Jadwal Ruang
        </a>

        <?php if ($user): ?>
            <a href="<?= base_url('profile') ?>" 
               class="sidebar-link <?= isActive('profile', $segment1) ?>">
                <i class="fas fa-user-circle"></i> Profile
            </a>
        <?php endif; ?>

        <a href="<?= base_url('kontak') ?>" class="sidebar-link <?= isActive('kontak', $segment1) ?>">
            <i class="fas fa-phone-alt"></i> Kontak Petugas
        </a>
    </nav>

    <?php if ($user): ?>
      <div class="sidebar-footer mt-auto pt-4 text-center">
        <div class="profile-img-container mb-2">
          <img src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>"
               alt="Foto Profil"
               class="sidebar-profile-img"
               onerror="this.src='<?= base_url('images/profile/default.jpeg') ?>'">
        </div>
        <div class="fw-semibold text-dark small mb-1">
            <i class="fas fa-user"></i> <?= esc($user['username']) ?>
        </div>
        <div class="text-muted small mb-2">
            <i class="fas fa-id-badge"></i> <?= esc($user['role']) ?>
        </div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger w-100 btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
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
