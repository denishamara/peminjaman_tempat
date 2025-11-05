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

    /* Agar konten tidak nabrak sidebar */
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
  </style>
</head>
<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="container-fluid">
      <h2 class="fw-bold text-primary mb-4"><?= esc($title) ?></h2>

      <form action="<?= base_url('administrator/kontak/update/' . $petugas['id_user']) ?>" method="post" class="shadow-sm p-4 bg-white rounded">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="telepon" class="form-label">Nomor Telepon</label>
          <input 
            type="text" 
            name="telepon" 
            id="telepon" 
            class="form-control"
            value="<?= esc($petugas['telepon']) ?>" 
            placeholder="Masukkan nomor WhatsApp petugas">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-success">💾 Simpan</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
