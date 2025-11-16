<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="register-body">

    <!-- NAVBAR -->
    <nav class="login-navbar">
        <a href="<?= base_url('/') ?>" class="brand">SmartRoom</a>
        <a href="<?= base_url('/') ?>" class="btn-landing">Kembali ke Beranda</a>
    </nav>

    <div class="register-container">
        <h2>Form Registrasi User</h2>

        <!-- Pesan Error / Sukses -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('auth/registerPost') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= old('username') ?>" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <input type="hidden" name="role" value="peminjam">

            <button type="submit">Daftar Sekarang</button>
        </form>

        <p class="login-link">
            Sudah punya akun?
            <a href="<?= base_url('auth/login') ?>">Login di sini</a>
        </p>
    </div>

</body>
</html>