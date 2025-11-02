<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Reguler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* 🌐 Atur posisi agar tidak nabrak sidebar */
        .main-content {
            margin-left: 260px; /* sesuaikan dengan lebar sidebar kamu */
            padding: 30px;
        }

        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <?= view('layouts/sidebar') ?>

    <div class="main-content">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Jadwal Reguler</h4>
            </div>
            <div class="card-body">
                <!-- Alert Error -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ⚠️ <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Alert Success -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ✅ <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/jadwal/store') ?>">
                    <?= csrf_field() ?>

                    <?php $now = date('Y-m-d\TH:i'); ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Jadwal</label>
                        <input type="text" name="nama_reguler" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <select name="id_room" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach ($ruangs as $ruang): ?>
                                <option value="<?= $ruang['id_room'] ?>"><?= esc($ruang['nama_room']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Peminjam</label>
                        <select name="id_user" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id_user'] ?>"><?= esc($user['username']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input 
                            type="datetime-local" 
                            name="tanggal_mulai" 
                            id="tanggal_mulai"
                            class="form-control" 
                            required 
                            min="<?= $now ?>" 
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input 
                            type="datetime-local" 
                            name="tanggal_selesai" 
                            id="tanggal_selesai"
                            class="form-control" 
                            required
                        >
                    </div>

                    <!-- 🔁 Tambahan: Repeat Mingguan -->
                    <div class="mb-3">
                        <label class="form-label">Ulangi setiap minggu selama</label>
                        <div class="input-group">
                            <input type="number" name="repeat_minggu" class="form-control" min="0" value="0">
                            <span class="input-group-text">minggu</span>
                        </div>
                        <small class="text-muted">Isi 0 jika tidak ingin diulang otomatis.</small>
                    </div>

                    <!-- otomatis jadwal reguler -->
                    <input type="hidden" name="keterangan" value="Reguler">

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const mulaiInput = document.getElementById('tanggal_mulai');
    const selesaiInput = document.getElementById('tanggal_selesai');

    mulaiInput.addEventListener('change', () => {
        selesaiInput.min = mulaiInput.value;
        if (selesaiInput.value && selesaiInput.value < mulaiInput.value) {
            selesaiInput.value = '';
        }
    });
    </script>
</body>
</html>
