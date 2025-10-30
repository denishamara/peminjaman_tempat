<body class="modern-dashboard daftar-jadwal-body">
<?= view('layouts/sidebar') ?>

<div class="main-content daftar-jadwal-content">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📅 Daftar Jadwal</h2>

    <div class="d-flex gap-2">
      <?php $userRole = session()->get('user')['role'] ?? null; ?>
      <?php if ($userRole !== 'peminjam'): ?>
        <a href="<?= base_url('jadwal/create') ?>" class="btn btn-primary">➕ Tambah Jadwal</a>
      <?php endif; ?>
      <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-info">📆 Lihat Kalender</a>
    </div>
  </div>

  <!-- Notifikasi -->
  <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      ⚠️ <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Tabel Jadwal -->
  <div class="glass-card jadwal-card">
    <table class="modern-table table-hover">
      <thead>
        <tr>
          <th>Nama Jadwal</th>
          <th>Ruangan</th>
          <th>Peminjam</th>
          <th>Tanggal Mulai</th>
          <th>Tanggal Selesai</th>
          <th>Keterangan</th>
          <?php if ($userRole !== 'peminjam'): ?>
            <th>Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($jadwals)): ?>
          <?php foreach ($jadwals as $jadwal): ?>
            <tr>
              <td class="text-truncate-150"><?= esc($jadwal['nama_reguler']) ?></td>
              <td class="text-center"><?= esc($jadwal['nama_room'] ?? '—') ?></td>
              <td class="text-center"><?= esc($jadwal['username'] ?? '—') ?></td>
              <td class="text-center"><?= date('d-m-Y H:i', strtotime($jadwal['tanggal_mulai'])) ?></td>
              <td class="text-center"><?= date('d-m-Y H:i', strtotime($jadwal['tanggal_selesai'])) ?></td>
              <td class="keterangan-col"><?= esc($jadwal['keterangan']) ?></td>

              <?php if ($userRole !== 'peminjam'): ?>
                <td>
                  <div class="action-buttons">
                    <a href="<?= base_url('jadwal/edit/'.$jadwal['id_reguler']) ?>" class="btn btn-warning btn-action">✏ Edit</a>
                    <form action="<?= base_url('jadwal/delete/'.$jadwal['id_reguler']) ?>" method="post" onsubmit="return confirm('Yakin ingin hapus jadwal ini?');">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-action">🗑 Hapus</button>
                    </form>
                  </div>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="<?= $userRole !== 'peminjam' ? 7 : 6 ?>" class="text-center text-muted fst-italic">
              ℹ Belum ada jadwal
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
