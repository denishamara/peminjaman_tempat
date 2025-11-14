<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Reguler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .main-content { margin-left: 260px; padding: 30px; max-width: 100%; }
        @media (max-width: 991.98px) { 
            .main-content { margin-left: 0; padding: 15px; } 
        }
        .card { border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .form-check-label { white-space: normal; }
        @media (max-width: 576px) {
            .form-control, .form-select { font-size: 14px; padding: 8px; }
            .input-group-text { font-size: 14px; padding: 8px; }
            .form-check { margin-bottom: 8px; }
        }
        .d-flex { flex-wrap: wrap; gap: 10px; }
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
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/jadwal/store') ?>">
                    <?= csrf_field() ?>

                    <!-- Nama Jadwal -->
                    <div class="mb-3">
                        <label class="form-label">Nama Jadwal</label>
                        <input type="text" name="nama_reguler" class="form-control" required>
                    </div>

                    <!-- Pilih Ruangan -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Ruangan</label>
                        <select id="ruanganSelect" name="id_room" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach ($ruangs as $r): ?>
                                <option value="<?= $r['id_room'] ?>"><?= esc($r['nama_room']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Pilih Peminjam -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Peminjam</label>
                        <select id="userSelect" name="id_user" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id_user'] ?>"><?= esc($u['username']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
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
                    <div class="mb-3">
                        <label class="form-label">Pilih Sesi</label>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($sesi_list as $val => $label): ?>
                                <div class="form-check me-3">
                                    <input class="form-check-input sesi-check" type="checkbox" name="sesi[]" value="<?= $val ?>" id="sesi<?= $val ?>">
                                    <label class="form-check-label" for="sesi<?= $val ?>"><?= $label ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Hidden untuk tanggal mulai & selesai -->
                    <input type="hidden" name="tanggal_mulai" id="tanggal_mulai">
                    <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">

                    <!-- Repeat mingguan -->
                    <div class="mb-3">
                        <label class="form-label">Ulangi setiap minggu selama</label>
                        <div class="input-group">
                            <input type="number" name="repeat_minggu" class="form-control" min="0" value="0">
                            <span class="input-group-text">minggu</span>
                        </div>
                        <small class="text-muted">Isi 0 jika tidak ingin diulang otomatis.</small>
                    </div>

                    <input type="hidden" name="keterangan" value="Reguler">

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary flex-grow-1">Simpan</button>
                        <a href="<?= base_url('jadwal/index') ?>" class="btn btn-secondary flex-grow-1">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    // Initialize Choices.js untuk dropdown searchable
    new Choices('#ruanganSelect', { searchEnabled: true, itemSelectText: '' });
    new Choices('#userSelect', { searchEnabled: true, itemSelectText: '' });

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
        const selected = Array.from(sesiCheckboxes).filter(cb => cb.checked).map(cb => parseInt(cb.value)).sort((a,b)=>a-b);
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
