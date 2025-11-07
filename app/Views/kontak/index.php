<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    /* Area konten utama agar tidak nabrak sidebar */
    .main-content {
      margin-left: 260px; /* sesuaikan dengan lebar sidebar kamu */
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="container-fluid">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-danger"><?= esc($title) ?></h2>
        <p class="text-muted">Hubungi petugas atau admin jika terjadi keadaan mendesak.</p>
      </div>

      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php elseif(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <?php $user = session()->get('user'); ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center shadow-sm bg-white">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Nomor Telepon</th>
              <?php if ($user && $user['role'] === 'administrator'): ?>
                <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach($petugas as $p): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($p['username']) ?></td>
                <td><?= esc(ucfirst($p['role'])) ?></td>
                <td>
                  <?php if(!empty($p['telepon'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $p['telepon']) ?>" 
                       target="_blank" class="text-success text-decoration-none">
                      <?= esc($p['telepon']) ?> 💬
                    </a>
                  <?php else: ?>
                    <span class="text-muted">Belum ada</span>
                  <?php endif; ?>
                </td>

                <?php if ($user && $user['role'] === 'administrator'): ?>
                  <td>
                    <a href="<?= base_url('administrator/kontak/edit/' . $p['id_user']) ?>" class="btn btn-warning btn-sm">Edit</a>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
