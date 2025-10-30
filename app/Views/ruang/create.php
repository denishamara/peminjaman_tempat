<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Ruang Baru</h4>
        </div>

        <div class="card-body">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('ruang/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Nama Ruang</label>
                    <input type="text" name="nama_room" class="form-control" placeholder="Masukkan nama ruang" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi ruang" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Tuliskan deskripsi ruang (opsional)" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" placeholder="Masukkan kapasitas ruang" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('ruang/index') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-success">💾 Simpan Ruang</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
