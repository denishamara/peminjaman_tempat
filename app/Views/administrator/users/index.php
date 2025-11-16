<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen User | SmartRoom</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome 6.4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    /* Page Header Modern */
    .page-header-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .page-title {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    /* Stats Summary Cards */
    .stats-summary {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-summary-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 16px;
      padding: 1.5rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-summary-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, var(--color-from), var(--color-to));
    }

    .stat-summary-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-summary-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, var(--color-from), var(--color-to));
      color: white;
    }

    .stat-summary-number {
      font-size: 2rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--color-from), var(--color-to));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-summary-label {
      color: #64748b;
      font-weight: 600;
      font-size: 0.875rem;
    }

    /* Add User Button */
    .btn-add-modern {
      background: linear-gradient(135deg, #10b981, #059669);
      border: none;
      color: white;
      padding: 0.85rem 1.75rem;
      border-radius: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-add-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(16, 185, 129, 0.6);
      color: white;
    }

    /* Table Card */
    .table-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    /* Table Wrapper for Horizontal Scroll */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin: 0 -2rem;
      padding: 0 2rem;
    }

    @media (max-width: 768px) {
      .table-responsive {
        margin: 0 -1.25rem;
        padding: 0 1.25rem;
      }
    }

    @media (max-width: 576px) {
      .table-responsive {
        margin: 0 -1rem;
        padding: 0 1rem;
      }
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid rgba(102, 126, 234, 0.1);
    }

    .table-title-icon {
      font-weight: 800;
      font-size: 1.5rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .user-count-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Modern Table */
    .modern-users-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 800px;
    }

    .modern-users-table thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .modern-users-table thead th {
      padding: 1.25rem 1rem;
      font-weight: 600;
      text-align: left;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .modern-users-table thead th:first-child {
      border-top-left-radius: 12px;
    }

    .modern-users-table thead th:last-child {
      border-top-right-radius: 12px;
    }

    .modern-users-table tbody tr {
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-users-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      transform: scale(1.01);
    }

    .modern-users-table tbody td {
      padding: 1.25rem 1rem;
      vertical-align: middle;
    }

    /* User Avatar */
    .user-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.1rem;
      color: white;
      margin-right: 0.75rem;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-name {
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 0.25rem;
    }

    .user-id {
      font-size: 0.875rem;
      color: #64748b;
    }

    /* Role Badges */
    .role-badge-modern {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .role-administrator {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .role-petugas {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .role-peminjam {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-action {
      padding: 0.5rem 1rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.875rem;
      border: none;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      white-space: nowrap;
      min-width: 90px;
      justify-content: center;
    }

    .btn-edit {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
      color: white;
    }

    .btn-delete {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
      color: white;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
    }

    .empty-state-icon {
      font-size: 5rem;
      color: #cbd5e1;
      margin-bottom: 1.5rem;
      opacity: 0.7;
    }

    .empty-state h4 {
      color: #64748b;
      font-weight: 700;
      margin-bottom: 0.75rem;
      font-size: 1.25rem;
    }

    .empty-state p {
      color: #94a3b8;
      margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .page-header-card {
        padding: 1.5rem;
      }

      .page-title {
        font-size: 1.75rem;
      }

      .stats-summary {
        grid-template-columns: repeat(2, 1fr);
      }

      .table-card-modern {
        padding: 1.5rem;
      }

      .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
    }

    @media (max-width: 768px) {
      .page-header-card {
        padding: 1.25rem;
      }

      .page-title {
        font-size: 1.5rem;
      }

      .stats-summary {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .stat-summary-card {
        padding: 1.25rem;
      }

      .stat-summary-number {
        font-size: 1.75rem;
      }

      .table-card-modern {
        padding: 1.25rem;
      }

      .table-title-icon {
        font-size: 1.25rem;
      }

      .btn-add-modern {
        width: 100%;
        justify-content: center;
      }

      /* Keep action buttons inline on mobile */
      .action-buttons {
        flex-direction: row;
        gap: 0.35rem;
      }

      .btn-action {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        min-width: 80px;
        flex: 1;
      }

      /* Adjust table for mobile - ensure horizontal scroll */
      .modern-users-table {
        font-size: 0.875rem;
        min-width: 700px;
      }

      .modern-users-table thead th,
      .modern-users-table tbody td {
        padding: 0.875rem 0.5rem;
      }
    }

    @media (max-width: 576px) {
      .page-title {
        font-size: 1.25rem;
      }

      .page-header-card,
      .table-card-modern {
        padding: 1rem;
        border-radius: 15px;
      }

      .stat-summary-card {
        padding: 1rem;
      }

      .stat-summary-icon {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
      }

      .stat-summary-number {
        font-size: 1.5rem;
      }

      .stat-summary-label {
        font-size: 0.75rem;
      }

      .table-title-icon {
        font-size: 1rem;
      }

      .user-count-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      /* Very compact table with horizontal scroll */
      .modern-users-table {
        font-size: 0.75rem;
        min-width: 650px;
      }

      .modern-users-table thead th,
      .modern-users-table tbody td {
        padding: 0.625rem 0.35rem;
      }

      .user-avatar {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
      }

      .user-name {
        font-size: 0.875rem;
      }

      .user-id {
      .role-badge-modern {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      .btn-action {
        padding: 0.45rem 0.65rem;
        font-size: 0.7rem;
        min-width: 70px;
      }

      .empty-state {
        padding: 2rem 1rem;
      }
      .empty-state {
        padding: 2rem 1rem;
      }

      .empty-state-icon {
        font-size: 3rem;
      }
    }
  </style>
</head>

<body class="modern-dashboard">
  <?= view('layouts/sidebar') ?>
  
  <div class="main-content">
    <!-- Page Header -->
    <div class="page-header-card">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
          <h1 class="page-title">
            <i class="fas fa-users-cog me-2"></i>
            Manajemen Pengguna
          </h1>
          <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Kelola seluruh pengguna sistem peminjaman ruangan
          </p>
        </div>
        <a href="<?= base_url('administrator/users/create') ?>" class="btn-add-modern">
          <i class="fas fa-user-plus"></i>
          Tambah Pengguna Baru
        </a>
      </div>
    </div>

    <!-- Stats Summary -->
    <div class="stats-summary">
      <div class="stat-summary-card" style="--color-from: #667eea; --color-to: #764ba2;">
        <div class="stat-summary-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-summary-number"><?= count($users) ?></div>
        <div class="stat-summary-label">Total Pengguna</div>
      </div>

      <div class="stat-summary-card" style="--color-from: #ef4444; --color-to: #dc2626;">
        <div class="stat-summary-icon">
          <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-summary-number">
          <?= count(array_filter($users, fn($u) => $u['role'] === 'administrator')) ?>
        </div>
        <div class="stat-summary-label">Administrator</div>
      </div>

      <div class="stat-summary-card" style="--color-from: #f59e0b; --color-to: #d97706;">
        <div class="stat-summary-icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <div class="stat-summary-number">
          <?= count(array_filter($users, fn($u) => $u['role'] === 'petugas')) ?>
        </div>
        <div class="stat-summary-label">Petugas</div>
      </div>

      <div class="stat-summary-card" style="--color-from: #3b82f6; --color-to: #2563eb;">
        <div class="stat-summary-icon">
          <i class="fas fa-user"></i>
        </div>
        <div class="stat-summary-number">
          <?= count(array_filter($users, fn($u) => $u['role'] === 'peminjam')) ?>
        </div>
        <div class="stat-summary-label">Peminjam</div>
      </div>
    </div>

    <!-- Users Table -->
    <div class="table-card-modern">
      <div class="table-header">
        <h5 class="table-title-icon">
          <i class="fas fa-list-ul"></i>
          Daftar Pengguna Sistem
        </h5>
        <span class="user-count-badge">
          <i class="fas fa-users me-1"></i>
          <?= count($users) ?> Pengguna
        </span>
      </div>

      <div class="table-responsive">
        <table class="modern-users-table">
          <thead>
            <tr>
              <th><i class="fas fa-hashtag me-2"></i>ID</th>
              <th><i class="fas fa-user me-2"></i>Informasi Pengguna</th>
              <th><i class="fas fa-id-badge me-2"></i>Role</th>
              <th style="text-align: center;"><i class="fas fa-cog me-2"></i>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users)): ?>
              <?php 
              $colors = ['#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899'];
              foreach ($users as $index => $user): 
                $initial = strtoupper(substr($user['username'], 0, 1));
                $avatarColor = $colors[$index % count($colors)];
              ?>
                <tr>
                  <td>
                    <span class="fw-bold" style="color: #667eea;">
                      #<?= esc($user['id_user']) ?>
                    </span>
                  </td>
                  <td>
                    <div class="user-info">
                      <div class="user-avatar" style="background: linear-gradient(135deg, <?= $avatarColor ?>, <?= $avatarColor ?>dd);">
                        <?= $initial ?>
                      </div>
                      <div>
                        <div class="user-name"><?= esc($user['username']) ?></div>
                        <div class="user-id">
                          <i class="fas fa-envelope me-1"></i>
                          User ID: <?= esc($user['id_user']) ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?php if ($user['role'] === 'administrator'): ?>
                      <span class="role-badge-modern role-administrator">
                        <i class="fas fa-user-shield"></i>
                        Administrator
                      </span>
                    <?php elseif ($user['role'] === 'petugas'): ?>
                      <span class="role-badge-modern role-petugas">
                        <i class="fas fa-user-tie"></i>
                        Petugas
                      </span>
                    <?php else: ?>
                      <span class="role-badge-modern role-peminjam">
                        <i class="fas fa-user"></i>
                        Peminjam
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="<?= base_url('administrator/users/edit/' . $user['id_user']) ?>" 
                         class="btn-action btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit
                      </a>
                      <form action="<?= base_url('administrator/users/delete/' . $user['id_user']) ?>" 
                            method="post" 
                            style="display:inline;"
                            onsubmit="return confirm('⚠️ Yakin ingin menghapus pengguna ini?\n\nUsername: <?= esc($user['username']) ?>\nRole: <?= esc(ucfirst($user['role'])) ?>\n\nData yang dihapus tidak dapat dikembalikan!')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn-action btn-delete">
                          <i class="fas fa-trash-alt"></i>
                          Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4">
                  <div class="empty-state">
                    <div class="empty-state-icon">
                      <i class="fas fa-users-slash"></i>
                    </div>
                    <h4>Belum Ada Pengguna</h4>
                    <p>Belum ada pengguna yang terdaftar dalam sistem</p>
                    <a href="<?= base_url('administrator/users/create') ?>" class="btn-add-modern">
                      <i class="fas fa-user-plus"></i>
                      Tambah Pengguna Pertama
                    </a>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Animate cards on load
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.stat-summary-card, .table-card-modern');
      cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
          card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 100);
      });

      // Animate table rows
      const rows = document.querySelectorAll('.modern-users-table tbody tr');
      rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
          row.style.transition = 'all 0.4s ease';
          row.style.opacity = '1';
          row.style.transform = 'translateX(0)';
        }, 300 + (index * 50));
      });
    });
  </script>
</body>
</html>
