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
                $tipe = $isReguler ? 'reguler' : 'booking';
                $id = $isReguler ? $jadwal['id_reguler'] : $jadwal['id_booking'];
                $selectedRoomId = $jadwal['id_room'] ?? $jadwal['id_ruang'] ?? '';
                $selectedUserId = $jadwal['id_user'] ?? $jadwal['id_peminjam'] ?? '';
                $tanggal = date('Y-m-d', strtotime($jadwal['tanggal_mulai']));
                $mulaiJam = date('H:i', strtotime($jadwal['tanggal_mulai']));
                $selesaiJam = date('H:i', strtotime($jadwal['tanggal_selesai']));
                ?>

                <form method="post" action="<?= base_url('/jadwal/update/' . $id) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tipe" value="<?= $tipe ?>">

                    <!-- Nama Kegiatan -->
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" 
                               value="<?= esc($jadwal['nama_reguler'] ?? $jadwal['keterangan'] ?? '') ?>" required>
                    </div>

                    <!-- Ruangan -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Ruangan</label>
                        <select name="id_room" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach($ruangs as $ruang): ?>
                                <option value="<?= $ruang['id_room'] ?>" <?= $ruang['id_room']==$selectedRoomId?'selected':'' ?>>
                                    <?= esc($ruang['nama_room']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Peminjam -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Peminjam</label>
                        <select name="id_user" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?= $user['id_user'] ?>" <?= $user['id_user']==$selectedUserId?'selected':'' ?>>
                                    <?= esc($user['username']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>" required>
                    </div>

                    <?php if($isReguler): ?>
                        <!-- Pilih Sesi (checkbox) -->
                        <?php 
                        $sesi_list = [
                            1 => "Sesi 1 (07:15 - 08:00)", 2 => "Sesi 2 (08:05 - 08:50)", 3 => "Sesi 3 (08:55 - 09:40)",
                            4 => "Sesi 4 (09:45 - 10:30)", 5 => "Sesi 5 (10:35 - 11:20)", 6 => "Sesi 6 (11:25 - 12:10)",
                            7 => "Sesi 7 (12:15 - 13:00)", 8 => "Sesi 8 (13:05 - 13:50)", 9 => "Sesi 9 (13:55 - 14:40)",
                            10=> "Sesi 10 (14:45 - 15:30)"
                        ];
                        $checkedSesi = [];
                        $mulaiJam = date('H:i', strtotime($jadwal['tanggal_mulai']));
                        $selesaiJam = date('H:i', strtotime($jadwal['tanggal_selesai']));
                        foreach($sesi_list as $val => $label){
                            preg_match("/\((.*?) - (.*?)\)/", $label, $match);
                            $sStart = $match[1];
                            $sEnd = $match[2];
                            if($mulaiJam <= $sStart && $selesaiJam >= $sEnd) $checkedSesi[] = $val;
                        }
                        ?>
                        <div class="mb-3">
                            <label class="form-label">Pilih Sesi</label>
                            <?php foreach($sesi_list as $val => $label): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sesi[]" value="<?= $val ?>" 
                                           id="sesi<?= $val ?>" <?= in_array($val, $checkedSesi)?'checked':'' ?>>
                                    <label class="form-check-label" for="sesi<?= $val ?>"><?= $label ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <!-- Booking → jam manual -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="tanggal_mulai" class="form-control" value="<?= $mulaiJam ?>" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="tanggal_selesai" class="form-control" value="<?= $selesaiJam ?>" required>
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

</body>
</html>
