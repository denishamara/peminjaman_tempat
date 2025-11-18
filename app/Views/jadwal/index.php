<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Jadwal Ruangan') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #667eea;
      --secondary: #764ba2;
      --dark: #0f172a;
      --light: #f8fafc;
    }

    body {
      background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
      font-family: 'Poppins', sans-serif;
      color: #1e293b;
      min-height: 100vh;
    }

    .main-content {
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 80px 15px 40px 15px;
        margin-top: 0;
      }
    }

    /* Page Header */
    .page-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 40px rgba(102, 126, 234, 0.25);
      color: #fff;
    }

    .page-header h3 {
      font-weight: 700;
      margin-bottom: 0.5rem;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .page-header p {
      margin-bottom: 0;
      opacity: 0.95;
      font-size: 1rem;
    }

    /* Filter Section */
    .filter-section {
      background: #fff;
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .filter-btn {
      border: 2px solid #667eea;
      color: #667eea;
      background: transparent;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .filter-btn:hover {
      background: #667eea;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .filter-btn.active {
      background: #667eea !important;
      color: #fff !important;
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    /* Search Section */
    .search-section {
      background: #fff;
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    .search-form {
      display: flex;
      gap: 1rem;
      align-items: center;
      flex-wrap: wrap;
    }

    .search-input-group {
      flex: 1;
      min-width: 300px;
      position: relative;
    }

    .search-input {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 3rem;
      border: 2px solid #e2e8f0;
      border-radius: 50px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    .search-input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      background: #fff;
    }

    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
    }

    .search-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .search-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .clear-search {
      color: #64748b;
      text-decoration: none;
      padding: 0.75rem 1rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .clear-search:hover {
      color: #dc3545;
      background: rgba(220, 53, 69, 0.1);
    }

    /* Card Modern */
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      overflow: visible;
    }

    .card-body {
      padding: 0;
    }

    /* Buttons */
    .btn {
      border-radius: 50px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary {
      border: 2px solid #667eea;
      color: #667eea;
      background: transparent;
    }

    .btn-outline-primary:hover {
      background: #667eea;
      color: #fff;
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
    }

    .btn-success:hover {
      box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
      color: #fff;
    }

    .action-buttons-top {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    /* Alerts */
    .alert {
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    /* Table Container */
    .table-container {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .table-responsive {
      border-radius: 0;
      overflow-x: auto;
      overflow-y: visible;
      box-shadow: none;
      background: transparent;
      padding: 0;
      -webkit-overflow-scrolling: touch;
    }

    .table {
      margin-bottom: 0;
      min-width: 900px;
    }

    .table thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
    }

    .table thead th {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      padding: 1rem;
      border: none;
    }

    .table tbody td {
      padding: 1rem;
      vertical-align: middle;
      border-color: #e2e8f0;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(102, 126, 234, 0.05);
      transform: scale(1.01);
    }

    .table-primary {
      background-color: rgba(102, 126, 234, 0.1) !important;
    }

    .table-warning {
      background-color: rgba(255, 193, 7, 0.15) !important;
    }

    /* ================================================ */
    /* PERBAIKAN: Action Buttons Responsif */
    /* ================================================ */

    /* Action Buttons in Table - Desktop */
    td.aksi-col {
      text-align: center;
      vertical-align: middle !important;
      white-space: nowrap;
      min-width: 160px;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
    }

    .action-buttons .btn {
      padding: 0.4rem 0.9rem;
      font-size: 0.875rem;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-weight: 500;
      min-height: 36px;
    }

    .action-buttons .btn i {
      font-size: 0.85rem;
    }

    .btn-warning {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
      color: #fff;
    }

    .btn-warning:hover {
      box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .btn-danger:hover {
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    /* ================================================ */
    /* FIX: Tombol Edit & Hapus Sama Besar di Mobile */
    /* ================================================ */

    @media (max-width: 768px) {
      .action-buttons {
        flex-direction: column;
        width: 100%;
        gap: 0.5rem;
      }

      .action-buttons .btn {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.75rem 1rem;
        margin: 0;
        min-height: 44px;
        font-size: 0.85rem;
      }

      /* Pastikan button dalam form sama persis dengan link */
      .action-buttons form {
        width: 100%;
        display: flex;
        margin: 0;
      }

      .action-buttons form button.btn {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.75rem 1rem;
        margin: 0;
      }
    }

    @media (max-width: 576px) {
      .action-buttons {
        gap: 0.4rem;
      }

      .action-buttons .btn {
        padding: 0.7rem 0.9rem;
        font-size: 0.8rem;
        min-height: 42px;
      }
    }

    @media (max-width: 400px) {
      .action-buttons .btn {
        padding: 0.65rem 0.8rem;
        font-size: 0.75rem;
        min-height: 40px;
      }
    }

    /* Badge */
    .badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.85rem;
    }

    .badge-reguler {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
    }

    .badge-booking {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
      color: #fff;
    }

    /* No Results Message */
    .no-results {
      display: none;
      text-align: center;
      padding: 3rem 2rem;
      color: #64748b;
    }

    .no-results i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .no-results h5 {
      margin-bottom: 0.5rem;
      color: #475569;
    }

    /* Filter Header Responsive */
    .card-header.flex-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .card-header .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 80px 1rem 40px;
      }

      .page-header {
        padding: 1.5rem;
      }

      .page-header h3 {
        font-size: 1.5rem;
      }

      .page-header p {
        font-size: 0.95rem;
      }

      .filter-section {
        flex-direction: column;
        align-items: stretch;
      }

      .btn-group {
        width: 100%;
      }

      .filter-btn {
        flex: 1;
        text-align: center;
      }

      .action-buttons-top {
        width: 100%;
      }

      .action-buttons-top .btn {
        flex: 1;
      }

      .search-section {
        padding: 1rem;
      }

      .search-form {
        flex-direction: column;
        gap: 0.75rem;
      }

      .search-input-group {
        min-width: 100%;
      }

      .search-btn, .clear-search {
        width: 100%;
        justify-content: center;
      }

      .table {
        font-size: 0.85rem;
        min-width: 700px;
      }

      .table thead th,
      .table tbody td {
        padding: 0.75rem 0.5rem;
      }
    }

    @media (max-width: 576px) {
      .page-header h3 {
        font-size: 1.3rem;
      }

      .table {
        font-size: 0.8rem;
        min-width: 650px;
      }

      .table thead th,
      .table tbody td {
        padding: 0.65rem 0.4rem;
      }

      .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
      }
    }
  </style>
</head>

<body>
  <?= view('layouts/sidebar') ?>

  <div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
      <h3><i class="fas fa-calendar-alt"></i>Jadwal Ruangan</h3>
      <p>Lihat dan kelola semua jadwal reguler & booking ruangan</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="btn-group">
        <a href="#" class="filter-btn active" data-filter="all">
          <i class="fas fa-list me-1"></i>Semua Jadwal
        </a>
        <a href="#" class="filter-btn" data-filter="reguler">
          <i class="fas fa-calendar-check me-1"></i>Reguler
        </a>
        <a href="#" class="filter-btn" data-filter="booking">
          <i class="fas fa-bookmark me-1"></i>Booking
        </a>
      </div>
      <div class="action-buttons-top">
        <a href="<?= base_url('jadwal/kalender') ?>" class="btn btn-outline-primary">
          <i class="fas fa-calendar"></i>Lihat Kalender
        </a>
        <?php 
          $user = session()->get('user');
          if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
          <a href="<?= base_url('jadwal/create') ?>" class="btn btn-success">
            <i class="fas fa-plus-circle"></i>Tambah Jadwal
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
      <div class="search-form">
        <div class="search-input-group">
          <i class="fas fa-search search-icon"></i>
          <input type="text" 
                 id="searchInput" 
                 class="search-input" 
                 placeholder="Cari ruangan, kegiatan, atau peminjam..." 
                 value="<?= esc($search ?? '') ?>"
                 autocomplete="off">
        </div>
        <button type="button" id="clearSearch" class="clear-search" style="<?= !empty($search) ? 'display: flex;' : 'display: none;' ?>">
          <i class="fas fa-times"></i>Clear
        </button>
      </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="text-center">
              <tr>
                <th><i class="fas fa-door-open me-1"></i>Ruangan</th>
                <th><i class="fas fa-info-circle me-1"></i>Kegiatan</th>
                <th><i class="fas fa-user me-1"></i>Peminjam</th>
                <th><i class="fas fa-calendar-day me-1"></i>Tanggal</th>
                <th><i class="fas fa-clock me-1"></i>Jam Mulai</th>
                <th><i class="fas fa-clock me-1"></i>Jam Selesai</th>
                <th><i class="fas fa-tag me-1"></i>Status</th>
                <?php if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
                  <th><i class="fas fa-cog me-1"></i>Aksi</th>
                <?php endif; ?>
              </tr>
            </thead>

            <tbody id="tableBody">
              <?php if (!empty($jadwal)): ?>
                <?php foreach ($jadwal as $j): ?>
                  <?php
                    $status = strtolower($j['status'] ?? 'reguler');
                    $rowClass = $status === 'reguler' ? 'table-primary' : 'table-warning';
                    $badgeClass = $status === 'reguler' ? 'badge-reguler' : 'badge-booking';
                    $id = $j['id'] ?? $j['id_reguler'] ?? $j['id_booking'] ?? null;

                    $tglMulai   = $j['tanggal_mulai'] ?? $j['tgl_pinjam'] ?? $j['tgl_booking'] ?? null;
                    $tglSelesai = $j['tanggal_selesai'] ?? null;

                    if ($tglMulai && $tglSelesai) {
                      $tanggal = (date('Y-m-d', strtotime($tglMulai)) === date('Y-m-d', strtotime($tglSelesai)))
                        ? date('d-m-Y', strtotime($tglMulai))
                        : date('d-m-Y', strtotime($tglMulai)) . ' s.d. ' . date('d-m-Y', strtotime($tglSelesai));
                    } elseif ($tglMulai) {
                      $tanggal = date('d-m-Y', strtotime($tglMulai));
                    } else {
                      $tanggal = '-';
                    }

                    $jamMulai = $j['jam_mulai'] ?? (!empty($tglMulai) ? date('H:i', strtotime($tglMulai)) : '-');
                    $jamSelesai = $j['jam_selesai'] ?? (!empty($tglSelesai) ? date('H:i', strtotime($tglSelesai)) : '-');
                  ?>

                  <tr class="jadwal-row <?= esc($rowClass) ?>" 
                      data-ruang="<?= strtolower(esc($j['nama_ruang'] ?? '')) ?>"
                      data-kegiatan="<?= strtolower(esc($j['nama_kegiatan'] ?? $j['nama_reguler'] ?? $j['keterangan'] ?? '')) ?>"
                      data-peminjam="<?= strtolower(esc($j['peminjam'] ?? '')) ?>"
                      data-status="<?= strtolower(esc($j['status'] ?? '')) ?>">
                    <td><strong><?= esc($j['nama_ruang'] ?? '-') ?></strong></td>
                    <td><?= esc($j['nama_kegiatan'] ?? $j['nama_reguler'] ?? $j['keterangan'] ?? '-') ?></td>
                    <td><?= esc($j['peminjam'] ?? '-') ?></td>
                    <td class="text-center"><?= esc($tanggal) ?></td>
                    <td class="text-center"><strong><?= esc($jamMulai) ?></strong></td>
                    <td class="text-center"><strong><?= esc($jamSelesai) ?></strong></td>
                    <td class="text-center">
                      <span class="badge <?= esc($badgeClass) ?> text-capitalize">
                        <?= esc($j['status'] ?? '-') ?>
                      </span>
                    </td>

                    <?php if (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])): ?>
                      <td class="aksi-col">
                        <?php if (!empty($id)): ?>
                          <div class="action-buttons">
                            <a href="<?= base_url('jadwal/edit/' . $id . '?tipe=' . strtolower($j['status'])) ?>" 
                               class="btn btn-warning btn-sm" title="Edit Jadwal">
                              <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="<?= base_url('jadwal/delete/' . $id) ?>" method="post" style="display:inline;">
                              <?= csrf_field() ?>
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="tipe" value="<?= strtolower($j['status'] ?? 'reguler') ?>">
                              <button type="submit" class="btn btn-danger btn-sm" title="Hapus Jadwal"
                                      onclick="return confirm('⚠️ Yakin ingin menghapus jadwal ini?\n\nData yang dihapus tidak dapat dikembalikan.')">
                                <i class="fas fa-trash-alt"></i> Hapus
                              </button>
                            </form>
                          </div>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="<?= (!empty($user) && in_array($user['role'], ['administrator', 'petugas'])) ? '8' : '7' ?>" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fs-1 d-block mb-2" style="opacity: 0.3;"></i>
                    <p class="mb-0">Tidak ada jadwal ditemukan.</p>
                    <?php if (!empty($search)): ?>
                      <small class="text-muted">Coba dengan kata kunci lain</small>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
        </table>
        
        <!-- No Results Message -->
        <div id="noResults" class="no-results">
          <i class="fas fa-search"></i>
          <h5>Tidak ada hasil ditemukan</h5>
          <p class="mb-0">Coba gunakan kata kunci yang berbeda</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Search functionality - AUTO FILTER TANPA RELOAD
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const clearSearch = document.getElementById('clearSearch');
      const jadwalRows = document.querySelectorAll('.jadwal-row');
      const noResults = document.getElementById('noResults');
      const tableBody = document.getElementById('tableBody');
      const filterButtons = document.querySelectorAll('.filter-btn');

      let currentFilter = '<?= $filter ?? "all" ?>';
      let currentSearch = '<?= esc($search ?? "") ?>';

      // Initialize search input value
      if (searchInput && currentSearch) {
        searchInput.value = currentSearch;
      }

      // Set active filter button berdasarkan URL
      filterButtons.forEach(btn => {
        if (btn.dataset.filter === currentFilter) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });

      // Filter by status
      filterButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          currentFilter = this.dataset.filter;
          
          // Update active state
          filterButtons.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          
          // Update URL tanpa reload
          updateURL();
          filterJadwal();
        });
      });

      // Auto search on typing - TANPA RELOAD
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          currentSearch = this.value.toLowerCase().trim();
          
          // Show/hide clear button
          if (clearSearch) {
            if (currentSearch.length > 0) {
              clearSearch.style.display = 'flex';
            } else {
              clearSearch.style.display = 'none';
            }
          }
          
          // Update URL tanpa reload
          updateURL();
          filterJadwal();
        });

        // Enter key untuk submit traditional (fallback)
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            // Untuk kompatibilitas, tetap bisa submit form jika diperlukan
            document.getElementById('searchForm')?.submit();
          }
        });
      }

      // Clear search
      if (clearSearch) {
        clearSearch.addEventListener('click', function() {
          if (searchInput) {
            searchInput.value = '';
          }
          currentSearch = '';
          this.style.display = 'none';
          
          // Update URL tanpa reload
          updateURL();
          filterJadwal();
        });
      }

      function filterJadwal() {
        let visibleRows = 0;
        let hasData = jadwalRows.length > 0;
        
        if (hasData) {
          jadwalRows.forEach(row => {
            const ruang = row.dataset.ruang || '';
            const kegiatan = row.dataset.kegiatan || '';
            const peminjam = row.dataset.peminjam || '';
            const status = row.dataset.status || '';
            
            // Check search match
            const matchesSearch = currentSearch === '' || 
              ruang.includes(currentSearch) || 
              kegiatan.includes(currentSearch) || 
              peminjam.includes(currentSearch);
            
            // Check filter match
            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            
            // Show/hide row berdasarkan kedua kondisi
            if (matchesSearch && matchesFilter) {
              row.style.display = '';
              visibleRows++;
            } else {
              row.style.display = 'none';
            }
          });
        }

        // Show/hide no results message
        if (noResults && tableBody) {
          if (visibleRows === 0 && hasData) {
            noResults.style.display = 'block';
            tableBody.style.display = 'none';
          } else {
            noResults.style.display = 'none';
            tableBody.style.display = '';
          }
        }
      }

      // Update URL tanpa reload page
      function updateURL() {
        const params = new URLSearchParams();
        
        if (currentSearch) {
          params.set('search', currentSearch);
        }
        
        if (currentFilter && currentFilter !== 'all') {
          params.set('filter', currentFilter);
        }
        
        const newUrl = params.toString() ? `?${params.toString()}` : window.location.pathname;
        window.history.replaceState({}, '', newUrl);
      }

      // Initialize filter pada load
      filterJadwal();

      // Auto focus search input
      if (searchInput && !searchInput.value) {
        searchInput.focus();
      }
    });

    // Clear search with escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const searchInput = document.getElementById('searchInput');
        if (searchInput && searchInput.value) {
          searchInput.value = '';
          searchInput.dispatchEvent(new Event('input'));
        }
      }
    });
  </script>
</body>
</html>