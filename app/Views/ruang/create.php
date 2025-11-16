<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Ruang | SmartRoom</title>
  
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
      max-width: 700px;
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

    textarea.form-control-modern {
      resize: vertical;
      min-height: 100px;
    }

    .btn-submit-modern {
      background: linear-gradient(135deg, #10b981, #059669);
      border: none;
      color: white;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-submit-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(16, 185, 129, 0.6);
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
        <i class="fas fa-door-open me-2"></i>
        Tambah Ruangan Baru
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

      <form action="<?= base_url('ruang/store') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Nama Ruang -->
        <div class="mb-3">
          <label class="form-label-modern">
            <i class="fas fa-door-closed"></i>
            Nama Ruangan
          </label>
          <input type="text" 
                 name="nama_room" 
                 class="form-control form-control-modern" 
                 placeholder="Contoh: Ruang Meeting A" 
                 required>
        </div>

        <!-- Lokasi -->
        <div class="mb-3">
          <label class="form-label-modern">
            <i class="fas fa-map-marker-alt"></i>
            Lokasi
          </label>
          <input type="text" 
                 name="lokasi" 
                 class="form-control form-control-modern" 
                 placeholder="Contoh: Lantai 2, Gedung A" 
                 required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
          <label class="form-label-modern">
            <i class="fas fa-align-left"></i>
            Deskripsi
            <small class="text-muted">(opsional)</small>
          </label>
          <textarea name="deskripsi" 
                    class="form-control form-control-modern" 
                    placeholder="Deskripsi ruangan, fasilitas yang tersedia, dll." 
                    rows="4"></textarea>
        </div>

        <!-- Kapasitas -->
        <div class="mb-4">
          <label class="form-label-modern">
            <i class="fas fa-users"></i>
            Kapasitas (Orang)
          </label>
          <input type="number" 
                 name="kapasitas" 
                 class="form-control form-control-modern" 
                 placeholder="Masukkan jumlah kapasitas" 
                 min="1"
                 required>
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2 justify-content-between">
          <a href="<?= base_url('/ruang') ?>" class="btn-cancel-modern">
            <i class="fas fa-times me-2"></i>
            Batal
          </a>
          <button type="submit" class="btn-submit-modern">
            <i class="fas fa-save me-2"></i>
            Simpan Ruangan
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
