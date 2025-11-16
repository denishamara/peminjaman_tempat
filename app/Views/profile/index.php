<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya | SmartRoom</title>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome 6.4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    /* Reset & Base */
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: "Poppins", sans-serif;
    }

    .main-wrapper {
      display: flex;
      min-height: 100vh;
    }

    .profile-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 250px;
      background: transparent;
      padding: 2rem 1rem;
    }

    /* Profile Card Modern */
    .profile-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15);
      width: 100%;
      max-width: 450px;
      text-align: center;
      overflow: hidden;
      position: relative;
      animation: fadeInUp 0.6s ease-in-out;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Header Gradient Purple */
    .profile-header-purple {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      height: 220px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: visible;
    }

    .profile-header-purple::before {
      content: '';
      position: absolute;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Profile Photo */
    .profile-photo {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      border: 5px solid #fff;
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      object-fit: cover;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
      z-index: 10;
      transition: all 0.3s ease;
    }

    .profile-photo:hover {
      transform: translateX(-50%) scale(1.05);
      box-shadow: 0 12px 40px rgba(102, 126, 234, 0.5);
    }

    /* Profile Content */
    .profile-content-modern {
      padding: 25px 30px 35px;
    }

    .profile-name {
      font-weight: 800;
      font-size: 1.75rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.75rem;
    }

    .role-badge-purple {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 50px;
      padding: 0.5rem 1.25rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 0.5rem;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
      text-transform: capitalize;
    }

    .profile-divider {
      margin: 1.75rem 0;
      border: none;
      height: 2px;
      background: linear-gradient(90deg, transparent, #667eea, #764ba2, transparent);
      opacity: 0.3;
    }

    /* Info Items */
    .info-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      margin: 0.75rem 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      border-radius: 12px;
      border-left: 4px solid #667eea;
      transition: all 0.3s ease;
    }

    .info-item:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      transform: translateX(5px);
    }

    .info-label {
      color: #64748b;
      font-weight: 600;
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .info-value {
      color: #1e293b;
      font-weight: 700;
      font-size: 1rem;
    }

    /* Edit Button */
    .btn-edit-purple {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      padding: 0.875rem 2rem;
      border-radius: 12px;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 1.5rem;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-edit-purple:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
      color: white;
    }

    .btn-edit-purple:active {
      transform: translateY(-1px);
    }

    /* Animations */
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

    /* Responsive Design */
    
    /* Desktop Large (≥1200px) */
    @media (min-width: 1200px) {
      .profile-card-modern {
        max-width: 480px;
      }
      
      .profile-header-purple {
        height: 240px;
      }
      
      .profile-photo {
        width: 140px;
        height: 140px;
        bottom: 25px;
      }
      
      .profile-content-modern {
        padding: 30px 35px 40px;
      }
    }

    /* Tablet (992px - 1199px) */
    @media (max-width: 1199px) {
      .profile-card-modern {
        max-width: 450px;
      }
      
      .profile-header-purple {
        height: 220px;
      }
    }

    /* Tablet Small & Mobile Large (768px - 991px) */
    @media (max-width: 991px) {
      .profile-container {
        margin-left: 0;
        padding: 1.5rem 1rem;
      }
      
      .profile-card-modern {
        max-width: 420px;
      }
      
      .profile-header-purple {
        height: 200px;
      }
      
      .profile-photo {
        width: 120px;
        height: 120px;
        bottom: 20px;
        border: 4px solid #fff;
      }
      
      .profile-content-modern {
        padding: 20px 25px 30px;
      }
      
      .profile-name {
        font-size: 1.6rem;
      }
      
      .info-item {
        padding: 0.875rem 1.25rem;
      }
    }

    /* Mobile (576px - 767px) */
    @media (max-width: 767px) {
      .profile-container {
        padding: 1rem 0.75rem;
      }
      
      .profile-card-modern {
        max-width: 100%;
        border-radius: 20px;
      }
      
      .profile-header-purple {
        height: 180px;
      }
      
      .profile-photo {
        width: 110px;
        height: 110px;
        bottom: 15px;
      }
      
      .profile-content-modern {
        padding: 18px 20px 25px;
      }
      
      .profile-name {
        font-size: 1.5rem;
      }
      
      .role-badge-purple {
        font-size: 0.8rem;
        padding: 0.45rem 1rem;
      }
      
      .info-item {
        padding: 0.75rem 1rem;
        margin: 0.6rem 0;
      }
      
      .info-label {
        font-size: 0.8rem;
      }
      
      .info-value {
        font-size: 0.9rem;
      }
      
      .btn-edit-purple {
        padding: 0.75rem 1.75rem;
        font-size: 0.9rem;
      }
    }

    /* Mobile Small (≤575px) */
    @media (max-width: 575px) {
      .profile-container {
        padding: 0.75rem 0.5rem;
      }
      
      .profile-card-modern {
        border-radius: 18px;
      }
      
      .profile-header-purple {
        height: 170px;
      }
      
      .profile-photo {
        width: 100px;
        height: 100px;
        bottom: 15px;
      }
      
      .profile-content-modern {
        padding: 15px 18px 22px;
      }
      
      .profile-name {
        font-size: 1.35rem;
      }
      
      .role-badge-purple {
        font-size: 0.75rem;
        padding: 0.4rem 0.9rem;
      }
      
      .info-item {
        padding: 0.65rem 0.85rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.4rem;
      }
      
      .info-label {
        font-size: 0.75rem;
      }
      
      .info-value {
        font-size: 0.85rem;
      }
      
      .btn-edit-purple {
        width: 100%;
        justify-content: center;
        padding: 0.7rem 1.5rem;
        font-size: 0.875rem;
      }
      
      .profile-divider {
        margin: 1.5rem 0;
      }
    }

    /* Very Small Screens (≤400px) */
    @media (max-width: 400px) {
      .profile-header-purple {
        height: 160px;
      }
      
      .profile-photo {
        width: 90px;
        height: 90px;
        bottom: 15px;
      }
      
      .profile-content-modern {
        padding: 12px 15px 20px;
      }
      
      .profile-name {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>
  <div class="main-wrapper">
    <?= view('layouts/sidebar') ?>
    <?php $user = session()->get('user'); ?>

    <div class="profile-container">
      <div class="profile-card-modern">
        <!-- Header with Purple Gradient -->
        <div class="profile-header-purple">
          <img 
            class="profile-photo"
            src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
            alt="Foto Profil" 
            onerror="this.src='<?= base_url('images/profile/default.png') ?>'">
        </div>

        <!-- Profile Content -->
        <div class="profile-content-modern">
          <!-- Name with Gradient -->
          <h1 class="profile-name">
            <?= esc($user['username']) ?>
          </h1>
          
          <!-- Role Badge -->
          <span class="role-badge-purple">
            <i class="fas fa-crown"></i>
            <?= esc(ucfirst($user['role'])) ?>
          </span>

          <!-- Divider -->
          <hr class="profile-divider">

          <!-- Info Items -->
          <div class="info-item">
            <span class="info-label">
              <i class="fas fa-id-card"></i>
              ID User
            </span>
            <span class="info-value"><?= esc($user['id_user']) ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">
              <i class="fas fa-calendar-check"></i>
              Total Booking
            </span>
            <span class="info-value"><?= esc($totalBooking) ?> Peminjaman</span>
          </div>

          <!-- Edit Button -->
          <a href="<?= base_url('/profile/edit') ?>" class="btn-edit-purple">
            <i class="fas fa-edit"></i>
            Edit Profil
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>