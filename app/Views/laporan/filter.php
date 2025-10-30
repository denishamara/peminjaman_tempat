<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📄 Laporan Peminjaman</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="modern-dashboard d-flex">
<?= view('layouts/sidebar') ?>
  <!-- Main Content -->
  <main class="flex-grow-1 p-4 main-content">
    <div class="container-fluid">
      <div class="glass-card mb-4 p-4">
        <h4 class="fw-bold text-primary mb-3">📄 Laporan Peminjaman</h4>
        <form method="get" action="<?= base_url('laporan') ?>" class="row g-3 align-items-end">
          <div class="col-md-4">
            <label for="tanggal_mulai" class="form-label fw-semibold text-secondary">Dari Tanggal</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label for="tanggal_selesai" class="form-label fw-semibold text-secondary">Sampai Tanggal</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>" class="form-control">
          </div>
          <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill fw-semibold shadow-sm">Tampilkan</button>
            <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary flex-fill fw-semibold shadow-sm">Reset</a>
          </div>
        </form>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-secondary">📊 Data Peminjaman</h5>
        <form method="post" action="<?= base_url('laporan/generate') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>">
          <input type="hidden" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>">
          <button type="submit" class="btn btn-success fw-semibold shadow-sm">⬇️ Generate PDF</button>
        </form>
      </div>

      <div class="glass-card p-4">
        <div class="table-responsive">
          <table class="modern-table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>User</th>
                <th>Ruangan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($bookings)): ?>
                <?php $no = 1; foreach ($bookings as $b): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($b['username']) ?></td>
                    <td><?= esc($b['nama_room']) ?></td>
                    <td><?= esc(date('d-m-Y H:i', strtotime($b['tanggal_mulai']))) ?></td>
                    <td><?= esc(date('d-m-Y H:i', strtotime($b['tanggal_selesai']))) ?></td>
                    <td><span class="status-badge <?= esc($b['status']) ?>"><?= esc(ucfirst($b['status'])) ?></span></td>
                    <td><?= esc($b['keterangan']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data peminjaman untuk rentang waktu ini.</td></tr>
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
