<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="register-body">

    <div class="register-container">
        <h2>Form Registrasi User</h2>

        <form method="post" action="<?= base_url('auth/register') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <!-- Role default peminjam (tidak ditampilkan) -->
            <input type="hidden" name="role" value="peminjam">

            <button type="submit">Daftar Sekarang</button>
        </form>

        <p class="login-link">Sudah punya akun?
            <a href="<?= base_url('auth/login') ?>">Login di sini</a>
        </p>
    </div>

</body>
</html>
