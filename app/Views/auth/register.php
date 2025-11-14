<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        /* Tambahan styling ringan untuk notifikasi */
        .alert {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 500;
            animation: fadeIn 0.3s ease-in-out;
        }
        .alert-danger {
            background: #ffe5e5;
            border: 1px solid #ff8a8a;
            color: #b30000;
        }
        .alert-success {
            background: #e6ffe6;
            border: 1px solid #85e085;
            color: #1f7a1f;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="register-body">

    <div class="register-container">
        <h2>Form Registrasi User</h2>

        <!-- 🔔 Pesan Error / Sukses -->
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
