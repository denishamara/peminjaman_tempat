<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 260px; padding: 30px; }
        @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 15px; } }
        .form-check-label { white-space: normal; }
    </style>
</head>
<body>
<?= view('layouts/sidebar') ?>

<div class="main-content">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Jadwal</h4>
        </div>
        <div class="card-body">

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php
                $isReguler = isset($jadwal['id_reguler']);
                $id = $isReguler ? $jadwal['id_reguler'] : $jadwal['id_booking'];
                $tipe = $isReguler ? 'reguler' : 'booking';
                $namaKegiatan = $isReguler ? ($jadwal['nama_reguler'] ?? '') : ($jadwal['keterangan'] ?? '');
            ?>

            <form method="post" action="<?= base_url('jadwal/update/' . $id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="tipe" value="<?= esc($tipe) ?>">

                <!-- Nama Kegiatan -->
                <div class="mb-3">
                    <label class="form-label">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" value="<?= esc($namaKegiatan) ?>" required>
                </div>

                <!-- Ruangan -->
                <div class="mb-3">
                    <label class="form-label">Pilih Ruangan</label>
                    <select name="id_room" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        <?php foreach($ruangs as $r): ?>
                            <option value="<?= $r['id_room'] ?>" <?= ($jadwal['id_room'] ?? '') == $r['id_room'] ? 'selected' : '' ?>>
                                <?= esc($r['nama_room']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Peminjam -->
                <div class="mb-3">
                    <label class="form-label">Pilih Peminjam</label>
                    <select name="id_user" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach($users as $u): ?>
                            <option value="<?= $u['id_user'] ?>" <?= ($jadwal['id_user'] ?? '') == $u['id_user'] ? 'selected' : '' ?>>
                                <?= esc($u['username']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if($isReguler): ?>
                    <!-- Tanggal (sesi akan hitung otomatis) -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                               value="<?= !empty($jadwal['tanggal_mulai']) ? date('Y-m-d', strtotime($jadwal['tanggal_mulai'])) : '' ?>" required>
                    </div>

                    <!-- Pilih Sesi -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Sesi</label>
                        <?php
                            $sesi_list = [
                                1 => "Sesi 1 (07:15 - 08:00)", 2 => "Sesi 2 (08:05 - 08:50)", 3 => "Sesi 3 (08:55 - 09:40)",
                                4 => "Sesi 4 (09:45 - 10:30)", 5 => "Sesi 5 (10:35 - 11:20)", 6 => "Sesi 6 (11:25 - 12:10)",
                                7 => "Sesi 7 (12:15 - 13:00)", 8 => "Sesi 8 (13:05 - 13:50)", 9 => "Sesi 9 (13:55 - 14:40)",
                                10=> "Sesi 10 (14:45 - 15:30)"
                            ];
                            $checkedSesi = [];
                            $mulaiSesi = date('H:i', strtotime($jadwal['tanggal_mulai'] ?? '07:15'));
                            $selesaiSesi = date('H:i', strtotime($jadwal['tanggal_selesai'] ?? '08:00'));
                            foreach($sesi_list as $val => $label){
                                preg_match("/\((.*?) - (.*?)\)/", $label, $match);
                                $sStart = $match[1]; $sEnd = $match[2];
                                if($mulaiSesi <= $sStart && $selesaiSesi >= $sEnd) $checkedSesi[] = $val;
                            }
                        ?>
                        <?php foreach($sesi_list as $val => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input sesi-check" type="checkbox" name="sesi[]" value="<?= $val ?>" id="sesi<?= $val ?>" <?= in_array($val, $checkedSesi) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sesi<?= $val ?>"><?= $label ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <input type="hidden" name="tanggal_mulai" id="tanggal_mulai" value="<?= $jadwal['tanggal_mulai'] ?? '' ?>">
                    <input type="hidden" name="tanggal_selesai" id="tanggal_selesai" value="<?= $jadwal['tanggal_selesai'] ?? '' ?>">

                <?php else: ?>
                    <!-- BOOKING → pilih tanggal mulai & selesai + jam optional -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai_tgl" class="form-control" 
                                value="<?= !empty($jadwal['tanggal_mulai']) ? date('Y-m-d', strtotime($jadwal['tanggal_mulai'])) : '' ?>" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_tgl" class="form-control" 
                                value="<?= !empty($jadwal['tanggal_selesai']) ? date('Y-m-d', strtotime($jadwal['tanggal_selesai'])) : '' ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" 
                                value="<?= !empty($jadwal['tanggal_mulai']) ? date('H:i', strtotime($jadwal['tanggal_mulai'])) : '07:15' ?>">
                        </div>
                        <div class="col">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" 
                                value="<?= !empty($jadwal['tanggal_selesai']) ? date('H:i', strtotime($jadwal['tanggal_selesai'])) : '08:00' ?>">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('jadwal/index') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if($isReguler): ?>
<script>
    const tanggalInput = document.querySelector('input[name="tanggal"]');
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

    function updateJamDariSesi() {
        const tgl = tanggalInput.value;
        const selected = Array.from(sesiCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value))
            .sort((a,b)=>a-b);
        if(!tgl || selected.length===0){
            mulaiInput.value = '';
            selesaiInput.value = '';
            return;
        }
        const first = sesiWaktu[selected[0]];
        const last  = sesiWaktu[selected[selected.length-1]];
        mulaiInput.value = tgl + 'T' + first.start;
        selesaiInput.value = tgl + 'T' + last.end;
    }

    sesiCheckboxes.forEach(cb=>cb.addEventListener('change', updateJamDariSesi));
    tanggalInput.addEventListener('change', updateJamDariSesi);
    updateJamDariSesi();
</script>
<?php endif; ?>
</body>
</html>
