<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="login-body">

    <!-- NAVBAR -->
    <nav class="login-navbar">
        <a href="<?= base_url('/') ?>" class="brand">SmartRoom</a>
        <a href="<?= base_url('/') ?>" class="btn-landing">Kembali ke Beranda</a>
    </nav>

    <div class="login-container">
        <h2>Login ke Akun Anda</h2>

        <!-- Pesan Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('auth/loginPost') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= old('username') ?>" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <p class="login-link">
            Belum punya akun?
            <a href="<?= base_url('auth/register') ?>">Daftar di sini</a>
        </p>
    </div>

</body>
</html>