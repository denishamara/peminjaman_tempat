<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil | SmartRoom</title>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome 6.4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  
  <style>
    body {
        background: #f7f8fa;
        display: flex;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    
    .sidebar {
        width: 250px;
        background: #fff;
        border-right: 1px solid #ddd;
        height: 100vh;
        position: fixed;
        padding: 20px;
    }
    
    .main-content {
        margin-left: 270px;
        padding: 40px;
        width: calc(100% - 270px);
    }
    
    .card-modern {
        max-width: 650px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
    }
    
    .card-header-purple {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 1.5rem;
      border-radius: 20px 20px 0 0;
      border: none;
    }
    
    .card-header-purple h4 {
      margin: 0;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .profile-preview {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid #667eea;
      object-fit: cover;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-delete-photo {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      border: none;
      color: white;
      padding: 0.6rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.875rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-delete-photo:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
      color: white;
    }
    
    .btn-save-purple {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      font-weight: 700;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-save-purple:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
      color: white;
    }
    
    .btn-cancel {
      background: #e2e8f0;
      border: none;
      color: #475569;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-cancel:hover {
      background: #cbd5e1;
      color: #334155;
      transform: translateY(-2px);
    }
    
    .form-label {
      font-weight: 600;
      color: #475569;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .form-control {
      border-radius: 10px;
      border: 2px solid #e2e8f0;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .main-content {
        margin-left: 0;
        width: 100%;
        padding: 2rem 1rem;
      }
      
      .card-modern {
        max-width: 100%;
      }
    }
    
    @media (max-width: 767px) {
      .main-content {
        padding: 1.5rem 0.75rem;
      }
      
      .card-header-purple {
        padding: 1.25rem;
      }
      
      .card-header-purple h4 {
        font-size: 1.25rem;
      }
      
      .profile-preview {
        width: 100px;
        height: 100px;
      }
      
      .btn-delete-photo {
        width: 100%;
        justify-content: center;
        margin-top: 0.75rem;
      }
      
      .btn-save-purple,
      .btn-cancel {
        width: 100%;
        justify-content: center;
        margin-bottom: 0.5rem;
      }
    }
    
    @media (max-width: 575px) {
      .card-header-purple h4 {
        font-size: 1.1rem;
      }
      
      .btn-save-purple,
      .btn-cancel {
        padding: 0.65rem 1.5rem;
        font-size: 0.875rem;
      }
      
      .btn-delete-photo {
        padding: 0.55rem 1.1rem;
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body>
<?php $user = session()->get('user'); ?>
<?= view('layouts/sidebar') ?>

<div class="main-content">
    <div class="card-modern">
        <div class="card-header-purple">
            <h4>
                <i class="fas fa-user-edit"></i>
                Edit Profil
            </h4>
        </div>
        
        <div class="p-4">
            <form method="post" enctype="multipart/form-data" action="<?= base_url('/profile/update') ?>">
                <?= csrf_field() ?>

                <!-- Username Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
                </div>

                <!-- Photo Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-camera"></i>
                        Foto Profil
                    </label>
                    <div class="d-flex flex-column flex-md-row align-items-start gap-3">
                        <img src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
                             alt="Foto Sekarang" 
                             class="profile-preview"
                             onerror="this.src='<?= base_url('images/profile/default.png') ?>'">
                        <div class="flex-grow-1 w-100">
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i>
                                Format: JPG, PNG, JPEG (Max: 2MB)
                            </small>
                            
                            <?php if (!empty($user['foto']) && $user['foto'] !== 'default.jpeg'): ?>
                                <a href="<?= base_url('/profile/deletePhoto') ?>" 
                                   class="btn-delete-photo mt-3"
                                   onclick="return confirm('⚠️ Yakin ingin menghapus foto profil dan kembali ke default?')">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus Foto
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-md-row justify-content-between gap-2 pt-3 border-top">
                    <a href="<?= base_url('/profile') ?>" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" class="btn-save-purple">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
