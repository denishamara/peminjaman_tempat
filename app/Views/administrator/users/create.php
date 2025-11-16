<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah User | SmartRoom</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome 6.4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    .form-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 0 auto;
    }

    .form-title {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
    }

    .form-label-modern {
      font-weight: 600;
      font-size: 0.875rem;
      color: #64748b;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-control-modern,
    .form-select-modern {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
      font-size: 0.875rem;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
      outline: none;
    }

    .btn-submit-modern {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-submit-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
      color: white;
    }

    .btn-cancel-modern {
      background: white;
      border: 2px solid #e2e8f0;
      color: #64748b;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-cancel-modern:hover {
      border-color: #667eea;
      color: #667eea;
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .form-card-modern {
        padding: 1.5rem;
      }

      .form-title {
        font-size: 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .form-card-modern {
        padding: 1rem;
        border-radius: 15px;
      }

      .form-title {
        font-size: 1.25rem;
      }

      .btn-submit-modern,
      .btn-cancel-modern {
        width: 100%;
        margin-bottom: 0.5rem;
      }
    }
  </style>
</head>

<body class="modern-dashboard">
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <div class="form-card-modern">
      <h2 class="form-title">
        <i class="fas fa-user-plus me-2"></i>
        Tambah User Baru
      </h2>

      <!-- Flash Messages -->
      <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>
          <ul class="mb-0">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('administrator/users/create') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label-modern">
            <i class="fas fa-user"></i>
            Username
          </label>
          <input
            type="text"
            id="username"
            name="username"
            class="form-control form-control-modern"
            value="<?= old('username') ?>"
            required
            placeholder="Masukkan username"
        <div class="mb-3">
          <label for="password" class="form-label-modern">
            <i class="fas fa-lock"></i>
            Password
          </label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control form-control-modern"
            required
            placeholder="Masukkan password (minimal 6 karakter)"
          >
        </div>

        <!-- Role -->
        <div class="mb-4">
          <label for="role" class="form-label-modern">
            <i class="fas fa-user-tag"></i>
            Role
          </label>
          <select id="role" name="role" class="form-select form-select-modern" required>
            <option value="" disabled <?= old('role') ? '' : 'selected' ?>>-- Pilih Role --</option>
            <option value="administrator" <?= old('role') === 'administrator' ? 'selected' : '' ?>>
              Administrator
            </option>
            <option value="petugas" <?= old('role') === 'petugas' ? 'selected' : '' ?>>
              Petugas
            </option>
            <option value="peminjam" <?= old('role') === 'peminjam' ? 'selected' : '' ?>>
              Peminjam
            </option>
          </select>
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2 justify-content-between">
          <a href="<?= base_url('/administrator/users') ?>" class="btn-cancel-modern">
            <i class="fas fa-times me-2"></i>
            Batal
          </a>
          <button type="submit" class="btn-submit-modern">
            <i class="fas fa-user-plus me-2"></i>
            Tambah User
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(() => {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
