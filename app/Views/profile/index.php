<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <style>
        body {
            background: url('<?= base_url('images/bg.jpeg') ?>') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            padding-left: 250px; /* biar sejajar dengan sidebar */
            display: flex;
            align-items: flex-start;
        }

        .profile-wrapper {
            width: 100%;
            padding: 60px 80px;
            display: flex;
            justify-content: flex-start; /* biar mulai dari kiri */
        }

        .profile-card {
            background: rgba(255,255,255,0.96);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 380px;
            text-align: center;
            position: relative;
        }

        .profile-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            height: 120px;
            position: relative;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
            position: absolute;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
        }

        .profile-body {
            padding: 90px 20px 30px;
        }

        .profile-body h4 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .profile-body span.badge {
            font-size: 0.85rem;
            padding: 0.45em 0.7em;
            margin-bottom: 1rem;
        }

        .btn-edit {
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-edit:hover {
            background: #1d4ed8;
        }

        hr {
            margin: 1rem 0;
            border-color: #e2e8f0;
        }

        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            .profile-wrapper {
                justify-content: center;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<?= view('layouts/sidebar') ?>
<?php $user = session()->get('user'); ?>

<div class="profile-wrapper">
    <div class="profile-card">
        <div class="profile-header"></div>
        <img 
            src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
            alt="Foto Profil" 
            class="profile-img"
            onerror="this.src='<?= base_url('images/profile/default.png') ?>'"
        >
        <div class="profile-body">
            <h4><?= esc($user['username']) ?></h4>
            <span class="badge bg-primary"><?= esc(ucfirst($user['role'])) ?></span>

            <hr>

            <p><strong>ID:</strong> <?= esc($user['id_user']) ?></p>
            <p><strong>Bergabung sejak:</strong> <?= esc($user['created_at'] ?? '-') ?></p>

            <a href="<?= base_url('/profile/edit') ?>" class="btn btn-edit mt-2">Edit Profil</a>
        </div>
    </div>
</div>

</body>
</html>
