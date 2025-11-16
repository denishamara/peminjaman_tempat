<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Reguler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <style>
        .sesi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.75rem;
        }
        .sesi-checkbox {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .sesi-checkbox:hover {
            border-color: #3b82f6;
            background-color: #f0f7ff;
        }
        .sesi-checkbox input:checked ~ label {
            color: #3b82f6;
            font-weight: 600;
        }
        .sesi-checkbox input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        @media (max-width: 576px) {
            .sesi-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="modern-dashboard">
    <?= view('layouts/sidebar') ?>

    <div class="main-content" style="margin-left: 260px; padding: 30px;">
        <!-- Page Header -->
        <div class="glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2" style="font-size: 1.75rem;">
                        <i class="fas fa-calendar-plus text-primary me-2"></i>Tambah Jadwal Reguler
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-1"></i>Buat jadwal baru untuk peminjaman ruangan reguler
                    </p>
                </div>
                <a href="<?= base_url('jadwal/index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="glass-card p-4">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('/jadwal/store') ?>">
                <?= csrf_field() ?>

                <!-- Nama Jadwal -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-tag text-primary me-2"></i>Nama Jadwal
                    </label>
                    <input type="text" name="nama_reguler" class="form-control" 
                           placeholder="Contoh: Matematika" required>
                    <small class="text-muted">Masukkan nama kegiatan atau mata pelajaran</small>
                </div>

                <div class="row">
                    <!-- Pilih Ruangan -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-door-open text-primary me-2"></i>Pilih Ruangan
                        </label>
                        <select id="ruanganSelect" name="id_room" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach ($ruangs as $r): ?>
                                <option value="<?= $r['id_room'] ?>"><?= esc($r['nama_room']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Pilih Peminjam -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user text-primary me-2"></i>Pilih Peminjam
                        </label>
                        <select id="userSelect" name="id_user" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id_user'] ?>"><?= esc($u['username']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-day text-primary me-2"></i>Tanggal
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required
                        min="<?= date('Y-m-d') ?>">
                    <small class="text-muted">Pilih tanggal pelaksanaan kegiatan</small>
                </div>

                <!-- Pilih Sesi -->
                <?php 
                    $sesi_list = [
                        1 => "Sesi 1 (07:15 - 08:00)", 2 => "Sesi 2 (08:05 - 08:50)", 3 => "Sesi 3 (08:55 - 09:40)",
                        4 => "Sesi 4 (09:45 - 10:30)", 5 => "Sesi 5 (10:35 - 11:20)", 6 => "Sesi 6 (11:25 - 12:10)",
                        7 => "Sesi 7 (12:15 - 13:00)", 8 => "Sesi 8 (13:05 - 13:50)", 9 => "Sesi 9 (13:55 - 14:40)",
                        10=> "Sesi 10 (14:45 - 15:30)"
                    ];
                ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-clock text-primary me-2"></i>Pilih Sesi Waktu
                    </label>
                    <div class="sesi-grid">
                        <?php foreach ($sesi_list as $val => $label): ?>
                            <div class="sesi-checkbox">
                                <input class="form-check-input sesi-check me-2" type="checkbox" 
                                       name="sesi[]" value="<?= $val ?>" id="sesi<?= $val ?>">
                                <label class="form-check-label" for="sesi<?= $val ?>">
                                    <?= $label ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1"></i>Pilih satu atau lebih sesi yang berurutan
                    </small>
                </div>

                <!-- Hidden untuk tanggal mulai & selesai -->
                <input type="hidden" name="tanggal_mulai" id="tanggal_mulai">
                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">

                <!-- Repeat mingguan -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-redo text-primary me-2"></i>Pengulangan Otomatis
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-week"></i>
                        </span>
                        <input type="number" name="repeat_minggu" class="form-control" 
                               min="0" value="0" placeholder="0">
                        <span class="input-group-text">minggu ke depan</span>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>Isi 0 jika tidak ingin diulang otomatis setiap minggu
                    </small>
                </div>

                <input type="hidden" name="keterangan" value="Reguler">

                <!-- Action Buttons -->
                <div class="d-flex gap-3 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-save me-2"></i>Simpan Jadwal
                    </button>
                    <a href="<?= base_url('jadwal/index') ?>" class="btn btn-outline-secondary flex-fill">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    // Initialize Choices.js untuk dropdown searchable
    new Choices('#ruanganSelect', { 
        searchEnabled: true, 
        itemSelectText: '',
        searchPlaceholderValue: 'Cari ruangan...',
        noResultsText: 'Tidak ada ruangan yang ditemukan'
    });
    new Choices('#userSelect', { 
        searchEnabled: true, 
        itemSelectText: '',
        searchPlaceholderValue: 'Cari peminjam...',
        noResultsText: 'Tidak ada peminjam yang ditemukan'
    });

    // Update tanggal_mulai & tanggal_selesai berdasarkan sesi
    const tanggalInput = document.getElementById('tanggal');
    const mulaiInput = document.getElementById('tanggal_mulai');
    const selesaiInput = document.getElementById('tanggal_selesai');
    const sesiCheckboxes = document.querySelectorAll('.sesi-check');

    const sesiWaktu = {
        1: { start: "07:15", end: "08:00" },
        2: { start: "08:05", end: "08:50" },
        3: { start: "08:55", end: "09:40" },
        4: { start: "09:45", end: "10:30" },
        5: { start: "10:35", end: "11:20" },
        6: { start: "11:25", end: "12:10" },
        7: { start: "12:15", end: "13:00" },
        8: { start: "13:05", end: "13:50" },
        9: { start: "13:55", end: "14:40" },
        10:{ start: "14:45", end: "15:30" }
    };

    function updateDateTime() {
        const tanggal = tanggalInput.value;
        const selected = Array.from(sesiCheckboxes)
                              .filter(cb => cb.checked)
                              .map(cb => parseInt(cb.value))
                              .sort((a,b)=>a-b);
        if (!tanggal || selected.length === 0) {
            mulaiInput.value = '';
            selesaiInput.value = '';
            return;
        }
        const first = sesiWaktu[selected[0]];
        const last  = sesiWaktu[selected[selected.length-1]];
        mulaiInput.value = `${tanggal}T${first.start}`;
        selesaiInput.value = `${tanggal}T${last.end}`;
    }

    sesiCheckboxes.forEach(cb => cb.addEventListener('change', updateDateTime));
    tanggalInput.addEventListener('change', updateDateTime);
</script>

</body>
</html>