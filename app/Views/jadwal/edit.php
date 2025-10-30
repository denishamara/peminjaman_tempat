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

        <form method="post" action="/jadwal/update/<?= $jadwal['id_reguler'] ?>">
            <?= csrf_field() ?>

            <label>Nama Jadwal</label>
            <input type="text" name="nama_reguler" value="<?= esc($jadwal['nama_reguler']) ?>" required>

            <label>ID Ruangan</label>
            <input type="number" name="id_room" value="<?= esc($jadwal['id_room']) ?>" required>

            <label>ID User</label>
            <input type="number" name="id_user" value="<?= esc($jadwal['id_user']) ?>" required>

            <label>Tanggal Mulai</label>
            <input type="datetime-local" name="tanggal_mulai" value="<?= esc($jadwal['tanggal_mulai']) ?>" required>

            <label>Tanggal Selesai</label>
            <input type="datetime-local" name="tanggal_selesai" value="<?= esc($jadwal['tanggal_selesai']) ?>" required>

            <label>Keterangan</label>
            <textarea name="keterangan"><?= esc($jadwal['keterangan']) ?></textarea>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>

</body>
</html>
