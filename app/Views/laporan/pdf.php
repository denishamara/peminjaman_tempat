<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman Ruangan</h2>
    <h4>Periode: <?= $tanggalMulai ?> s/d <?= $tanggalSelesai ?></h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($bookings as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b['username'] ?></td>
                <td><?= $b['nama_room'] ?></td>
                <td><?= $b['tanggal_mulai'] ?></td>
                <td><?= $b['tanggal_selesai'] ?></td>
                <td><?= ucfirst($b['status']) ?></td>
                <td><?= $b['keterangan'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
