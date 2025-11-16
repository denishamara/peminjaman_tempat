<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Jadwal Ruangan') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
      font-family: 'Poppins', sans-serif;
    }

    .main-content {
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 20px 15px;
        margin-top: 60px;
      }
    }

    /* Card Modern */
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      border: none;
      padding: 1.5rem;
    }

    .card-header h4 {
      font-weight: 700;
      font-size: 1.5rem;
      margin: 0;
    }

    .card-body {
      padding: 2rem;
    }

    /* Page Title */
    .page-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .page-title h5 {
      font-weight: 700;
      font-size: 1.3rem;
      margin: 0;
      color: #1e293b;
    }

    .page-title .action-buttons {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
      border-radius: 50px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary {
      border: 2px solid #0d6efd;
      color: #0d6efd;
      background: transparent;
    }

    .btn-outline-primary:hover {
      background: #0d6efd;
      color: #fff;
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .btn-success:hover {
      box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-outline-light {
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: #fff;
      background: transparent;
    }

    .btn-outline-light:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.5);
    }

    .filter-btn.active {
      background: rgba(255, 255, 255, 1) !important;
      color: #0d6efd !important;
      border-color: rgba(255, 255, 255, 1) !important;
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    /* Alerts */
    .alert {
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    /* Table Container */
    .table-responsive {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      background: #fff;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: #fff;
    }

    .table thead th {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      padding: 1rem;
      border: none;
    }

    .table tbody td {
      padding: 1rem;
      vertical-align: middle;
      border-color: #e2e8f0;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(13, 110, 253, 0.05);
      transform: scale(1.005);
    }

    .table-primary {
      background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .table-warning {
      background-color: rgba(255, 193, 7, 0.15) !important;
    }

    /* Action Buttons in Table */
    td.aksi-col {
      text-align: center;
      vertical-align: middle !important;
      white-space: nowrap;
      width: 180px;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .action-buttons .btn {
      min-width: 70px;
      padding: 0.5rem 1rem;
      font-size: 0.85rem;
      border-radius: 8px;
    }

    .btn-warning {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
      color: #fff;
    }

    .btn-warning:hover {
      box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .btn-danger:hover {
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    /* Badge */
    .badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.85rem;
    }

    /* Filter Header Responsive */
    .card-header.flex-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .card-header .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .card-header.flex-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .card-header h4 {
        font-size: 1.2rem;
      }

      .card-header .btn-group {
        width: 100%;
      }

      .card-header .btn-group .btn {
        flex: 1;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
      }

      .page-title {
        flex-direction: column;
        align-items: flex-start;
      }

      .page-title .action-buttons {
        width: 100%;
      }

      .page-title .action-buttons .btn {
        flex: 1;
      }

      .table {
        font-size: 0.85rem;
      }

      .action-buttons {
        flex-direction: column;
        gap: 0.4rem;
      }

      .action-buttons .btn {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .card-body {
        padding: 1.5rem 1rem;
      }

      .page-title h5 {
        font-size: 1.1rem;
      }

      .table {
        font-size: 0.8rem;
      }

      .table thead th,
      .table tbody td {
        padding: 0.75rem 0.5rem;
      }
    }
  </style>
</head>

<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="card">
      <!-- Header -->
      <div class="card-header flex-header">
        <h4><i class="bi bi-calendar-event me-2"></i>Jadwal Ruangan</h4>
        <div class="btn-group">
          <a href="?filter=all" class="btn btn-outline-light filter-btn <?= ($filter ?? 'all') == 'all' ? 'active' : '' ?>">
            <i class="bi bi-list-ul me-1"></i>Semua
          </a>
          <a href="?filter=reguler" class="btn btn-outline-light filter-btn <?= ($filter ?? '') == 'reguler' ? 'active' : '' ?>">
            <i class="bi bi-calendar3 me-1"></i>Reguler
          </a>
          <a href="?filter=booking" class="btn btn-outline-light filter-btn <?= ($filter ?? '') == 'booking' ? 'active' : '' ?>">
            <i class="bi bi-bookmark-check me-1"></i>Booking
          </a>
        </div>
      </div>

      <div class="card-body">
        <!-- Page Title & Actions -->
        <div class="page-title">
          <h5><i class="bi bi-table me-2"></i>Daftar Jadwal Reguler & Booking</h5>
          <div class="action-buttons">
            <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-outline-primary">
              <i class="bi bi-calendar3 me-1"></i>Lihat Kalender
            </a>
            <?php 
              $user = session()->get('user');
              if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
              <a href="<?= base_url('jadwal/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Alerts -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php elseif (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="text-center">
              <tr>
                <th><i class="bi bi-door-open me-1"></i>Ruangan</th>
                <th><i class="bi bi-info-circle me-1"></i>Kegiatan</th>
                <th><i class="bi bi-person me-1"></i>Peminjam</th>
                <th><i class="bi bi-calendar-date me-1"></i>Tanggal</th>
                <th><i class="bi bi-clock me-1"></i>Jam Mulai</th>
                <th><i class="bi bi-clock-fill me-1"></i>Jam Selesai</th>
                <th><i class="bi bi-tag me-1"></i>Status</th>
                <?php if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
                  <th><i class="bi bi-gear me-1"></i>Aksi</th>
                <?php endif; ?>
              </tr>
            </thead>

            <tbody>
              <?php if (!empty($jadwal)): ?>
                <?php foreach ($jadwal as $j): ?>
                  <?php
                    $status = strtolower($j['status'] ?? 'reguler');
                    $rowClass = $status === 'reguler' ? 'table-primary' : 'table-warning';
                    $id = $j['id'] ?? $j['id_reguler'] ?? $j['id_booking'] ?? null;

                    $tglMulai   = $j['tanggal_mulai'] ?? $j['tgl_pinjam'] ?? $j['tgl_booking'] ?? null;
                    $tglSelesai = $j['tanggal_selesai'] ?? null;

                    if ($tglMulai && $tglSelesai) {
                      $tanggal = (date('Y-m-d', strtotime($tglMulai)) === date('Y-m-d', strtotime($tglSelesai)))
                        ? date('d-m-Y', strtotime($tglMulai))
                        : date('d-m-Y', strtotime($tglMulai)) . ' s.d. ' . date('d-m-Y', strtotime($tglSelesai));
                    } elseif ($tglMulai) {
                      $tanggal = date('d-m-Y', strtotime($tglMulai));
                    } else {
                      $tanggal = '-';
                    }

                    $jamMulai = $j['jam_mulai'] ?? (!empty($tglMulai) ? date('H:i', strtotime($tglMulai)) : '-');
                    $jamSelesai = $j['jam_selesai'] ?? (!empty($tglSelesai) ? date('H:i', strtotime($tglSelesai)) : '-');
                  ?>

                  <tr class="<?= esc($rowClass) ?>">
                    <td><strong><?= esc($j['nama_ruang'] ?? '-') ?></strong></td>
                    <td><?= esc($j['nama_kegiatan'] ?? $j['nama_reguler'] ?? $j['keterangan'] ?? '-') ?></td>
                    <td><?= esc($j['peminjam'] ?? '-') ?></td>
                    <td class="text-center"><?= esc($tanggal) ?></td>
                    <td class="text-center"><strong><?= esc($jamMulai) ?></strong></td>
                    <td class="text-center"><strong><?= esc($jamSelesai) ?></strong></td>
                    <td class="text-center">
                      <span class="badge <?= $status === 'reguler' ? 'bg-primary' : 'bg-warning text-dark' ?> text-capitalize">
                        <?= esc($j['status'] ?? '-') ?>
                      </span>
                    </td>

                    <?php if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
                      <td class="aksi-col">
                        <?php if (!empty($id)): ?>
                          <div class="action-buttons">
                            <a href="<?= base_url('jadwal/edit/' . $id . '?tipe=' . strtolower($j['status'])) ?>" 
                               class="btn btn-warning btn-sm">
                              <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="<?= base_url('jadwal/delete/' . $id) ?>" method="post" style="display:inline;">
                              <?= csrf_field() ?>
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="tipe" value="<?= strtolower($j['status'] ?? 'reguler') ?>">
                              <button type="submit" class="btn btn-danger btn-sm"
                                      onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                <i class="bi bi-trash"></i> Hapus
                              </button>
                            </form>
                          </div>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="<?= (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])) ? '8' : '7' ?>" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity: 0.3;"></i>
                    <p class="mb-0">Tidak ada jadwal ditemukan.</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
