<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    /* Tambahan CSS fix */

    .profile-body {
      display: flex;
      flex-direction: column;
      gap: 10px; /* Biar tiap elemen tidak nempel */
    }

    .profile-body p {
      margin-bottom: 6px;
    }

    .btn-edit {
      margin-top: 15px !important; /* Tambah jarak dari Total Booking */
      display: inline-block;
    }

    .profile-card {
      padding-bottom: 20px; /* Tambahan ruang bawah agar tombol tidak mepet */
    }
  </style>
</head>

<body class="profile-body">
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

      <div class="profile-body">
        <h4><?= esc($user['username']) ?></h4>
        <span class="badge"><?= esc(ucfirst($user['role'])) ?></span>

        <hr>
        <p><strong>ID:</strong> <?= esc($user['id_user']) ?></p>
        <p><strong>Total Booking:</strong> <?= esc($totalBooking) ?></p>

        <a href="<?= base_url('/profile/edit') ?>" class="btn-edit mt-2">Edit Profil</a>
      </div>
    </div>
  </div>
</body>
</html>
