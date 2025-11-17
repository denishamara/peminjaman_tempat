<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Peminjaman | SmartRoom</title>
  
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

    /* Filter Card */
    .filter-card-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .filter-title {
      font-weight: 700;
      font-size: 1.25rem;
      color: #1e293b;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .filter-title i {
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Modern Form Controls */
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

    /* Filter Buttons */
    .btn-filter-submit {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 0.75rem 1rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-filter-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
      color: white;
    }

    .btn-filter-reset {
      background: white;
      border: 2px solid #e2e8f0;
      color: #64748b;
      padding: 0.75rem 0.85rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      min-width: auto;
    }

    .btn-filter-reset:hover {
      color: #667eea;
      border-color: #667eea;
      background: rgba(102, 126, 234, 0.05);
      transform: translateY(-2px);
    }

    .btn-filter-reset i {
      font-size: 1rem;
    }

    /* Generate PDF Button */
    .btn-generate-pdf {
      background: linear-gradient(135deg, #10b981, #059669);
      border: none;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-generate-pdf:hover {
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
    }

    .table-header-section {
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

    .record-count-badge {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Modern Table */
    .modern-laporan-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .modern-laporan-table thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .modern-laporan-table thead th {
      padding: 1.25rem 1rem;
      font-weight: 600;
      text-align: left;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .modern-laporan-table thead th:first-child {
      border-top-left-radius: 12px;
    }

    .modern-laporan-table thead th:last-child {
      border-top-right-radius: 12px;
    }

    .modern-laporan-table tbody tr {
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-laporan-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      transform: scale(1.01);
    }

    .modern-laporan-table tbody td {
      padding: 1.25rem 1rem;
      vertical-align: middle;
    }

    /* User Info */
    .user-info-cell {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: white;
      font-size: 0.875rem;
    }

    .user-name {
      font-weight: 600;
      color: #1e293b;
    }

    /* Room Info */
    .room-info-cell {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .room-icon-small {
      width: 35px;
      height: 35px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      font-size: 0.875rem;
    }

    .room-name {
      font-weight: 600;
      color: #1e293b;
    }

    /* Date/Time Display */
    .datetime-cell {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .date-part {
      font-weight: 600;
      color: #1e293b;
      font-size: 0.875rem;
    }

    .time-part {
      font-size: 0.75rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    /* Status Badges */
    .status-badge-laporan {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-transform: capitalize;
    }

    .status-proses {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .status-diterima {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .status-ditolak {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .status-selesai {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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

      .filter-card-modern {
        padding: 1.5rem;
      }

      .table-header-section {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }

      .btn-generate-pdf {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 768px) {
      .page-header-card {
        padding: 1.25rem;
      }

      .page-title {
        font-size: 1.5rem;
      }

      .filter-card-modern {
        padding: 1.25rem;
      }

      .filter-title {
        font-size: 1.125rem;
      }

      .table-card-modern {
        padding: 1.25rem;
      }

      .table-title-icon {
        font-size: 1.25rem;
      }

      /* Stack filter columns on mobile */
      .filter-card-modern .row > div {
        width: 100%;
        margin-bottom: 0.5rem;
      }

      /* Make buttons full width */
      .btn-filter-submit,
      .btn-filter-reset {
        width: 100%;
        justify-content: center;
      }

      .btn-filter-reset {
        height: auto !important;
        width: 100% !important;
        padding: 0.75rem 1rem !important;
      }

      /* Stack user and room info vertically */
      .user-info-cell,
      .room-info-cell {
        flex-direction: row;
        align-items: center;
      }

      /* Adjust table for mobile */
      .modern-laporan-table {
        font-size: 0.875rem;
      }

      .modern-laporan-table thead th,
      .modern-laporan-table tbody td {
        padding: 0.75rem 0.5rem;
      }

      /* Hide some columns on very small screens */
      .modern-laporan-table th:nth-child(7),
      .modern-laporan-table td:nth-child(7) {
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

      /* Even more compact on small phones */
      .filter-title {
        font-size: 1rem;
      }

      .table-title-icon {
        font-size: 1rem;
      }

      /* Stack date/time info */
      .datetime-cell {
        font-size: 0.75rem;
      }

      /* Smaller badges */
      .status-badge-laporan,
      .record-count-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      /* Compact table */
      .modern-laporan-table {
        font-size: 0.75rem;
      }

      .modern-laporan-table thead th,
      .modern-laporan-table tbody td {
        padding: 0.5rem 0.35rem;
      }

      /* User avatar smaller */
      .user-avatar {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
      }

      .room-icon-small {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
      }

      /* Hide additional columns on very small screens */
      .modern-laporan-table th:nth-child(4),
      .modern-laporan-table td:nth-child(4),
      .modern-laporan-table th:nth-child(5),
      .modern-laporan-table td:nth-child(5) {
        display: none;
      }

      /* Show only essential info */
      .table-header-section {
        padding-bottom: 0.75rem;
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
      <div>
        <h1 class="page-title">
          <i class="fas fa-file-chart-line me-2"></i>
          Laporan Peminjaman
        </h1>
        <p class="text-muted mb-0">
          <i class="fas fa-filter me-2"></i>
          Filter dan generate laporan peminjaman ruangan
        </p>
      </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card-modern">
      <h3 class="filter-title">
        <i class="fas fa-sliders-h"></i>
        Filter Laporan
      </h3>

      <form method="get" action="<?= base_url('laporan') ?>">
        <div class="row g-3">
          <!-- Status -->
          <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label-modern">
              <i class="fas fa-flag"></i>
              Status
            </label>
            <select name="status" id="status" class="form-select form-select-modern">
              <option value="">Semua Status</option>
              <?php foreach (['proses', 'diterima', 'ditolak', 'selesai'] as $s): ?>
                <option value="<?= $s ?>" <?= ($status ?? '') === $s ? 'selected' : '' ?>>
                  <?= ucfirst($s) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tanggal Mulai -->
          <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label-modern">
              <i class="fas fa-calendar-plus"></i>
              Dari Tanggal
            </label>
            <input type="date" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>" 
                   class="form-control form-control-modern">
          </div>

          <!-- Tanggal Selesai -->
          <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label-modern">
              <i class="fas fa-calendar-minus"></i>
              Sampai Tanggal
            </label>
            <input type="date" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>" 
                   class="form-control form-control-modern">
          </div>

          <!-- Bulan -->
          <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label-modern">
              <i class="fas fa-calendar-alt"></i>
              Bulan
            </label>
            <select name="bulan" id="bulan" class="form-select form-select-modern">
              <option value="">Semua Bulan</option>
              <?php 
                $bulanList = [
                  1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                ];
                foreach ($bulanList as $num => $nama):
              ?>
                <option value="<?= $num ?>" <?= ($bulan ?? '') == $num ? 'selected' : '' ?>>
                  <?= $nama ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tahun -->
          <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label-modern">
              <i class="fas fa-calendar"></i>
              Tahun
            </label>
            <input type="number" name="tahun" min="2020" max="<?= date('Y') + 1 ?>" 
                   value="<?= esc($tahun ?? date('Y')) ?>" 
                   class="form-control form-control-modern" placeholder="<?= date('Y') ?>">
          </div>

          <!-- Buttons -->
          <div class="col-lg-2 col-md-6 col-12">
            <label class="form-label-modern" style="opacity: 0;">Action</label>
            <div class="d-flex gap-2">
              <button type="submit" class="btn-filter-submit" style="flex: 1;">
                <i class="fas fa-search"></i>
                Tampilkan
              </button>
              <a href="<?= base_url('laporan') ?>" class="btn-filter-reset">
                <i class="fas fa-redo"></i>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Table Card -->
    <div class="table-card-modern">
      <div class="table-header-section">
        <h3 class="table-title-icon">
          <i class="fas fa-table"></i>
          Data Peminjaman
        </h3>
        <div class="d-flex align-items-center gap-3">
          <span class="record-count-badge">
            <i class="fas fa-database me-1"></i>
            <span id="recordCount">0</span> Records
          </span>
          
          <form method="post" action="<?= base_url('laporan/generate') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>">
            <input type="hidden" name="tanggal_selesai" value="<?= esc($tanggalSelesai) ?>">
            <input type="hidden" name="status" value="<?= esc($status) ?>">
            <input type="hidden" name="bulan" value="<?= esc($bulan) ?>">
            <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">

            <button type="submit" class="btn-generate-pdf">
              <i class="fas fa-file-pdf"></i>
              Generate PDF
            </button>
          </form>
        </div>
      </div>

      <?php if (!empty($bookings)): ?>
        <div class="table-responsive">
          <table class="modern-laporan-table">
            <thead>
              <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">User</th>
                <th style="width: 15%;">Ruangan</th>
                <th style="width: 15%;">Tanggal Mulai</th>
                <th style="width: 15%;">Tanggal Selesai</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 23%;">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($bookings as $b): ?>
                <tr class="laporan-row">
                  <td><?= $no++ ?></td>
                  <td>
                    <div class="user-info-cell">
                      <div class="user-avatar" style="background: <?= ['#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899'][array_rand(['#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899'])] ?>">
                        <?= strtoupper(substr($b['username'], 0, 1)) ?>
                      </div>
                      <div class="user-name"><?= esc($b['username']) ?></div>
                    </div>
                  </td>
                  <td>
                    <div class="room-info-cell">
                      <div class="room-icon-small">
                        <i class="fas fa-door-open"></i>
                      </div>
                      <div class="room-name"><?= esc($b['nama_room']) ?></div>
                    </div>
                  </td>
                  <td>
                    <div class="datetime-cell">
                      <span class="date-part"><?= date('d M Y', strtotime($b['tanggal_mulai'])) ?></span>
                      <span class="time-part">
                        <i class="fas fa-clock"></i>
                        <?= date('H:i', strtotime($b['tanggal_mulai'])) ?> WIB
                      </span>
                    </div>
                  </td>
                  <td>
                    <div class="datetime-cell">
                      <span class="date-part"><?= date('d M Y', strtotime($b['tanggal_selesai'])) ?></span>
                      <span class="time-part">
                        <i class="fas fa-clock"></i>
                        <?= date('H:i', strtotime($b['tanggal_selesai'])) ?> WIB
                      </span>
                    </div>
                  </td>
                  <td>
                    <?php
                      $statusClass = 'status-proses';
                      $statusIcon = 'fa-clock';
                      
                      if (strtolower($b['status']) === 'diterima') {
                        $statusClass = 'status-diterima';
                        $statusIcon = 'fa-check-circle';
                      } elseif (strtolower($b['status']) === 'ditolak') {
                        $statusClass = 'status-ditolak';
                        $statusIcon = 'fa-times-circle';
                      } elseif (strtolower($b['status']) === 'selesai') {
                        $statusClass = 'status-selesai';
                        $statusIcon = 'fa-flag-checkered';
                      }
                    ?>
                    <span class="status-badge-laporan <?= $statusClass ?>">
                      <i class="fas <?= $statusIcon ?>"></i>
                      <?= ucfirst(esc($b['status'])) ?>
                    </span>
                  </td>
                  <td>
                    <span class="text-muted" style="font-size: 0.875rem;">
                      <?= esc($b['keterangan']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-file-excel"></i>
          </div>
          <h4>Tidak Ada Data</h4>
          <p>Tidak ada data peminjaman yang sesuai dengan filter yang dipilih.</p>
          <a href="<?= base_url('laporan') ?>" class="btn-filter-reset">
            <i class="fas fa-redo"></i>
            Reset Filter
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    // Auto-count records
    document.addEventListener('DOMContentLoaded', function() {
      const bookings = <?= json_encode($bookings ?? []) ?>;
      const totalRecords = bookings.length;

      // Animate counting
      animateValue('recordCount', 0, totalRecords, 800);

      // Fade in table rows
      setTimeout(() => {
        document.querySelectorAll('.laporan-row').forEach((row, index) => {
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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>