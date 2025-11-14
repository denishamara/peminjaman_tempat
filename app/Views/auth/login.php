<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SmartRoom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <style>
  /* Turunkan card login sedikit */
  .login-body {
      padding-top: 90px; /* naik-turun dari sini */
  }

  /* HP supaya tetap enak */
  @media (max-width: 576px) {
      .login-body {
          padding-top: 190px;
      }
  }
</style>

</head>

<body class="login-body">
  <nav class="login-navbar">
    <a href="<?= base_url('/') ?>" class="brand">SmartRoom</a>
    <a href="<?= base_url('/') ?>" class="btn-landing">Kembali ke Landing</a>
  </nav>

  <div class="container mt-5" style="max-width: 420px;">
    <h2 class="fw-bold text-center mb-4 text-primary">Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('auth/loginPost') ?>" method="post" autocomplete="off">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required autocomplete="new-password">
      </div>

      <button type="submit" class="btn btn-primary w-100">Masuk</button>
      <a href="<?= base_url('auth/register') ?>" class="btn btn-link w-100 mt-2">Belum punya akun?</a>
    </form>
  </div>

  <footer class="text-center mt-5 text-muted">
    <p>© <?= date('Y') ?> SmartRoom — Sistem Peminjaman Ruang.</p>
  </footer>

  <!-- 🚫 Cegah tombol Back -->
  <script>
    history.pushState(null, "", location.href);
    window.onpopstate = function() {
      history.pushState(null, "", location.href);
    };
  </script>
</body>
</html>
