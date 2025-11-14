<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 260px; padding: 30px; }
        @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 15px; } }
    </style>
</head>
<body>
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit User</h4>
            </div>
            <div class="card-body">

                <!-- Flashdata -->
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/administrator/users/update/' . $userToEdit['id_user']) ?>">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= esc($userToEdit['username']) ?>" required>
                    </div>

                    <!-- Password (kosongkan jika tidak ingin diubah) -->
                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="administrator" <?= $userToEdit['role']=='administrator'?'selected':'' ?>>Administrator</option>
                            <option value="petugas" <?= $userToEdit['role']=='petugas'?'selected':'' ?>>Petugas</option>
                            <option value="peminjam" <?= $userToEdit['role']=='peminjam'?'selected':'' ?>>Peminjam</option>
                        </select>
                    </div>

                    <!-- Nama Petugas (hanya muncul jika role = petugas) -->
                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" 
                               value="<?= esc($nama_petugas ?? '') ?>" 
                               placeholder="Isi jika role Petugas">
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('/administrator/users') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
