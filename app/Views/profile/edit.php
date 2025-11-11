<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <style>
    body {
        background: #f7f8fa;
        display: flex;
    }
    .sidebar {
        width: 250px;
        background: #fff;
        border-right: 1px solid #ddd;
        height: 100vh;
        position: fixed;
        padding: 20px;
    }
    .main-content {
        margin-left: 270px;
        padding: 40px;
        width: calc(100% - 270px);
    }
    .card {
        max-width: 600px;
    }
  </style>
</head>

<body>
<?php $user = session()->get('user'); ?>
<?= view('layouts/sidebar') ?>

<div class="main-content">
    <div class="card shadow-sm border-0 p-4">
        <h4 class="fw-bold text-primary mb-3">Edit Profil</h4>

        <form method="post" enctype="multipart/form-data" action="<?= base_url('/profile/update') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
            </div>

            <div class="mb-3">
    <label class="form-label">Foto Profil</label><br>
    <img src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
         alt="Foto Sekarang" class="rounded mb-2 border" 
         style="width: 100px; height: 100px; object-fit: cover;">
    <input type="file" name="foto" class="form-control mt-2" accept="image/*">

    <?php if (!empty($user['foto']) && $user['foto'] !== 'default.jpeg'): ?>
        <a href="<?= base_url('/profile/deletePhoto') ?>" 
           class="btn btn-danger btn-sm mt-2"
           onclick="return confirm('Yakin ingin menghapus foto profil dan kembali ke default?')">
            Hapus Foto
        </a>
    <?php endif; ?>
</div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
