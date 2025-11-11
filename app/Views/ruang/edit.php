<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* === Layout untuk menghindari tabrakan sidebar === */
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Sidebar biar tetap di kiri */
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            background-color: #ffffff;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            z-index: 1000;
        }

        /* Konten utama biar ga nabrak sidebar */
        .main-content {
            flex-grow: 1;
            margin-left: 250px; /* jarak sesuai lebar sidebar */
            padding: 40px 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                box-shadow: none;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?= view('layouts/sidebar') ?>

    <!-- Konten utama -->
    <div class="main-content">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Ruang</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/ruang/update/' . $ruang['id_room']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama_room" class="form-label">Nama Ruang</label>
                            <input type="text" name="nama_room" id="nama_room"
                                   value="<?= esc($ruang['nama_room']) ?>"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi"
                                   value="<?= esc($ruang['lokasi']) ?>"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"
                                      rows="3"><?= esc($ruang['deskripsi']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas</label>
                            <input type="number" name="kapasitas" id="kapasitas"
                                   value="<?= esc($ruang['kapasitas']) ?>"
                                   class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">💾 Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
