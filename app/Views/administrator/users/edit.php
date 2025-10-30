<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>Edit User: <?= esc($user['username']) ?></h2>
    <a href="<?= base_url('administrator/users') ?>" class="btn btn-secondary mb-3">Kembali ke Daftar User</a>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('administrator/users/update/' . $user['id_user']) ?>" method="post">
        <?= csrf_field() ?>
        
        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                value="<?= old('username', $user['username']) ?>"
                required
            >
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password <small>(kosongkan jika tidak ingin diubah)</small></label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
            >
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required onchange="toggleNamaPetugas()">
                <option value="" disabled>-- Pilih Role --</option>
                <option value="administrator" <?= (old('role', $user['role']) === 'administrator') ? 'selected' : '' ?>>Administrator</option>
                <option value="petugas" <?= (old('role', $user['role']) === 'petugas') ? 'selected' : '' ?>>Petugas</option>
                <option value="peminjam" <?= (old('role', $user['role']) === 'peminjam') ? 'selected' : '' ?>>Peminjam</option>
            </select>
        </div>

        <!-- Nama Petugas -->
        <div class="mb-3" id="namaPetugasContainer" style="display: none;">
            <label for="nama_petugas" class="form-label">Nama Petugas</label>
            <input
                type="text"
                id="nama_petugas"
                name="nama_petugas"
                class="form-control"
                value="<?= old('nama_petugas', $nama_petugas ?? '') ?>"
            >
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<script>
function toggleNamaPetugas() {
    var role = document.getElementById('role').value;
    var namaContainer = document.getElementById('namaPetugasContainer');
    namaContainer.style.display = (role === 'petugas') ? 'block' : 'none';
}

// Jalankan saat halaman dimuat
window.onload = toggleNamaPetugas;
</script>
</body>
</html>
