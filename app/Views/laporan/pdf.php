<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Ruangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 30px; }
        h1, h2, h4 { text-align: center; margin: 0; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        h2 { font-size: 16px; margin-bottom: 5px; }
        h4 { font-size: 14px; margin-bottom: 20px; }
        .header-info { margin-top: 20px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <h1>SMKN 1 Bantul</h1>
    <h2>Smart Room</h2>
    <h4>Laporan Peminjaman Ruangan</h4>

    <div class="header-info">
        <strong>Periode:</strong> <?= isset($tanggalMulai) && isset($tanggalSelesai) ? $tanggalMulai . " s/d " . $tanggalSelesai : '-' ?><br>
        <strong>Dicetak oleh:</strong> <?= session()->get('user')['username'] ?? '-' ?>
    </div>

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
            <?php if(!empty($bookings)): ?>
                <?php $no = 1; foreach($bookings as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($b['username'] ?? '-') ?></td>
                        <td><?= esc($b['nama_room'] ?? '-') ?></td>
                        <td><?= isset($b['tanggal_mulai']) ? date('d-m-Y H:i', strtotime($b['tanggal_mulai'])) : '-' ?></td>
                        <td><?= isset($b['tanggal_selesai']) ? date('d-m-Y H:i', strtotime($b['tanggal_selesai'])) : '-' ?></td>
                        <td><?= isset($b['status']) ? ucfirst($b['status']) : '-' ?></td>
                        <td><?= esc($b['keterangan'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <?= date('d-m-Y') ?><br>
        <strong>Admin</strong><br><br><br>
        ______________________
    </div>
</body>
</html>
