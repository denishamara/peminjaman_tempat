<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="edit-jadwal-body">
<?= view('layouts/sidebar') ?>

<div class="edit-container">
    <h2>Edit Jadwal</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php
        // Deteksi tipe data
        $isReguler = isset($jadwal['id_reguler']);
        $id = $isReguler ? $jadwal['id_reguler'] : $jadwal['id_booking'];
        $tipe = $isReguler ? 'reguler' : 'booking';

        // Nama kegiatan diambil dari kolom berbeda
        $namaKegiatan = $isReguler
            ? ($jadwal['nama_reguler'] ?? '')
            : ($jadwal['keterangan'] ?? '');
    ?>

    <form method="post" action="<?= base_url('jadwal/update/' . $id) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="tipe" value="<?= esc($tipe) ?>">

        <label>Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" value="<?= esc($namaKegiatan) ?>" required>

        <label>Ruangan</label>
        <select name="id_room" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php foreach ($ruangs as $r): ?>
                <option value="<?= $r['id_room'] ?>" <?= ($jadwal['id_room'] ?? '') == $r['id_room'] ? 'selected' : '' ?>>
                    <?= esc($r['nama_room']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>User</label>
        <select name="id_user" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $u): ?>
                <option value="<?= $u['id_user'] ?>" <?= ($jadwal['id_user'] ?? '') == $u['id_user'] ? 'selected' : '' ?>>
                    <?= esc($u['username']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Tanggal Mulai</label>
        <input type="datetime-local" name="tanggal_mulai"
               value="<?= !empty($jadwal['tanggal_mulai']) ? date('Y-m-d\TH:i', strtotime($jadwal['tanggal_mulai'])) : '' ?>" required>

        <label>Tanggal Selesai</label>
        <input type="datetime-local" name="tanggal_selesai"
               value="<?= !empty($jadwal['tanggal_selesai']) ? date('Y-m-d\TH:i', strtotime($jadwal['tanggal_selesai'])) : '' ?>" required>

        <label>Keterangan (opsional)</label>
        <textarea name="keterangan"><?= esc($jadwal['keterangan'] ?? '') ?></textarea>

        <?php if (!$isReguler): ?>
            <label>Status Booking</label>
            <select name="status" required>
                <option value="Proses" <?= ($jadwal['status'] ?? '') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                <option value="Diterima" <?= ($jadwal['status'] ?? '') == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                <option value="Ditolak" <?= ($jadwal['status'] ?? '') == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        <?php endif; ?>

        <div style="margin-top: 15px; display: flex; justify-content: space-between;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('jadwal/index') ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
