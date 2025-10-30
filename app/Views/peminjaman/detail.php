<!DOCTYPE html>
<html>
<head>
    <title>Detail Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Detail Peminjaman #<?= esc($peminjaman['id_booking']) ?></h2>

    <table class="table table-striped">
        <tr>
            <th>ID Booking</th>
            <td><?= esc($peminjaman['id_booking']) ?></td>
        </tr>
        <tr>
            <th>Nama Ruang</th>
            <td><?= esc($peminjaman['nama_room'] ?? $peminjaman['ruang']) ?></td>
        </tr>
        <tr>
            <th>Pengguna</th>
            <td><?= esc($peminjaman['username'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Tanggal Mulai</th>
            <td><?= esc($peminjaman['tanggal_mulai']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Selesai</th>
            <td><?= esc($peminjaman['tanggal_selesai']) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= ucfirst(esc($peminjaman['status'])) ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?= esc($peminjaman['keterangan'] ?? '-') ?></td>
        </tr>
    </table>

    <a href="<?= base_url('peminjaman/daftar') ?>" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
