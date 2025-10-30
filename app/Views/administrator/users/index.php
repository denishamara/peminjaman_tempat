<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light modern-dashboard">

    <!-- Sidebar -->
    <?= view('layouts/sidebar') ?>

    <!-- Konten Utama -->
    <div class="main-content py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Manajemen User</h2>
            <a href="<?= base_url('administrator/users/create') ?>" class="btn btn-success shadow-sm">
                + Tambah User
            </a>
        </div>

        <!-- Flash message -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Card Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($users)): ?>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><strong><?= esc($user['id_user']) ?></strong></td>
                                        <td><?= esc($user['username']) ?></td>
                                        <td>
                                            <?php 
                                                $role = strtolower($user['role']);
                                                $badgeClass = match ($role) {
                                                    'administrator' => 'bg-danger',
                                                    'petugas' => 'bg-warning text-dark',
                                                    'peminjam' => 'bg-info text-dark',
                                                    default => 'bg-secondary'
                                                };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= ucfirst(esc($user['role'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="<?= base_url('administrator/users/edit/'.$user['id_user']) ?>" 
                                                   class="btn btn-sm btn-warning">Edit</a>

                                                <form action="<?= base_url('administrator/users/delete/'.$user['id_user']) ?>" 
                                                      method="post" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-muted fst-italic py-4 text-center">
                                        Belum ada data user.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
