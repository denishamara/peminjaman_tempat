<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .container-fluid {
      padding: 2rem;
    }

    h2 {
      font-weight: 700;
      color: #0d6efd;
      margin-bottom: 1.5rem;
    }

    /* ====== TABEL ====== */
    .table {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .table th {
      background-color: #e9f1ff;
      color: #0d6efd;
      text-align: center;
      vertical-align: middle;
    }

    .table td {
      vertical-align: middle;
      text-align: center;
    }

    /* Tombol Edit & Hapus */
    .table .btn {
      min-width: 70px;
    }

    /* Responsif */
    @media (max-width: 992px) {
      .container-fluid {
        padding: 1rem;
      }
      h2 {
        font-size: 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .table td {
        text-align: center;
        vertical-align: middle;
      }
      .table td .btn {
        display: inline-block;
        margin: 3px 2px;
        width: auto;
        min-width: 70px;
        font-size: 14px;
        padding: 5px 10px;
      }
      .table td:last-child {
        white-space: nowrap;
      }
      .table-responsive {
        overflow-x: auto;
      }
    }

    /* Tombol Tambah User */
    .btn-success {
      border-radius: 8px;
      padding: 0.5rem 1rem;
    }

  </style>
</head>

<body>
    <?= view('layouts/sidebar') ?>
  <div class="main-content">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manajemen User</h2>
        <a href="<?= base_url('administrator/users/create') ?>" class="btn btn-success">+ Tambah User</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= esc($user['id_user']) ?></td>
                  <td><?= esc($user['username']) ?></td>
                  <td>
                    <?php if ($user['role'] === 'administrator'): ?>
                      <span class="badge bg-danger">Administrator</span>
                    <?php elseif ($user['role'] === 'petugas'): ?>
                      <span class="badge bg-warning text-dark">Petugas</span>
                    <?php else: ?>
                      <span class="badge bg-info text-dark">Peminjam</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?= base_url('administrator/users/edit/' . $user['id_user']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?= base_url('administrator/users/delete/' . $user['id_user']) ?>" method="post" style="display:inline;">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                  </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-3">Tidak ada data user.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
