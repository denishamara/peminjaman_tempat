<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Peminjaman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

<div class="history-container">
  <h2 class="fw-bold" style="font-size: 1.75rem;">📜 Daftar Peminjaman yang Telah Selesai</h2>

  <?php if (empty($riwayat)) : ?>
    <div class="alert alert-info text-center">Belum ada riwayat peminjaman.</div>
  <?php else : ?>
    <div class="table-responsive">
      <table class="modern-table table-hover table-bordered">
        <thead class="text-center">
          <tr>
            <th>#</th>
            <th>Nama Peminjam</th>
            <th>Ruangan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
            <th>Keterangan</th>
            <?php if (session()->get('user')['role'] === 'administrator'): ?>
              <th>Aksi</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($riwayat as $r): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td><?= esc($r['username']) ?></td>
              <td><?= esc($r['nama_room']) ?></td>
              <td><?= date('d-m-Y H:i', strtotime($r['tanggal_mulai'])) ?></td>
              <td><?= date('d-m-Y H:i', strtotime($r['tanggal_selesai'])) ?></td>
              <td class="text-center"><span class="badge bg-success">Selesai</span></td>
              <td class="keterangan"><?= esc($r['keterangan']) ?></td>

              <?php if (session()->get('user')['role'] === 'administrator'): ?>
              <td class="text-center">
                <form action="<?= base_url('peminjaman/riwayat/delete/' . $r['id_booking']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus riwayat ini?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-danger">
                    🗑️ Hapus
                  </button>
                </form>
              </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
