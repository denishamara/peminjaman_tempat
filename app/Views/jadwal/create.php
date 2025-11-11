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
        .main-content {
            margin-left: 260px;
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
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ⚠️ <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ✅ <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/jadwal/store') ?>">
                    <?= csrf_field() ?>

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

                    <!-- 📅 Pilih tanggal -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <!-- 🕒 Pilih beberapa sesi -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Sesi</label>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="1" id="sesi1">
                            <label class="form-check-label" for="sesi1">Sesi 1 (07:15 - 08:00)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="2" id="sesi2">
                            <label class="form-check-label" for="sesi2">Sesi 2 (08:05 - 08:50)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="3" id="sesi3">
                            <label class="form-check-label" for="sesi3">Sesi 3 (08:55 - 09:40)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="4" id="sesi4">
                            <label class="form-check-label" for="sesi4">Sesi 4 (09:45 - 10:30)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="5" id="sesi5">
                            <label class="form-check-label" for="sesi5">Sesi 5 (10:35 - 11:20)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="6" id="sesi5">
                            <label class="form-check-label" for="sesi6">Sesi 6 (11:25 - 12:10)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="7" id="sesi5">
                            <label class="form-check-label" for="sesi7">Sesi 7 (12:15 - 13:00)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="8" id="sesi5">
                            <label class="form-check-label" for="sesi8">Sesi 8 (13:05 - 13:50)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="9" id="sesi5">
                            <label class="form-check-label" for="sesi9">Sesi 9 (13:55 - 14:40)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sesi-check" type="checkbox" value="10" id="sesi5">
                            <label class="form-check-label" for="sesi10">Sesi 10 (14:45 - 15:30)</label>
                        </div>
                    </div>

                    <!-- Hidden fields -->
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const tanggalInput = document.getElementById('tanggal');
    const mulaiInput = document.getElementById('tanggal_mulai');
    const selesaiInput = document.getElementById('tanggal_selesai');
    const sesiCheckboxes = document.querySelectorAll('.sesi-check');

    const sesiWaktu = {
        1: { start: "07:15", end: "08:00" },
        2: { start: "08:05", end: "08:50" },
        3: { start: "08:55", end: "09:40" },
        4: { start: "10:35", end: "11:20" },
        6: { start: "11:25", end: "12:10" },
        7: { start: "12:15", end: "13:00" },
        8: { start: "13:05", end: "13:50" },
        9: { start: "13:55", end: "14:40" },
        10: { start: "14:45", end: "15:30" }
    };

    sesiCheckboxes.forEach(cb => cb.addEventListener('change', updateDateTime));
    tanggalInput.addEventListener('change', updateDateTime);

    function updateDateTime() {
        const tanggal = tanggalInput.value;
        const selected = Array.from(sesiCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value))
            .sort((a, b) => a - b);

        if (!tanggal || selected.length === 0) return;

        const first = sesiWaktu[selected[0]];
        const last = sesiWaktu[selected[selected.length - 1]];

        mulaiInput.value = `${tanggal}T${first.start}`;
        selesaiInput.value = `${tanggal}T${last.end}`;
    }
    </script>
</body>
</html>
