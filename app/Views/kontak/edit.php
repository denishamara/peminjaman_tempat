<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    :root {
      --primary-color: #4361ee;
      --primary-light: #eef2ff;
      --success-color: #10b981;
      --text-dark: #1e293b;
      --text-light: #64748b;
      --border-color: #e2e8f0;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: var(--text-dark);
      line-height: 1.6;
    }
    
    /* Main Content Area */
    .main-content {
      margin-left: 260px;
      padding: 2rem;
      min-height: 100vh;
      transition: all 0.3s ease;
    }
    
    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 1.5rem;
      }
    }
    
    @media (max-width: 575.98px) {
      .main-content {
        padding: 1rem;
      }
    }
    
    /* Header Section */
    .page-header {
      margin-bottom: 2rem;
    }
    
    .page-title {
      font-weight: 700;
      color: var(--text-dark);
      font-size: 1.75rem;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .page-subtitle {
      color: var(--text-light);
      font-size: 1rem;
    }
    
    /* Form Card */
    .form-card {
      background: white;
      border-radius: 12px;
      box-shadow: var(--shadow);
      padding: 2rem;
      transition: all 0.3s ease;
    }
    
    .form-card:hover {
      box-shadow: var(--shadow-lg);
    }
    
    @media (max-width: 575.98px) {
      .form-card {
        padding: 1.5rem;
      }
    }
    
    /* Form Elements */
    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .form-control {
      padding: 0.75rem 1rem;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.2s ease;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    
    /* Button Styles */
    .btn-submit {
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s ease;
      box-shadow: 0 2px 4px rgba(67, 97, 238, 0.2);
    }
    
    .btn-submit:hover {
      background-color: #3a56d4;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
    }
    
    .btn-cancel {
      background-color: white;
      color: var(--text-light);
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s ease;
    }
    
    .btn-cancel:hover {
      background-color: #f8fafc;
      color: var(--text-dark);
    }
    
    /* Action Buttons Container */
    .action-buttons {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
      margin-top: 1.5rem;
    }
    
    @media (max-width: 575.98px) {
      .action-buttons {
        flex-direction: column;
      }
      
      .action-buttons .btn {
        width: 100%;
        justify-content: center;
      }
    }
    
    /* Icon Styles */
    .icon-primary {
      color: var(--primary-color);
    }
    
    .icon-success {
      color: var(--success-color);
    }
    
    /* Input Group with Icon */
    .input-group-icon {
      position: relative;
    }
    
    .input-group-icon .form-control {
      padding-left: 2.75rem;
    }
    
    .input-group-icon .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      z-index: 5;
    }
    
    /* Alert Styles */
    .alert {
      border-radius: 8px;
      border: none;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .alert-success {
      background-color: #ecfdf5;
      color: #065f46;
    }
    
    .alert-danger {
      background-color: #fef2f2;
      color: #991b1b;
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease forwards;
    }
  </style>
</head>
<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
      <h1 class="page-title">
        <i class="fas fa-phone-alt icon-primary"></i>
        <?= esc($title) ?>
      </h1>
      <p class="page-subtitle">
        <i class="fas fa-info-circle"></i>
        Perbarui informasi kontak petugas untuk komunikasi yang lebih baik
      </p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success fade-in">
        <i class="fas fa-check-circle"></i>
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger fade-in">
        <i class="fas fa-exclamation-circle"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card fade-in">
      <form action="<?= base_url('administrator/kontak/update/' . $petugas['id_user']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-4">
          <label for="telepon" class="form-label">
            <i class="fas fa-mobile-alt icon-primary"></i>
            Nomor WhatsApp Petugas
          </label>
          <div class="input-group-icon">
            <i class="fas fa-phone input-icon"></i>
            <input 
              type="text" 
              name="telepon" 
              id="telepon" 
              class="form-control"
              value="<?= esc($petugas['telepon']) ?>" 
              placeholder="Contoh: 6281234567890"
              required>
          </div>
          <div class="form-text mt-2">
            <i class="fas fa-info-circle text-muted"></i>
            Pastikan nomor WhatsApp aktif dan menggunakan format internasional (contoh: 6281234567890)
          </div>
        </div>

        <div class="action-buttons">
          <button type="submit" class="btn btn-submit">
            <i class="fas fa-save"></i>
            Simpan Perubahan
          </button>
          <a href="<?= base_url('administrator/kontak') ?>" class="btn btn-cancel">
            <i class="fas fa-arrow-left"></i>
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Animasi untuk form elements
    document.addEventListener('DOMContentLoaded', function() {
      // Fade in form elements with delay
      const formElements = document.querySelectorAll('.form-control, .form-label, .btn');
      formElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(10px)';
        el.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }, 100 + (index * 50));
      });
      
      // Auto-dismiss alerts after 5 seconds
      setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
          if (alert.classList.contains('show')) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
          } else {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
              alert.style.display = 'none';
            }, 500);
          }
        });
      }, 5000);
    });
  </script>
</body>
</html>