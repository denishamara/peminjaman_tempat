<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartRoom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="auth-body">

    <!-- NAVBAR -->
    <nav class="auth-navbar">
        <div class="container">
            <a href="<?= base_url('/') ?>" class="brand">
                <i class="fas fa-building"></i>
                SmartRoom
            </a>
            <a href="<?= base_url('/') ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </nav>

    <!-- REGISTER SECTION -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- Icon Header -->
            <div class="auth-icon">
                <i class="fas fa-user-plus"></i>
            </div>

            <!-- Title -->
            <h2 class="auth-title">Buat Akun Baru</h2>
            <p class="auth-subtitle">Daftar untuk mulai memesan ruangan</p>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="post" action="<?= base_url('auth/registerPost') ?>" class="auth-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-user-circle"></i>
                        <input 
                            type="text" 
                            id="username"
                            name="username" 
                            class="form-control" 
                            value="<?= old('username') ?>" 
                            placeholder="Pilih username unik" 
                            required
                            autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-key"></i>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-control" 
                            placeholder="Minimal 6 karakter" 
                            required
                            autocomplete="new-password">
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    <small class="form-text">Gunakan kombinasi huruf, angka, dan simbol</small>
                </div>

                <input type="hidden" name="role" value="peminjam">

                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <div class="auth-footer">
                <p>Sudah punya akun?
                    <a href="<?= base_url('auth/login') ?>">
                        Login di sini
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </p>
            </div>
        </div>

        <!-- Features -->
        <div class="auth-features">
            <div class="feature-item">
                <i class="fas fa-check-circle"></i>
                <span>Gratis & Mudah</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-clock"></i>
                <span>Booking 24/7</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <span>Aman & Terpercaya</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>