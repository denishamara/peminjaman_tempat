<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Ruang</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/ruang/update/' . $ruang['id_room']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nama_room" class="form-label">Nama Ruang</label>
                    <input type="text" name="nama_room" id="nama_room" value="<?= esc($ruang['nama_room']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" value="<?= esc($ruang['lokasi']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"><?= esc($ruang['deskripsi']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" id="kapasitas" value="<?= esc($ruang['kapasitas']) ?>" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('/ruang/index') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">💾 Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
