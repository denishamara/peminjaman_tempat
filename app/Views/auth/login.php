<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SmartRoom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

  <!-- Login Form -->
  <body class="login-body">
  <nav class="login-navbar">
    <a href="<?= base_url('/') ?>" class="brand">SmartRoom</a>
    <a href="<?= base_url('/') ?>" class="btn-landing">Kembali ke Landing</a>
  </nav>

  <div class="container">
    <h2>Login</h2>
    <form action="<?= base_url('auth/login') ?>" method="post">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" placeholder="Masukkan username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Masukkan password" required>

      <button type="submit">Masuk</button>
      <a href="<?= base_url('auth/register') ?>" class="btn-secondary">Belum punya akun?</a>
    </form>
  </div>
</body>

  <footer>
    <p>© <?= date('Y') ?> SmartRoom — Sistem Peminjaman Ruang.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
