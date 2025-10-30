<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Peminjaman Ruang</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="peminjaman-body has-sidebar">

<?= view('layouts/sidebar') ?>

<div class="peminjaman-container">
    <h2>Ajukan Peminjaman Ruang</h2>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-error">
            <ul style="text-align:left; margin:0; padding-left:18px;">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('peminjaman/submit') ?>" method="post">
        <?= csrf_field() ?>

        <?php 
            // waktu sekarang dalam format datetime-local (YYYY-MM-DDTHH:MM)
            $now = date('Y-m-d\TH:i'); 
        ?>

        <label for="ruang">Pilih Ruang</label>
        <select name="id_room" id="ruang" required>
            <option value="">-- Pilih Ruang --</option>
            <?php foreach($rooms as $room): ?>
                <option value="<?= esc($room['id_room']) ?>" <?= old('id_room') == $room['id_room'] ? 'selected' : '' ?>>
                    <?= esc($room['nama_room']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="tanggal_mulai">Tanggal & Jam Mulai</label>
        <input 
            type="datetime-local" 
            name="tanggal_mulai" 
            id="tanggal_mulai" 
            required
            min="<?= $now ?>"
            value="<?= old('tanggal_mulai') ? date('Y-m-d\TH:i', strtotime(old('tanggal_mulai'))) : '' ?>"
        >

        <label for="tanggal_selesai">Tanggal & Jam Selesai</label>
        <input 
            type="datetime-local" 
            name="tanggal_selesai" 
            id="tanggal_selesai" 
            required
            value="<?= old('tanggal_selesai') ? date('Y-m-d\TH:i', strtotime(old('tanggal_selesai'))) : '' ?>"
        >

        <label for="keterangan">Keterangan</label>
        <textarea 
            name="keterangan" 
            id="keterangan" 
            rows="3" 
            placeholder="Tuliskan keperluan peminjaman..." 
            required><?= old('keterangan') ?></textarea>

        <button type="submit">Ajukan Peminjaman</button>
    </form>
</div>

<script>
// ========== Logika tanggal dinamis ==========
const mulaiInput = document.getElementById('tanggal_mulai');
const selesaiInput = document.getElementById('tanggal_selesai');

// Saat tanggal mulai berubah, ubah minimal tanggal selesai
mulaiInput.addEventListener('change', () => {
    selesaiInput.min = mulaiInput.value;
    // Kalau tanggal selesai < tanggal mulai, kosongkan
    if (selesaiInput.value && selesaiInput.value < mulaiInput.value) {
        selesaiInput.value = '';
    }
});
</script>

</body>
</html>
