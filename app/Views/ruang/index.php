<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Ruang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

  <!-- Main Content -->
  <main class="main-content">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">🏫 Manajemen Ruang</h3>
        <a href="<?= base_url('/ruang/create') ?>" class="btn btn-primary shadow-sm">
          + Tambah Ruang
        </a>
      </div>

      <!-- Notifikasi -->
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
    <span><?= session()->getFlashdata('success') ?></span>
    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
      <?php endif; ?>

      <!-- Tabel Ruang -->
      <div class="glass-card p-4">
        <div class="table-responsive">
          <table class="modern-table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Ruang</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($ruangs)): ?>
                <?php $no = 1; foreach ($ruangs as $ruang): ?>
                  <tr>
                    <td class="fw-semibold"><?= $no++ ?></td>
                    <td><?= esc($ruang['nama_room']) ?></td>
                    <td><?= esc($ruang['lokasi']) ?></td>
                    <td><?= esc($ruang['deskripsi']) ?></td>
                    <td>
                      <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2">
                        <?= esc($ruang['kapasitas']) ?> Orang
                      </span>
                    </td>
                    <td class="aksi">
                      <div class="action-buttons">
                        <a href="<?= base_url('/ruang/edit/'.$ruang['id_room']) ?>" class="btn btn-warning btn-sm btn-action">
                          ✏️ Edit
                        </a>
                        <form method="post" action="<?= base_url('/ruang/delete/'.$ruang['id_room']) ?>" onsubmit="return confirm('Yakin ingin hapus ruang ini?');">
                          <?= csrf_field() ?>
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-danger btn-sm btn-action">🗑️ Hapus</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-muted fst-italic py-3">Belum ada data ruang.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
