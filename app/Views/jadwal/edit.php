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

        <form method="post" action="/jadwal/update/<?= $jadwal['id_reguler'] ?>">
            <?= csrf_field() ?>

            <label>Nama Jadwal</label>
            <input type="text" name="nama_reguler" value="<?= esc($jadwal['nama_reguler']) ?>" required>

            <!-- Dropdown Ruangan -->
            <label>Ruangan</label>
            <select name="id_room" required>
                <option value="">-- Pilih Ruangan --</option>
                <?php foreach ($ruangs as $r): ?>
                    <option value="<?= $r['id_room'] ?>" <?= $jadwal['id_room'] == $r['id_room'] ? 'selected' : '' ?>>
                        <?= esc($r['nama_room']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown User -->
            <label>User</label>
            <select name="id_user" required>
                <option value="">-- Pilih User --</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id_user'] ?>" <?= $jadwal['id_user'] == $u['id_user'] ? 'selected' : '' ?>>
                        <?= esc($u['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Tanggal Mulai</label>
            <input type="datetime-local" name="tanggal_mulai" 
                   value="<?= date('Y-m-d\TH:i', strtotime($jadwal['tanggal_mulai'])) ?>" required>

            <label>Tanggal Selesai</label>
            <input type="datetime-local" name="tanggal_selesai" 
                   value="<?= date('Y-m-d\TH:i', strtotime($jadwal['tanggal_selesai'])) ?>" required>

            <label>Keterangan</label>
            <textarea name="keterangan"><?= esc($jadwal['keterangan']) ?></textarea>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <button type="submit">Update</button>
                <a href="/jadwal/index" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
