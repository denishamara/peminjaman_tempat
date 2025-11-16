<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    /* Reset margin dan padding untuk body */
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
      align-items: center; /* Pusatkan vertikal */
      margin-left: 250px;
      background: transparent;
      padding: 1rem;
    }

    .profile-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      width: 400px;
      text-align: center;
      overflow: hidden;
      position: relative;
      animation: fadeInUp 0.6s ease-in-out;
    }

    /* Header profil */
    .profile-header {
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      height: 130px;
      position: relative;
    }

    /* Foto profil */
    .profile-header img {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      border: 4px solid #fff;
      position: absolute;
      bottom: -55px;
      left: 50%;
      transform: translateX(-50%);
      object-fit: cover;
      background-color: #f8f9fa;
    }

    /* Isi profil */
    .profile-content {
      padding: 80px 20px 30px;
    }

    .profile-content h4 {
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 0.3rem;
    }

    .profile-content p {
      color: #64748b;
      margin-bottom: 0.5rem;
    }

    .profile-content .badge {
      background-color: #2563eb;
      font-size: 0.85rem;
      border-radius: 6px;
      padding: 0.45rem 0.7rem;
      margin-top: 0.5rem;
      display: inline-block;
    }

    .profile-content hr {
      margin: 1.2rem 0;
      border-color: #e2e8f0;
    }

    /* Tombol Edit */
    .profile-content .btn-edit {
      background: #2563eb;
      color: white;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease-in-out;
      display: inline-block;
      margin-top: 1rem;
    }

    .profile-content .btn-edit:hover {
      background: #1d4ed8;
      transform: translateY(-2px);
    }

    /* Efek animasi */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsif */
    @media (max-width: 992px) {
      .profile-container {
        margin-left: 0;
        width: 100%;
        border-radius: 0;
        padding: 1rem;
      }
      
      .profile-card {
        width: 100%;
        max-width: 400px;
      }
    }
  </style>
</head>

<body>
  <div class="main-wrapper">
    <?= view('layouts/sidebar') ?>
    <?php $user = session()->get('user'); ?>

    <div class="profile-container">
      <div class="profile-card">
        <div class="profile-header">
          <img 
            src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
            alt="Foto Profil" 
            onerror="this.src='<?= base_url('images/profile/default.png') ?>'">
        </div>

        <div class="profile-content">
          <h4><?= esc($user['username']) ?></h4>
          <span class="badge"><?= esc(ucfirst($user['role'])) ?></span>

          <hr>
          <p><strong>ID:</strong> <?= esc($user['id_user']) ?></p>
          <p><strong>Total Booking:</strong> <?= esc($totalBooking) ?></p>

          <a href="<?= base_url('/profile/edit') ?>" class="btn-edit">Edit Profil</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>