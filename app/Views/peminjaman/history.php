<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Peminjaman | SmartRoom</title>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome 6.4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Custom CSS -->
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

  <style>
    /* Page Header Modern */
    .page-header-modern {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .page-title-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .count-badge-purple {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Empty State */
    .empty-state-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 4rem 2rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .empty-icon {
      font-size: 5rem;
      color: #cbd5e1;
      margin-bottom: 1.5rem;
      opacity: 0.7;
    }

    .btn-add-new {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-add-new:hover {
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
      overflow: hidden;
    }

    .table-wrapper {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    /* Modern Table */
    .modern-history-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 900px;
    }

    .modern-history-table thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    .modern-history-table thead th {
      padding: 1.25rem 1rem;
      font-weight: 600;
      text-align: left;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      white-space: nowrap;
      border: none;
    }

    .modern-history-table thead th:first-child {
      border-top-left-radius: 12px;
    }

    .modern-history-table thead th:last-child {
      border-top-right-radius: 12px;
    }

    .modern-history-table tbody tr {
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      background: white;
    }

    .modern-history-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      transform: scale(1.002);
    }

    .modern-history-table tbody td {
      padding: 1rem;
      vertical-align: middle;
    }

    /* User Avatar */
    .user-avatar-purple {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      font-weight: 700;
      font-size: 0.875rem;
    }

    /* Room Icon */
    .room-icon-purple {
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

    /* Status Badge */
    .status-selesai {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Delete Button */
    .btn-delete-modern {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      border: none;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.875rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }

    .btn-delete-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
      color: white;
    }

    /* Summary Footer */
    .summary-footer {
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 2px solid rgba(102, 126, 234, 0.1);
    }

    /* Responsive Desktop */
    @media (min-width: 1200px) {
      .modern-history-table {
        min-width: 100%;
      }
    }

    /* Responsive Tablet */
    @media (max-width: 1199px) {
      .page-header-modern {
        padding: 1.75rem;
      }

      .page-title-gradient {
        font-size: 1.75rem;
      }

      .table-card-modern {
        padding: 1.75rem;
      }

      .modern-history-table {
        min-width: 850px;
      }
    }

    @media (max-width: 992px) {
      .page-header-modern {
        padding: 1.5rem;
      }

      .page-title-gradient {
        font-size: 1.5rem;
      }

      .table-card-modern {
        padding: 1.5rem;
      }

      .modern-history-table {
        min-width: 800px;
        font-size: 0.875rem;
      }

      .modern-history-table thead th,
      .modern-history-table tbody td {
        padding: 0.875rem 0.75rem;
      }
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
      .page-header-modern {
        padding: 1.25rem;
        border-radius: 15px;
      }

      .page-title-gradient {
        font-size: 1.35rem;
      }

      .page-header-modern .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
      }

      .table-card-modern {
        padding: 1rem;
        border-radius: 15px;
      }

      .modern-history-table {
        min-width: 700px;
        font-size: 0.8rem;
      }

      .modern-history-table thead th,
      .modern-history-table tbody td {
        padding: 0.75rem 0.5rem;
      }

      .user-avatar-purple {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
      }

      .room-icon-purple {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
      }

      .status-selesai {
        font-size: 0.75rem;
        padding: 0.4rem 0.85rem;
      }

      .btn-delete-modern {
        font-size: 0.75rem;
        padding: 0.45rem 0.85rem;
      }

      .empty-state-card {
        padding: 2rem 1rem;
      }

      .empty-icon {
        font-size: 3rem;
      }
    }

    @media (max-width: 576px) {
      .page-header-modern {
        padding: 1rem;
        border-radius: 12px;
      }

      .page-title-gradient {
        font-size: 1.15rem;
      }

      .count-badge-purple {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
      }

      .table-card-modern {
        padding: 0.75rem;
        border-radius: 12px;
      }

      .modern-history-table {
        min-width: 650px;
        font-size: 0.75rem;
      }

      .modern-history-table thead th,
      .modern-history-table tbody td {
        padding: 0.6rem 0.4rem;
      }

      .user-avatar-purple {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
      }

      .room-icon-purple {
        width: 26px;
        height: 26px;
        font-size: 0.7rem;
      }

      .status-selesai {
        font-size: 0.7rem;
        padding: 0.35rem 0.75rem;
      }

      .btn-delete-modern {
        font-size: 0.7rem;
        padding: 0.4rem 0.75rem;
      }

      .btn-add-new {
        width: 100%;
        justify-content: center;
      }
    }

    /* Very Small Screens */
    @media (max-width: 400px) {
      .page-title-gradient {
        font-size: 1rem;
      }

      .modern-history-table {
        min-width: 600px;
        font-size: 0.7rem;
      }

      .modern-history-table thead th,
      .modern-history-table tbody td {
        padding: 0.5rem 0.3rem;
      }
    }
  </style>
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

<div class="main-content">
  <!-- Page Header -->
  <div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h1 class="page-title-gradient">
          <i class="fas fa-history me-2"></i>
          Riwayat Peminjaman
        </h1>
        <p class="text-muted mb-0">
          <i class="fas fa-info-circle me-2"></i>
          Daftar peminjaman yang telah selesai
        </p>
      </div>
      <?php if (!empty($riwayat)): ?>
        <div class="text-end">
          <span class="count-badge-purple">
            <i class="fas fa-check-circle me-1"></i>
            <?= count($riwayat) ?> Riwayat
          </span>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if (empty($riwayat)): ?>
    <!-- Empty State -->
    <div class="empty-state-card">
      <div class="empty-icon">
        <i class="fas fa-inbox"></i>
      </div>
      <h4 class="fw-bold text-muted mb-2">Belum Ada Riwayat Peminjaman</h4>
      <p class="text-muted mb-4">Riwayat peminjaman yang telah selesai akan ditampilkan di sini</p>
      <a href="<?= base_url('peminjaman/ajukan') ?>" class="btn-add-new">
        <i class="fas fa-plus-circle"></i>
        Ajukan Peminjaman Baru
      </a>
    </div>
  <?php else: ?>
    <!-- Table Card -->
    <div class="table-card-modern">
      <div class="table-wrapper">
        <table class="modern-history-table">
          <thead>
            <tr>
              <th class="text-center" style="width: 5%;">
                <i class="fas fa-hashtag"></i>
              </th>
              <th style="width: 15%;">
                <i class="fas fa-user me-2"></i>Nama Peminjam
              </th>
              <th style="width: 15%;">
                <i class="fas fa-door-open me-2"></i>Ruangan
              </th>
              <th style="width: 15%;">
                <i class="fas fa-calendar-alt me-2"></i>Tanggal Mulai
              </th>
              <th style="width: 15%;">
                <i class="fas fa-calendar-check me-2"></i>Tanggal Selesai
              </th>
              <th class="text-center" style="width: 12%;">
                <i class="fas fa-info-circle me-2"></i>Status
              </th>
              <th style="width: 18%;">
                <i class="fas fa-comment me-2"></i>Keterangan
              </th>
              <?php if (session()->get('user')['role'] === 'administrator'): ?>
                <th class="text-center" style="width: 10%;">
                  <i class="fas fa-cog me-2"></i>Aksi
                </th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($riwayat as $r): ?>
              <tr class="history-row">
                <td class="text-center fw-bold"><?= $no++ ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar-purple">
                      <?= strtoupper(substr($r['username'], 0, 1)) ?>
                    </div>
                    <strong><?= esc($r['username']) ?></strong>
                  </div>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="room-icon-purple">
                      <i class="fas fa-door-open"></i>
                    </div>
                    <span class="fw-semibold"><?= esc($r['nama_room']) ?></span>
                  </div>
                </td>
                <td>
                  <div style="font-size: 0.875rem;">
                    <div class="text-muted">
                      <i class="far fa-calendar me-1"></i>
                      <?= date('d M Y', strtotime($r['tanggal_mulai'])) ?>
                    </div>
                    <div class="fw-semibold mt-1">
                      <i class="far fa-clock me-1"></i>
                      <?= date('H:i', strtotime($r['tanggal_mulai'])) ?> WIB
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-size: 0.875rem;">
                    <div class="text-muted">
                      <i class="far fa-calendar me-1"></i>
                      <?= date('d M Y', strtotime($r['tanggal_selesai'])) ?>
                    </div>
                    <div class="fw-semibold mt-1">
                      <i class="far fa-clock me-1"></i>
                      <?= date('H:i', strtotime($r['tanggal_selesai'])) ?> WIB
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  <span class="status-selesai">
                    <i class="fas fa-check-circle"></i>
                    Selesai
                  </span>
                </td>
                <td>
                  <span class="text-muted" style="font-size: 0.875rem;">
                    <?= esc($r['keterangan']) ?>
                  </span>
                </td>

                <?php if (session()->get('user')['role'] === 'administrator'): ?>
                <td class="text-center">
                  <form action="<?= base_url('peminjaman/riwayat/delete/' . $r['id_booking']) ?>" method="post" 
                        onsubmit="return confirm('⚠️ Yakin ingin menghapus riwayat ini?\n\nData yang dihapus tidak dapat dikembalikan.');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-delete-modern">
                      <i class="fas fa-trash-alt"></i>
                      Hapus
                    </button>
                  </form>
                </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Summary Footer -->
      <div class="summary-footer">
        <p class="text-muted mb-0">
          <i class="fas fa-info-circle me-2"></i>
          Menampilkan <strong><?= count($riwayat) ?></strong> riwayat peminjaman yang telah selesai
        </p>
      </div>
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Fade in table rows
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
      document.querySelectorAll('.history-row').forEach((row, index) => {
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
</script>
</body>
</html>
