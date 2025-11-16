<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
      min-height: 100vh;
    }

    /* Main Content */
    .main-content {
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0;
        padding: 20px 15px;
        margin-top: 60px;
      }
    }

    /* Page Header */
    .page-header {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      border-radius: 20px;
      padding: 2.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 40px rgba(220, 53, 69, 0.2);
      color: #fff;
      text-align: center;
    }

    .page-header h2 {
      font-weight: 700;
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
    }

    .page-header p {
      margin-bottom: 0;
      opacity: 0.95;
      font-size: 1.1rem;
    }

    /* Alerts */
    .alert {
      border-radius: 16px;
      border: none;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .alert i {
      font-size: 1.3rem;
    }

    /* Card Container */
    .card-container {
      background: #fff;
      border-radius: 20px;
      padding: 0;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    /* Info Cards */
    .info-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .info-card {
      background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: all 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .info-card-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: #fff;
    }

    .info-card-icon.whatsapp {
      background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    }

    .info-card-icon.phone {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .info-card-icon.emergency {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .info-card-content h5 {
      margin: 0 0 0.25rem 0;
      font-weight: 600;
      font-size: 1rem;
      color: #64748b;
    }

    .info-card-content p {
      margin: 0;
      font-weight: 700;
      font-size: 1.3rem;
      color: #1e293b;
    }

    /* Table */
    .table-responsive {
      border-radius: 0;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead {
      background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
      color: #fff;
    }

    .table thead th {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      padding: 1.2rem 1rem;
      border: none;
      white-space: nowrap;
    }

    .table tbody td {
      padding: 1.2rem 1rem;
      vertical-align: middle;
      border-color: #e2e8f0;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(13, 110, 253, 0.05);
      transform: scale(1.005);
    }

    /* WhatsApp Button */
    .wa-button {
      background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
      color: #fff;
      padding: 0.6rem 1.2rem;
      border-radius: 50px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    }

    .wa-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
      color: #fff;
    }

    .wa-button i {
      font-size: 1.2rem;
    }

    /* Badge */
    .badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.85rem;
    }

    .role-admin {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      color: #fff;
    }

    .role-petugas {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: #fff;
    }

    /* Action Buttons */
    .btn {
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-warning {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
      color: #fff;
    }

    .btn-warning:hover {
      box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .page-header {
        padding: 1.5rem;
      }

      .page-header h2 {
        font-size: 1.6rem;
        flex-direction: column;
        gap: 0.5rem;
      }

      .page-header p {
        font-size: 0.95rem;
      }

      .info-cards {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .table {
        font-size: 0.85rem;
      }

      .table thead th,
      .table tbody td {
        padding: 0.8rem 0.5rem;
      }

      .wa-button {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
      }
    }

    @media (max-width: 576px) {
      .main-content {
        padding: 15px 10px;
      }

      .page-header h2 {
        font-size: 1.4rem;
      }

      .info-card {
        padding: 1rem;
      }

      .info-card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
      }

      .info-card-content h5 {
        font-size: 0.85rem;
      }

      .info-card-content p {
        font-size: 1.1rem;
      }

      .table {
        font-size: 0.8rem;
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
    <div class="container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <h2>
          <i class="bi bi-telephone-fill"></i>
          <?= esc($title) ?>
        </h2>
        <p>Hubungi petugas atau admin jika terjadi keadaan mendesak atau butuh bantuan</p>
      </div>

      <!-- Info Cards -->
      <div class="info-cards">
        <div class="info-card">
          <div class="info-card-icon whatsapp">
            <i class="bi bi-whatsapp"></i>
          </div>
          <div class="info-card-content">
            <h5>WhatsApp</h5>
            <p>Klik nomor untuk chat</p>
          </div>
        </div>
        <div class="info-card">
          <div class="info-card-icon phone">
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="info-card-content">
            <h5>Total Kontak</h5>
            <p><?= count($petugas) ?> Petugas</p>
          </div>
        </div>
        <div class="info-card">
          <div class="info-card-icon emergency">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
          <div class="info-card-content">
            <h5>Layanan</h5>
            <p>24/7 Siap Membantu</p>
          </div>
        </div>
      </div>

      <!-- Alerts -->
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill"></i>
          <span><?= session()->getFlashdata('success') ?></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-circle-fill"></i>
          <span><?= session()->getFlashdata('error') ?></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Table Card -->
      <div class="card-container">
        <?php $user = session()->get('user'); ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle text-center">
            <thead>
              <tr>
                <th><i class="bi bi-hash me-1"></i>No</th>
                <th><i class="bi bi-person-fill me-1"></i>Nama</th>
                <th><i class="bi bi-shield-fill me-1"></i>Role</th>
                <th><i class="bi bi-telephone-fill me-1"></i>Nomor Telepon</th>
                <?php if ($user && $user['role'] === 'administrator'): ?>
                  <th><i class="bi bi-gear-fill me-1"></i>Aksi</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($petugas)): ?>
                <?php $no = 1; foreach($petugas as $p): ?>
                  <tr>
                    <td><strong><?= $no++ ?></strong></td>
                    <td>
                      <strong><?= esc($p['username']) ?></strong>
                    </td>
                    <td>
                      <span class="badge <?= strtolower($p['role']) === 'administrator' ? 'role-admin' : 'role-petugas' ?>">
                        <i class="bi bi-<?= strtolower($p['role']) === 'administrator' ? 'shield-fill-check' : 'person-badge' ?> me-1"></i>
                        <?= esc(ucfirst($p['role'])) ?>
                      </span>
                    </td>
                    <td>
                      <?php if(!empty($p['telepon'])): ?>
                        <?php
                          // ambil angka aja
                          $nomor = preg_replace('/[^0-9]/', '', $p['telepon']);

                          // jika nomor diawali 0, ubah jadi 62
                          if (substr($nomor, 0, 1) === '0') {
                              $nomor = '62' . substr($nomor, 1);
                          }

                          // isi pesan otomatis
                          $pesan = urlencode("Halo {$p['username']}, saya mau bertanya tentang peminjaman ruang.");
                        ?>
                        <a href="https://wa.me/<?= $nomor ?>?text=<?= $pesan ?>" 
                           target="_blank" 
                           class="wa-button">
                          <i class="bi bi-whatsapp"></i>
                          <?= esc($p['telepon']) ?>
                        </a>
                      <?php else: ?>
                        <span class="text-muted">
                          <i class="bi bi-dash-circle me-1"></i>
                          Belum ada nomor
                        </span>
                      <?php endif; ?>
                    </td>

                    <?php if ($user && $user['role'] === 'administrator'): ?>
                      <td>
                        <a href="<?= base_url('administrator/kontak/edit/' . $p['id_user']) ?>" 
                           class="btn btn-warning btn-sm">
                          <i class="bi bi-pencil-fill me-1"></i>Edit
                        </a>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="<?= ($user && $user['role'] === 'administrator') ? '5' : '4' ?>" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity: 0.3;"></i>
                    <p class="mb-0">Tidak ada data kontak petugas</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
