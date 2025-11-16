<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Ruang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <style>
    .badge-status {
      font-size: 0.85rem;
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 600;
    }
    .status-tersedia {
      background-color: rgba(25,135,84,0.1);
      color: #198754;
    }
    .status-tidak {
      background-color: rgba(220,53,69,0.1);
      color: #dc3545;
    }
    .status-reguler {
      background-color: rgba(255,193,7,0.1);
      color: #ffc107;
    }
    .btn-action {
      border-radius: 8px;
      font-weight: 500;
    }
  </style>
</head>
<body class="modern-dashboard">

<?= view('layouts/sidebar') ?>

<main class="main-content">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary" style="font-size: 1.75rem;">🏫 Manajemen Ruang</h2>

      <?php if (in_array(session()->get('user')['role'] ?? '', ['administrator', 'petugas'])): ?>
        <a href="<?= base_url('/ruang/create') ?>" class="btn btn-primary shadow-sm">+ Tambah Ruang</a>
      <?php endif; ?>
    </div>

    <!-- Notifikasi -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Tabel Ruang -->
    <div class="glass-card p-4">
      <div class="table-responsive">
        <table class="modern-table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Ruang</th>
              <th>Lokasi</th>
              <th>Deskripsi</th>
              <th>Kapasitas</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($ruangs)): ?>
              <?php $no = 1; foreach ($ruangs as $r): ?>
                <tr>
                  <td class="fw-semibold"><?= $no++ ?></td>
                  <td><?= esc($r['nama_room']) ?></td>
                  <td><?= esc($r['lokasi']) ?></td>
                  <td><?= esc($r['deskripsi']) ?></td>
                  <td>
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2">
                      <?= esc($r['kapasitas']) ?> Orang
                    </span>
                  </td>

                  <!-- Status -->
                  <td>
                    <?php
                      $statusClass = 'status-tersedia';
                      if ($r['status'] == 'Tidak Tersedia') $statusClass = 'status-tidak';
                      elseif (stripos($r['status'], 'Reguler') !== false) $statusClass = 'status-reguler';
                    ?>
                    <span class="badge-status <?= $statusClass ?>"><?= esc($r['status']) ?></span>
                  </td>

                  <!-- Aksi -->
                  <td>
                    <?php $role = session()->get('user')['role'] ?? ''; ?>

                    <?php if (in_array($role, ['administrator', 'petugas'])): ?>
                      <div class="d-flex gap-2">
                        <a href="<?= base_url('/ruang/edit/'.$r['id_room']) ?>" class="btn btn-warning btn-sm btn-action">✏️ Edit</a>
                        <form method="post" action="<?= base_url('/ruang/delete/'.$r['id_room']) ?>" onsubmit="return confirm('Yakin ingin hapus ruang ini?');">
                          <?= csrf_field() ?>
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-danger btn-sm btn-action">🗑️ Hapus</button>
                        </form>
                      </div>

                    <?php elseif ($role === 'peminjam'): ?>

    <?php 
        $link = base_url('peminjaman/ajukan?id_room=' . $r['id_room']);
    ?>

    <?php if ($r['status'] === 'Tersedia'): ?>

        <!-- Tersedia → tombol hijau, style sama -->
        <a href="<?= $link ?>" 
           class="btn btn-sm btn-action btn-success d-flex align-items-center gap-1">
            <span>💼</span> 
            <span>Ajukan</span>
        </a>

    <?php else: ?>

        <!-- Tidak tersedia → tombol warning, style sama -->
        <a href="<?= $link ?>" 
           class="btn btn-sm btn-action btn-warning text-dark d-flex align-items-center gap-1"
           title="Disarankan cek jadwal">
            <span>⚠️</span>
            <span>Ajukan (cek jadwal dulu)</span>
        </a>

    <?php endif; ?>

<?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-muted fst-italic py-3">Belum ada data ruang.</td>
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
