<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Peminjaman Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
/* ============================================
   HALAMAN PEMINJAMAN — FIX TOTAL
   ============================================ */

/* ============================================
   HALAMAN PEMINJAMAN — FIX TOTAL & RAPIH
   ============================================ */

.peminjaman-page {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
    overflow-x: hidden;
}

/* ===== Layout Desktop (ada sidebar) ===== */
.peminjaman-body.has-sidebar {
    min-height: 100vh;
    padding: 40px 40px 40px 280px; /* ruang kiri untuk sidebar */
    box-sizing: border-box;
}

/* ===== Card ===== */
.peminjaman-card {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 650px;
    margin: auto; /* selalu center */
    margin-top: 10px;
}

/* ===== Title ===== */
.peminjaman-card h2 {
    margin-bottom: 20px;
    font-weight: 600;
}

/* ===== Label & Input ===== */
.peminjaman-card form label {
    font-weight: 500;
    margin-top: 15px;
}

.peminjaman-card input,
.peminjaman-card textarea {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

/* =============================
   FIX DROPDOWN SELECT
   ============================= */
.select-wrapper {
    width: 100%;
    overflow: hidden;
    position: relative;
}

.select-wrapper select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    max-width: 100%;
    box-sizing: border-box;
}

.select-wrapper option {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ===== Button ===== */
.peminjaman-card button {
    margin-top: 25px;
    padding: 10px 18px;
    background-color: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
}

.peminjaman-card button:hover {
    background-color: #0b5ed7;
}

/* ============================================
   RESPONSIVE TABLET / HP
   ============================================ */
@media (max-width: 991px) {
    .peminjaman-body.has-sidebar {
        padding: 120px 20px 20px 20px; /* sidebar tidak menutupi */
    }

    .peminjaman-card {
        width: 92%;
        margin: 0 auto;
        margin-top: 130px;
    }
}

/* ==== HP kecil ==== */
@media (max-width: 576px) {
    .peminjaman-card {
        padding: 20px;
        margin-top: 140px;
    }

    .select-wrapper select,
    .peminjaman-card input,
    .peminjaman-card textarea {
        font-size: 14px;
        padding: 10px;
    }
}

    </style>
</head>

<body class="peminjaman-page peminjaman-body has-sidebar">

<?= view('layouts/sidebar') ?>

<div class="peminjaman-container">
    <div class="peminjaman-card">
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

            <?php $now = date('Y-m-d\TH:i'); ?>

            <div class="select-wrapper">
    <select name="id_room" id="ruang" required>
        <option value="">-- Pilih Ruang --</option>
        <?php foreach($rooms as $room): ?>
            <option value="<?= esc($room['id_room']) ?>">
                <?= esc($room['nama_room']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

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
</div>

<script>
// ========== Logika tanggal dinamis ==========
const mulaiInput = document.getElementById('tanggal_mulai');
const selesaiInput = document.getElementById('tanggal_selesai');

mulaiInput.addEventListener('change', () => {
    selesaiInput.min = mulaiInput.value;
    if (selesaiInput.value && selesaiInput.value < mulaiInput.value) {
        selesaiInput.value = '';
    }
});
</script>

</body>
</html>
