<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Ruang | SmartRoom</title>
  
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

    /* Stats Summary */
    .stats-summary {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

    /* Add Room Button */
    .btn-add-modern {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 0.85rem 1.75rem;
      border-radius: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-add-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
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

    .room-count-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Modern Table */
    .modern-rooms-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .modern-rooms-table thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .modern-rooms-table thead th {
      padding: 1.25rem 1rem;
      font-weight: 600;
      text-align: left;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .modern-rooms-table thead th:first-child {
      border-top-left-radius: 12px;
    }

    .modern-rooms-table thead th:last-child {
      border-top-right-radius: 12px;
    }

    .modern-rooms-table tbody tr {
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-rooms-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      transform: scale(1.01);
    }

    .modern-rooms-table tbody td {
      padding: 1.25rem 1rem;
      vertical-align: middle;
    }

    /* Room Info */
    .room-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-right: 1rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .room-info {
      display: flex;
      align-items: center;
    }

    .room-name {
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 0.25rem;
      font-size: 1rem;
    }

    .room-location {
      font-size: 0.875rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    /* Capacity Badge */
    .capacity-badge {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Status Badges */
    .status-badge-modern {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .status-tersedia {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .status-tidak-tersedia {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .status-reguler {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
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
      text-align: center;
      white-space: normal;
      line-height: 1.3;
    }

    .btn-edit {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
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

    .btn-submit {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
      color: white;
    }

    .btn-submit-warning {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-submit-warning:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
      color: white;
    }

    .btn-submit-danger {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-submit-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
      color: white;
    }

    .btn-check {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-check:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
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

      .action-buttons {
        flex-direction: column;
        width: 100%;
        gap: 0.4rem;
      }

      .btn-action {
        width: 100%;
        justify-content: center;
        padding: 0.6rem 1rem;
        white-space: normal;
        text-align: center;
      }

      .room-info {
        flex-direction: row;
        align-items: center;
      }

      /* Adjust table for mobile */
      .modern-rooms-table {
        font-size: 0.875rem;
      }

      .modern-rooms-table thead th,
      .modern-rooms-table tbody td {
        padding: 0.875rem 0.5rem;
      }

      /* Hide description column on tablet */
      .modern-rooms-table th:nth-child(3),
      .modern-rooms-table td:nth-child(3) {
        display: none;
      }
    }

    @media (max-width: 576px) {
      .page-title {
        font-size: 1.25rem;
      }

      .page-header-card,
      .filter-card-modern,
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

      .room-count-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      /* Very compact table */
      .modern-rooms-table {
        font-size: 0.75rem;
      }

      .modern-rooms-table thead th,
      .modern-rooms-table tbody td {
        padding: 0.625rem 0.35rem;
      }

      .room-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
        margin-right: 0.5rem;
      }

      .room-name {
        font-size: 0.875rem;
      }

      .room-location {
        font-size: 0.75rem;
      }

      .capacity-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      .status-badge-modern {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      .btn-action {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        white-space: normal;
        text-align: center;
        line-height: 1.2;
      }

      /* Adjust button text for small screens */
      .btn-action i {
        margin-right: 0.25rem;
        flex-shrink: 0;
      } padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
      }

      /* Hide capacity column on very small screens */
      .modern-rooms-table th:nth-child(4),
      .modern-rooms-table td:nth-child(4) {
        display: none;
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
            <i class="fas fa-door-open me-2"></i>
            Manajemen Ruangan
          </h1>
          <p class="text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Kelola seluruh ruangan dan ketersediaannya
          </p>
        </div>
        <?php if (in_array(session()->get('user')['role'] ?? '', ['administrator', 'petugas'])): ?>
          <a href="<?= base_url('/ruang/create') ?>" class="btn-add-modern">
            <i class="fas fa-plus-circle"></i>
            Tambah Ruangan Baru
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Stats Summary -->
    <div class="stats-summary">
      <!-- Total Ruangan -->
      <div class="stat-summary-card" style="--color-from: #667eea; --color-to: #764ba2;">
        <div class="stat-summary-icon">
          <i class="fas fa-door-open"></i>
        </div>
        <div class="stat-summary-number" id="totalRuangan">0</div>
        <div class="stat-summary-label">Total Ruangan</div>
      </div>

      <!-- Tersedia -->
      <div class="stat-summary-card" style="--color-from: #10b981; --color-to: #059669;">
        <div class="stat-summary-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-summary-number" id="totalTersedia">0</div>
        <div class="stat-summary-label">Ruangan Tersedia</div>
      </div>

      <!-- Tidak Tersedia -->
      <div class="stat-summary-card" style="--color-from: #ef4444; --color-to: #dc2626;">
        <div class="stat-summary-icon">
          <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-summary-number" id="totalTidakTersedia">0</div>
        <div class="stat-summary-label">Tidak Tersedia</div>
      </div>

      <!-- Total Kapasitas -->
      <div class="stat-summary-card" style="--color-from: #3b82f6; --color-to: #2563eb;">
        <div class="stat-summary-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-summary-number" id="totalKapasitas">0</div>
        <div class="stat-summary-label">Total Kapasitas</div>
      </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="table-card-modern">
      <div class="table-header">
        <h3 class="table-title-icon">
          <i class="fas fa-list"></i>
          Daftar Ruangan
        </h3>
        <span class="room-count-badge">
          <i class="fas fa-building me-1"></i>
          <span id="tableCount">0</span> Ruangan
        </span>
      </div>

      <?php if (!empty($ruangs)): ?>
        <div class="table-responsive">
          <table class="modern-rooms-table">
            <thead>
              <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Ruangan</th>
                <th style="width: 20%;">Deskripsi</th>
                <th style="width: 12%;">Kapasitas</th>
                <th style="width: 13%;">Status</th>
                <th style="width: 25%;" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($ruangs as $r): ?>
                <tr class="room-row">
                  <td><?= $no++ ?></td>
                  <td>
                    <div class="room-info">
                      <div class="room-icon">
                        <i class="fas fa-door-open"></i>
                      </div>
                      <div>
                        <div class="room-name"><?= esc($r['nama_room'] ?? $r['nama_ruang'] ?? '') ?></div>
                        <div class="room-location">
                          <i class="fas fa-map-marker-alt"></i>
                          <?= esc($r['lokasi']) ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-muted" style="font-size: 0.875rem;">
                      <?= esc($r['deskripsi']) ?>
                    </span>
                  </td>
                  <td>
                    <span class="capacity-badge">
                      <i class="fas fa-users"></i>
                      <?= esc($r['kapasitas']) ?> Orang
                    </span>
                  </td>
                  <td>
                    <?php
                      $statusClass = 'status-reguler';
                      $statusIcon = 'fa-calendar-alt';
                      $statusText = ucfirst(esc($r['status']));
                      
                      if (strtolower($r['status']) === 'tersedia') {
                        $statusClass = 'status-tersedia';
                        $statusIcon = 'fa-check-circle';
                      } elseif (strtolower($r['status']) === 'tidak tersedia') {
                        $statusClass = 'status-tidak-tersedia';
                        $statusIcon = 'fa-times-circle';
                      }
                    ?>
                    <span class="status-badge-modern <?= $statusClass ?>">
                      <i class="fas <?= $statusIcon ?>"></i>
                      <?= $statusText ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <?php if (in_array(session()->get('user')['role'] ?? '', ['administrator', 'petugas'])): ?>
                        <a href="<?= base_url('/ruang/edit/' . ($r['id_room'] ?? $r['id'] ?? '')) ?>" class="btn-action btn-edit">
                          <i class="fas fa-edit"></i>
                          Edit
                        </a>
                        <form action="<?= base_url('ruang/delete/' . ($r['id_room'] ?? $r['id'] ?? '')) ?>" 
                          method="POST" 
                          style="display: inline;" 
                          onsubmit="return confirm('⚠️ Yakin ingin menghapus ruangan: <?= esc($r['nama_room']) ?>?\n\nData yang terhapus tidak dapat dikembalikan!');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-action btn-delete">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                      <?php else: ?>
                        <?php if (strtolower($r['status']) === 'tersedia'): ?>
                          <a href="<?= base_url('/peminjaman/ajukan?ruang_id=' . ($r['id_room'] ?? $r['id'] ?? '')) ?>" class="btn-action btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Ajukan Peminjaman
                          </a>
                        <?php elseif (strtolower($r['status']) === 'tidak tersedia'): ?>
                          <a href="<?= base_url('/peminjaman/ajukan?ruang_id=' . ($r['id_room'] ?? $r['id'] ?? '')) ?>" class="btn-action btn-submit-danger">
                            <i class="fas fa-paper-plane"></i>
                            Ajukan (Disarankan Cek Jadwal)
                          </a>
                        <?php else: ?>
                          <!-- Status Reguler / Terpakai -->
                          <a href="<?= base_url('/peminjaman/ajukan?ruang_id=' . ($r['id_room'] ?? $r['id'] ?? '')) ?>" class="btn-action btn-submit-warning">
                            <i class="fas fa-paper-plane"></i>
                            Ajukan (Disarankan Cek Jadwal)
                          </a>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-door-open"></i>
          </div>
          <h4>Belum Ada Ruangan</h4>
          <p>Tidak ada data ruangan yang tersedia saat ini.</p>
          <?php if (in_array(session()->get('user')['role'] ?? '', ['administrator', 'petugas'])): ?>
            <a href="<?= base_url('/ruang/create') ?>" class="btn-add-modern">
              <i class="fas fa-plus-circle"></i>
              Tambah Ruangan Pertama
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Delete Form (Hidden) -->
  <form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
  </form>

  <script>
    // Auto-count stats from data
    document.addEventListener('DOMContentLoaded', function() {
      const ruangs = <?= json_encode($ruangs ?? []) ?>;
      
      // Count totals
      const totalRuangan = ruangs.length;
      const totalTersedia = ruangs.filter(r => r.status.toLowerCase() === 'tersedia').length;
      const totalTidakTersedia = ruangs.filter(r => r.status.toLowerCase() === 'tidak tersedia').length;
      const totalKapasitas = ruangs.reduce((sum, r) => sum + parseInt(r.kapasitas || 0), 0);

      // Animate counting
      animateValue('totalRuangan', 0, totalRuangan, 800);
      animateValue('totalTersedia', 0, totalTersedia, 800);
      animateValue('totalTidakTersedia', 0, totalTidakTersedia, 800);
      animateValue('totalKapasitas', 0, totalKapasitas, 800);
      animateValue('tableCount', 0, totalRuangan, 800);

      // Fade in cards
      setTimeout(() => {
        document.querySelectorAll('.stat-summary-card').forEach((card, index) => {
          setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            setTimeout(() => {
              card.style.opacity = '1';
              card.style.transform = 'translateY(0)';
            }, 50);
          }, index * 100);
        });
      }, 100);

      // Fade in table rows
      setTimeout(() => {
        document.querySelectorAll('.room-row').forEach((row, index) => {
          setTimeout(() => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            row.style.transition = 'all 0.5s ease';
            setTimeout(() => {
              row.style.opacity = '1';
              row.style.transform = 'translateX(0)';
            }, 50);
          }, index * 50);
        });
      }, 300);
    });

    function animateValue(id, start, end, duration) {
      const element = document.getElementById(id);
      if (!element) return;
      
      const range = end - start;
      const increment = range / (duration / 16);
      let current = start;
      
      const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
          current = end;
          clearInterval(timer);
        }
        element.textContent = Math.floor(current);
      }, 16);
    }

    function confirmDelete(id, namaRuang) {
      if (confirm(`🗑️ Hapus Ruangan?\n\nApakah Anda yakin ingin menghapus ruangan "${namaRuang}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        const form = document.getElementById('deleteForm');
        form.action = '<?= base_url('/ruang/delete/') ?>' + id;
        form.submit();
      }
    }

    // Auto-dismiss alerts
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
