<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Ruang</title>
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

    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .card-header {
      border-top-left-radius: 12px !important;
      border-top-right-radius: 12px !important;
    }
  </style>
</head>
<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h4 class="mb-0">Tambah Ruang Baru</h4>
        </div>

        <div class="card-body">
          <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                  <li><?= esc($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="<?= base_url('ruang/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Ruang</label>
              <input type="text" name="nama_room" class="form-control" placeholder="Masukkan nama ruang" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Lokasi</label>
              <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi ruang" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" placeholder="Tuliskan deskripsi ruang (opsional)" rows="3"></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Kapasitas</label>
              <input type="number" name="kapasitas" class="form-control" placeholder="Masukkan kapasitas ruang" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <button type="submit" class="btn btn-success">💾 Simpan Ruang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
