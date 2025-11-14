<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Peminjaman Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <style>
        .peminjaman-page { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .peminjaman-body.has-sidebar { min-height: 100vh; padding: 40px 40px 40px 280px; box-sizing: border-box; }
        .peminjaman-card { background-color: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); width: 100%; max-width: 650px; margin: 10px auto; }
        .peminjaman-card h2 { margin-bottom: 20px; font-weight: 600; }
        .peminjaman-card form label { font-weight: 500; margin-top: 15px; }
        .peminjaman-card input, .peminjaman-card textarea { width: 100%; padding: 10px 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; }
        .peminjaman-card button { margin-top: 25px; padding: 10px 18px; background-color: #0d6efd; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        .peminjaman-card button:hover { background-color: #0b5ed7; }

        /* responsive */
        @media (max-width: 991px) { .peminjaman-body.has-sidebar { padding: 120px 20px 20px 20px; } .peminjaman-card { width: 92%; margin-top: 130px; } }
        @media (max-width: 576px) { .peminjaman-card { padding: 20px; margin-top: 140px; } .peminjaman-card input, .peminjaman-card textarea { font-size: 14px; padding: 10px; } }
    </style>
</head>
<body class="peminjaman-page peminjaman-body has-sidebar">

<?= view('layouts/sidebar') ?>

<div class="peminjaman-container">
    <div class="peminjaman-card">
        <h2>Ajukan Peminjaman Ruang</h2>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
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

            <!-- Dropdown Ruang -->
            <div class="mb-3">
                <label class="form-label">Pilih Ruang</label>
                <select id="ruangSelect" name="id_room" class="form-select" required>
                    <option value="">-- Pilih Ruang --</option>
                    <?php foreach($rooms as $room): ?>
                        <option value="<?= esc($room['id_room']) ?>" <?= old('id_room') == $room['id_room'] ? 'selected' : '' ?>>
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
    // tanggal dinamis
    const mulaiInput = document.getElementById('tanggal_mulai');
    const selesaiInput = document.getElementById('tanggal_selesai');
    mulaiInput.addEventListener('change', () => {
        selesaiInput.min = mulaiInput.value;
        if (selesaiInput.value && selesaiInput.value < mulaiInput.value) selesaiInput.value = '';
    });

    // Choices.js untuk dropdown
    const ruangChoices = new Choices('#ruangSelect', {
        searchEnabled: true,
        itemSelectText: '',
        shouldSort: false
    });

    // set pilihan lama (old value)
    const oldValue = '<?= old('id_room') ?>';
    if(oldValue) ruangChoices.setChoiceByValue(oldValue);
</script>

</body>
</html>
