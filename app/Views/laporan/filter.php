<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📄 Laporan Peminjaman</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <style>
    /* ============================================
       MASTER FIX — MENCEGAH LAYOUT NGELEBAR
       ============================================ */
    html, body {
      width: 100%;
      overflow-x: hidden !important;
    }

    .main-content, .container-fluid {
      overflow-x: hidden;
      width: 100%;
    }

    /* ============================================
       FILTER TIDAK BOLEH KETUTUP TABEL
       ============================================ */
    .filter-area {
      position: relative !important;
      z-index: 999 !important;
      overflow: visible !important;
    }

    /* Tabel tetap di bawah */
    .table-area {
      position: relative;
      z-index: 1 !important;
    }

    /* ============================================
       SELECT / DROPDOWN SELALU DI DEPAN
       ============================================ */
    .form-select {
      position: relative !important;
      z-index: 1000 !important;
      background-color: #fff !important;
    }

    /* ============================================
       TABLE PROTECTOR — Tidak keluar layar
       ============================================ */
    .table-responsive {
      overflow-x: auto !important;
      width: 100%;
      max-width: 100%;
    }

    /* ============================================
       Mencegah glass-card melebar
       ============================================ */
    .glass-card {
      width: 100%;
      max-width: 100%;
      overflow: visible !important;
    }

    /* ============================================
       FIX KOLOM TAHUN - LEBIH LEBAR
       ============================================ */
    .tahun-input {
      min-width: 120px !important; /* Lebarkan kolom tahun */
    }

    .bulan-select {
      min-width: 150px !important; /* Lebarkan kolom bulan */
    }

    * {
      box-sizing: border-box;
    }
  </style>

</head>
<body class="modern-dashboard d-flex">

<?= view('layouts/sidebar') ?>

  <!-- Main Content -->
  <main class="flex-grow-1 p-4 main-content">
    <div class="container-fluid">

      <!-- ================= FILTER CARD ================= -->
      <div class="glass-card mb-4 p-4 filter-area">
        <h4 class="fw-bold text-primary mb-3">📄 Laporan Peminjaman</h4>

        <form method="get" action="<?= base_url('laporan') ?>" class="row g-3 align-items-end">

          <!-- Hari -->
          <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Hari</label>
            <select name="hari" id="hari" class="form-select">
              <option value="">-- Semua Hari --</option>
              <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h): ?>
                <option value="<?= $h ?>" <?= ($hari ?? '') === $h ? 'selected' : '' ?>>
                  <?= $h ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tanggal Mulai -->
          <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Dari Tanggal</label>
            <input type="date" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>" class="form-control">
          </div>

          <!-- Tanggal Selesai -->
          <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Sampai Tanggal</label>
            <input type="date" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>" class="form-control">
          </div>

          <!-- Bulan -->
          <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Bulan</label>
            <select name="bulan" id="bulan" class="form-select bulan-select">
              <option value="">-- Semua Bulan --</option>
              <?php 
                $bulanList = [
                  1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                ];
                foreach ($bulanList as $num => $nama):
              ?>
                <option value="<?= $num ?>" <?= ($bulan ?? '') == $num ? 'selected' : '' ?>>
                  <?= $nama ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tahun -->
          <div class="col-md-2">
            <label class="form-label fw-semibold text-secondary">Tahun</label>
            <input type="number" name="tahun" min="2020" max="<?= date('Y') + 1 ?>" 
                   value="<?= esc($tahun ?? date('Y')) ?>" class="form-control tahun-input">
          </div>

          <!-- Buttons -->
          <div class="col-md-2 d-flex flex-column gap-2">
            <button type="submit" class="btn btn-primary fw-semibold shadow-sm">🔍 Tampilkan</button>
            <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary fw-semibold shadow-sm">🔄 Reset</a>
          </div>

        </form>
      </div>

      <!-- ================= HEADER + BUTTON ================= -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-secondary">📊 Data Peminjaman</h5>

        <form method="post" action="<?= base_url('laporan/generate') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>">
          <input type="hidden" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>">
          <input type="hidden" name="hari" value="<?= esc($hari) ?>">
          <input type="hidden" name="bulan" value="<?= esc($bulan) ?>">
          <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

          <button type="submit" class="btn btn-success fw-semibold shadow-sm">⬇️ Generate PDF</button>
        </form>
      </div>

      <!-- ================= TABLE AREA ================= -->
      <div class="glass-card p-4 table-area">
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
                    <td>
                      <span class="status-badge <?= esc($b['status']) ?>">
                        <?= esc(ucfirst($b['status'])) ?>
                      </span>
                    </td>
                    <td><?= esc($b['keterangan']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    Tidak ada data peminjaman sesuai filter.
                  </td>
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