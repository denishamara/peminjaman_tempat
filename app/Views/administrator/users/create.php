<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    /* Supaya tidak nabrak sidebar */
    .main-content {
      margin-left: 260px; /* sesuaikan dengan lebar sidebar kamu */
      padding: 40px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }

    .form-card {
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="container-fluid">
      <h2 class="fw-bold text-primary mb-4">Tambah User Baru</h2>

      <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="form-card">
        <form action="<?= base_url('administrator/users/create') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Username</label>
            <input
              type="text"
              id="username"
              name="username"
              class="form-control"
              value="<?= old('username') ?>"
              required
              placeholder="Masukkan username"
            >
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control"
              required
              placeholder="Masukkan password"
            >
          </div>

          <div class="mb-3">
            <label for="role" class="form-label fw-semibold">Role</label>
            <select id="role" name="role" class="form-select" required onchange="toggleNamaPetugas()">
              <option value="" disabled <?= old('role') ? '' : 'selected' ?>>-- Pilih Role --</option>
              <option value="administrator" <?= old('role') === 'administrator' ? 'selected' : '' ?>>Administrator</option>
              <option value="petugas" <?= old('role') === 'petugas' ? 'selected' : '' ?>>Petugas</option>
              <option value="peminjam" <?= old('role') === 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
            </select>
          </div>

          <div class="mb-3" id="namaPetugasContainer" style="display: none;">
            <label for="nama_petugas" class="form-label fw-semibold">Nama Petugas</label>
            <input
              type="text"
              id="nama_petugas"
              name="nama_petugas"
              class="form-control"
              value="<?= old('nama_petugas') ?>"
              placeholder="Masukkan nama petugas"
            >
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">💾 Tambah User</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleNamaPetugas() {
      var role = document.getElementById('role').value;
      var container = document.getElementById('namaPetugasContainer');
      container.style.display = (role === 'petugas') ? 'block' : 'none';
    }

    window.onload = function() {
      toggleNamaPetugas();
    };
  </script>
</body>
</html>
