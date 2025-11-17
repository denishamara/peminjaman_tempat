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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .sidebar {
        width: 250px;
        background: #fff;
        border-right: 1px solid #e2e8f0;
        height: 100vh;
        position: fixed;
        padding: 20px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        z-index: 1000;
    }
    
    .main-content {
        margin-left: 250px;
        padding: 40px;
        width: calc(100% - 250px);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .content-wrapper {
        width: 100%;
        max-width: 800px;
        display: flex;
        justify-content: center;
    }
    
    .card-modern {
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.15);
        overflow: hidden;
    }
    
    .card-header-purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 0;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .card-header-purple::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
        background-size: cover;
    }
    
    .card-header-purple h4 {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        position: relative;
        z-index: 1;
    }
    
    .card-body {
        padding: 2.5rem;
    }

    .profile-preview {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 5px solid #667eea;
        object-fit: cover;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .profile-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }
    
    .btn-delete-photo {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .btn-delete-photo:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
        color: white;
    }
    
    .btn-save-purple {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.85rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-save-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.6);
        color: white;
    }
    
    .btn-cancel {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        color: #475569;
        padding: 0.85rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #334155;
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .form-label {
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }
    
    .form-control {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0.85rem 1.25rem;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: #f8fafc;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.15);
        background: white;
    }

    .file-input-info {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
        margin-top: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 1199px) {
        .main-content {
            padding: 30px;
        }
        
        .card-body {
            padding: 2rem;
        }
    }

    @media (max-width: 991px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .sidebar.active {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 20px;
        }

        .content-wrapper {
            max-width: 100%;
        }
    }
    
    @media (max-width: 767px) {
        .main-content {
            padding: 15px;
        }

        .card-body {
            padding: 1.5rem;
        }
        
        .card-header-purple {
            padding: 1.5rem;
        }
        
        .card-header-purple h4 {
            font-size: 1.3rem;
        }
        
        .profile-preview {
            width: 120px;
            height: 120px;
        }
        
        .btn-delete-photo {
            width: 100%;
            justify-content: center;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-save-purple,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 575px) {
        .main-content {
            padding: 10px;
        }

        .card-body {
            padding: 1.25rem;
        }
        
        .card-header-purple {
            padding: 1.25rem;
        }
        
        .card-header-purple h4 {
            font-size: 1.1rem;
        }
        
        .profile-preview {
            width: 100px;
            height: 100px;
        }
        
        .btn-save-purple,
        .btn-cancel {
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
        }
        
        .btn-delete-photo {
            padding: 0.65rem 1.25rem;
            font-size: 0.85rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-modern {
        animation: fadeInUp 0.6s ease-out;
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
