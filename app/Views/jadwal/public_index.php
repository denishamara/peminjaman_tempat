<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Reguler | SmartRoom</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background: #0f172a;
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
    }

    .table thead {
      background: #0f172a;
      color: #fff;
    }

    .btn-primary {
      background: #2563eb;
      border: none;
    }

    .btn-primary:hover {
      background: #1e40af;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('/') ?>">SmartRoom</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold">📅 Jadwal Reguler & Booking</h3>
      <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-primary">
        <i class="bi bi-calendar3"></i> Lihat Kalender
      </a>
    </div>

    <?php if (!empty($jadwal)): ?>
      <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Ruang</th>
              <th>Kegiatan</th>
              <th>Hari</th>
              <th>Jam Mulai</th>
              <th>Jam Selesai</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($jadwal as $item): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($item['nama_ruang']) ?></td>
                <td><?= esc($item['nama_kegiatan']) ?></td>
                <td><?= esc($item['hari']) ?></td>
                <td><?= esc($item['jam_mulai']) ?></td>
                <td><?= esc($item['jam_selesai']) ?></td>
                <td>
                  <?php if ($item['status'] == 'proses'): ?>
                    <span class="badge bg-warning text-dark">Proses</span>
                  <?php elseif ($item['status'] == 'disetujui'): ?>
                    <span class="badge bg-success">Disetujui</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Reguler</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">Belum ada jadwal terdaftar.</div>
    <?php endif; ?>
  </div>

  <footer class="text-center text-muted py-3">
    <small>© <?= date('Y') ?> SmartRoom</small>
  </footer>
</body>
</html>
