<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartRoom</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-body">

    <!-- Animated Background -->
    <div class="login-bg-animation">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="login-navbar">
        <a href="<?= base_url('/') ?>" class="brand">
            <i class="bi bi-building"></i>
            <span>SmartRoom</span>
        </a>
        <a href="<?= base_url('/') ?>" class="btn-landing">
            <i class="bi bi-house-door"></i>
            Beranda
        </a>
    </nav>

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Login Header -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h2>Selamat Datang!</h2>
                <p class="login-subtitle">Masuk untuk melanjutkan ke SmartRoom</p>
            </div>

            <!-- Pesan Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="post" action="<?= base_url('auth/loginPost') ?>" class="login-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>
                        <i class="bi bi-person"></i>
                        Username
                    </label>
                    <div class="input-wrapper">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="username" value="<?= old('username') ?>" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="bi bi-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Masuk</span>
                    <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="login-divider">
                <span>atau</span>
            </div>

            <!-- Register Link -->
            <p class="login-link">
                Belum punya akun?
                <a href="<?= base_url('auth/register') ?>">
                    <i class="bi bi-person-plus"></i>
                    Daftar Sekarang
                </a>
            </p>

            <!-- Footer Info -->
            <div class="login-footer">
                <p><i class="bi bi-shield-check"></i> Sistem Peminjaman Ruangan yang Aman</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Add animation on input focus
        const inputs = document.querySelectorAll('.login-form input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>

</body>
</html>