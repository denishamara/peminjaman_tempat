<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Reguler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 260px; padding: 30px; }
        @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 15px; } }
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

                    <!-- Pilih Ruangan (dropdown normal) -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Ruangan</label>
                        <select name="id_room" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach ($ruangs as $r): ?>
                                <option value="<?= $r['id_room'] ?>"><?= esc($r['nama_room']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Pilih Peminjam (dropdown normal) -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Peminjam</label>
                        <select name="id_user" class="form-select" required>
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
                        <?php foreach ($sesi_list as $val => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input sesi-check" type="checkbox" name="sesi[]" value="<?= $val ?>" id="sesi<?= $val ?>">
                                <label class="form-check-label" for="sesi<?= $val ?>"><?= $label ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Hidden untuk tanggal mulai & selesai berdasarkan sesi -->
                    <input type="hidden" name="tanggal_mulai" id="tanggal_mulai">
                    <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">

                    <div class="mb-3">
                        <label class="form-label">Ulangi setiap minggu selama</label>
                        <div class="input-group">
                            <input type="number" name="repeat_minggu" class="form-control" min="0" value="0">
                            <span class="input-group-text">minggu</span>
                        </div>
                        <small class="text-muted">Isi 0 jika tidak ingin diulang otomatis.</small>
                    </div>

                    <input type="hidden" name="keterangan" value="Reguler">

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('jadwal/index') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
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
