<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Jadwal Ruangan') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .main-content { margin-left: 260px; padding: 30px; transition: margin-left 0.3s ease; }
    @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 15px; } }
    .filter-btn.active { background-color: #0d6efd !important; color: white !important; }
    .table-warning { background-color: #fff3cd !important; }
    .table-primary { background-color: #cfe2ff !important; }

    /* Kolom aksi */
    td.aksi-col {
      text-align: center;
      vertical-align: middle !important;
      white-space: nowrap;
      width: 150px;
    }
    .action-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
    }
    .action-buttons .btn {
      min-width: 70px;
      padding: 4px 8px;
    }

    /* Fix tombol filter agar tidak nabrak */
    .card-header.flex-header {
      flex-wrap: wrap;
      gap: 10px;
    }
    .card-header.flex-header h4 {
      flex-grow: 1;
      margin-bottom: 0;
    }
    .card-header .btn-group {
      flex-wrap: wrap;
      justify-content: flex-end;
    }
    @media (max-width: 576px) {
      .card-header.flex-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .card-header .btn-group {
        width: 100%;
        justify-content: flex-start;
        gap: 6px;
      }
      .card-header .btn-group .btn {
        flex: 1;
      }
    }
  </style>
</head>

<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="card shadow-sm">
      <!-- Header diperbaiki -->
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-header">
        <h4 class="mb-0">📅 Jadwal Ruangan</h4>
        <div class="btn-group">
          <a href="?filter=all" class="btn btn-outline-light filter-btn <?= ($filter ?? 'all') == 'all' ? 'active' : '' ?>">Gabungan</a>
          <a href="?filter=reguler" class="btn btn-outline-light filter-btn <?= ($filter ?? '') == 'reguler' ? 'active' : '' ?>">Reguler</a>
          <a href="?filter=booking" class="btn btn-outline-light filter-btn <?= ($filter ?? '') == 'booking' ? 'active' : '' ?>">Booking</a>
        </div>
      </div>

      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
          <h5 class="fw-bold mb-0">📘 Jadwal Reguler & Booking</h5>
          <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-outline-primary">
              <i class="bi bi-calendar3"></i> Lihat Kalender
            </a>
            <?php 
              $user = session()->get('user');
              if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
              <a href="<?= base_url('jadwal/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Jadwal
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="text-center">
              <tr>
                <th>Ruangan</th>
                <th>Nama Kegiatan</th>
                <th>Peminjam</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Status</th>
                <?php if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
                  <th>Aksi</th>
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
                    <td><?= esc($j['nama_ruang'] ?? '-') ?></td>
                    <td><?= esc($j['nama_kegiatan'] ?? $j['nama_reguler'] ?? $j['keterangan'] ?? '-') ?></td>
                    <td><?= esc($j['peminjam'] ?? '-') ?></td>
                    <td class="text-center"><?= esc($tanggal) ?></td>
                    <td class="text-center"><?= esc($jamMulai) ?></td>
                    <td class="text-center"><?= esc($jamSelesai) ?></td>
                    <td class="text-center text-capitalize"><?= esc($j['status'] ?? '-') ?></td>

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
                  <td colspan="<?= (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])) ? '8' : '7' ?>" class="text-center text-muted py-3">
                    Tidak ada jadwal ditemukan.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
