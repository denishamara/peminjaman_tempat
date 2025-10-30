<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>Tambah User Baru</h2>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('administrator/users/create') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                value="<?= old('username') ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required onchange="toggleNamaPetugas()">
                <option value="" disabled <?= old('role') ? '' : 'selected' ?>>-- Pilih Role --</option>
                <option value="administrator" <?= old('role') === 'administrator' ? 'selected' : '' ?>>Administrator</option>
                <option value="petugas" <?= old('role') === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="peminjam" <?= old('role') === 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
            </select>
        </div>

        <!-- Nama Petugas hanya muncul jika role = petugas -->
        <div class="mb-3" id="namaPetugasContainer" style="display: none;">
            <label for="nama_petugas" class="form-label">Nama Petugas</label>
            <input
                type="text"
                id="nama_petugas"
                name="nama_petugas"
                class="form-control"
                value="<?= old('nama_petugas') ?>"
            >
        </div>

        <button type="submit" class="btn btn-primary">Tambah User</button>
        <a href="<?= base_url('administrator/users') ?>" class="btn btn-secondary mb-3">Kembali ke Daftar User</a>
    </form>
</div>

<script>
function toggleNamaPetugas() {
    var role = document.getElementById('role').value;
    var container = document.getElementById('namaPetugasContainer');
    container.style.display = (role === 'petugas') ? 'block' : 'none';
}

// Panggil saat halaman dimuat (agar tetap tampil jika ada old value)
window.onload = function() {
    toggleNamaPetugas();
};
</script>
</body>
</html>
