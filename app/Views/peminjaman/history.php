<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Peminjaman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

<div class="history-container">
  <!-- Page Header -->
  <div class="glass-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2 class="fw-bold mb-2" style="font-size: 1.75rem;">
          <i class="fas fa-history text-primary me-2"></i>Riwayat Peminjaman
        </h2>
        <p class="text-muted mb-0">
          <i class="fas fa-info-circle me-1"></i>Daftar peminjaman yang telah selesai
        </p>
      </div>
      <?php if (!empty($riwayat)): ?>
        <div class="text-end">
          <span class="badge bg-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">
            <i class="fas fa-check-circle me-1"></i><?= count($riwayat) ?> Riwayat
          </span>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if (empty($riwayat)): ?>
    <!-- Empty State -->
    <div class="glass-card p-5 text-center">
      <i class="fas fa-inbox text-muted mb-3" style="font-size: 4rem;"></i>
      <h5 class="fw-bold text-muted mb-2">Belum Ada Riwayat Peminjaman</h5>
      <p class="text-muted mb-4">Riwayat peminjaman yang telah selesai akan ditampilkan di sini</p>
      <a href="<?= base_url('peminjaman/ajukan') ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman Baru
      </a>
    </div>
  <?php else: ?>
    <!-- Table Card -->
    <div class="glass-card p-4">
      <div class="table-responsive">
        <table class="modern-table table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">
                <i class="fas fa-hashtag me-1"></i>#
              </th>
              <th>
                <i class="fas fa-user me-2"></i>Nama Peminjam
              </th>
              <th>
                <i class="fas fa-door-open me-2"></i>Ruangan
              </th>
              <th>
                <i class="fas fa-calendar-alt me-2"></i>Tanggal Mulai
              </th>
              <th>
                <i class="fas fa-calendar-check me-2"></i>Tanggal Selesai
              </th>
              <th class="text-center">
                <i class="fas fa-info-circle me-2"></i>Status
              </th>
              <th>
                <i class="fas fa-comment me-2"></i>Keterangan
              </th>
              <?php if (session()->get('user')['role'] === 'administrator'): ?>
                <th class="text-center" style="width: 100px;">
                  <i class="fas fa-cog me-2"></i>Aksi
                </th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($riwayat as $r): ?>
              <tr>
                <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                      <i class="fas fa-user text-primary"></i>
                    </div>
                    <strong><?= esc($r['username']) ?></strong>
                  </div>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-door-open text-info me-2"></i>
                    <span class="fw-semibold"><?= esc($r['nama_room']) ?></span>
                  </div>
                </td>
                <td>
                  <small class="text-muted d-block">
                    <i class="far fa-calendar me-1"></i><?= date('d M Y', strtotime($r['tanggal_mulai'])) ?>
                  </small>
                  <small class="fw-semibold">
                    <i class="far fa-clock me-1"></i><?= date('H:i', strtotime($r['tanggal_mulai'])) ?>
                  </small>
                </td>
                <td>
                  <small class="text-muted d-block">
                    <i class="far fa-calendar me-1"></i><?= date('d M Y', strtotime($r['tanggal_selesai'])) ?>
                  </small>
                  <small class="fw-semibold">
                    <i class="far fa-clock me-1"></i><?= date('H:i', strtotime($r['tanggal_selesai'])) ?>
                  </small>
                </td>
                <td class="text-center">
                  <span class="badge bg-success" style="padding: 0.5rem 0.75rem;">
                    <i class="fas fa-check-circle me-1"></i>Selesai
                  </span>
                </td>
                <td>
                  <small class="text-muted"><?= esc($r['keterangan']) ?></small>
                </td>

                <?php if (session()->get('user')['role'] === 'administrator'): ?>
                <td class="text-center">
                  <form action="<?= base_url('peminjaman/riwayat/delete/' . $r['id_booking']) ?>" method="post" 
                        onsubmit="return confirm('⚠️ Yakin ingin menghapus riwayat ini?\n\nData yang dihapus tidak dapat dikembalikan.');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Riwayat">
                      <i class="fas fa-trash-alt me-1"></i>Hapus
                    </button>
                  </form>
                </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Summary Footer -->
      <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
        <p class="text-muted mb-0">
          <i class="fas fa-info-circle me-1"></i>Menampilkan <strong><?= count($riwayat) ?></strong> riwayat peminjaman yang telah selesai
        </p>
        <a href="<?= base_url('peminjaman/daftar') ?>" class="btn btn-outline-primary">
          <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Peminjaman
        </a>
      </div>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
