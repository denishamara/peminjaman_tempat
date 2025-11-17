<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Ruangan</title>
    <style>
        body { 
            font-family: "DejaVu Sans", "Arial", sans-serif; 
            font-size: 10px; 
            margin: 20px; 
            line-height: 1.2;
        }
        h1, h2, h4 { 
            text-align: center; 
            margin: 0; 
            padding: 0;
        }
        h1 { 
            font-size: 16px; 
            margin-bottom: 3px; 
            font-weight: bold;
        }
        h2 { 
            font-size: 14px; 
            margin-bottom: 3px; 
            font-weight: bold;
        }
        h4 { 
            font-size: 12px; 
            margin-bottom: 15px;
        }
        .header-info { 
            margin: 15px 0; 
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            font-size: 9px;
        }
        table, th, td { 
            border: 1px solid #333; 
        }
        th, td { 
            padding: 5px 6px; 
            text-align: left;
            word-wrap: break-word;
        }
        th { 
            background-color: #343a40; 
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer { 
            margin-top: 30px; 
            text-align: right; 
            font-size: 9px;
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        .text-center { 
            text-align: center; 
        }
        .page-break {
            page-break-after: always;
        }
        /* Status colors */
        .status-diterima { color: #28a745; font-weight: bold; }
        .status-ditolak { color: #dc3545; font-weight: bold; }
        .status-proses { color: #ffc107; font-weight: bold; }
        .status-selesai { color: #17a2b8; font-weight: bold; }
    </style>
</head>
<body>
    <h1>SMKN 1 Bantul</h1>
    <h2>Smart Room</h2>
    <h4>Laporan Peminjaman Ruangan</h4>

    <div class="header-info">
        <strong>Periode:</strong> <?= !empty($tanggalMulai) && !empty($tanggalSelesai) ? $tanggalMulai . " s/d " . $tanggalSelesai : 'Semua' ?><br>
        <strong>Status:</strong> <?= !empty($status) ? ucfirst($status) : 'Semua' ?><br>
        <strong>Bulan/Tahun:</strong> <?= !empty($bulan) ? $bulan . '/' : '' ?><?= !empty($tahun) ? $tahun : '' ?><br>
        <strong>Dicetak oleh:</strong> <?= $user['username'] ?? '-' ?><br>
        <strong>Tanggal Cetak:</strong> <?= date('d-m-Y H:i:s') ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="14%">Peminjam</th>
                <th width="14%">Ruangan</th>
                <th width="14%">Tanggal Mulai</th>
                <th width="14%">Tanggal Selesai</th>
                <th width="10%">Status</th>
                <th width="30%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($bookings)): ?>
                <?php $no = 1; foreach($bookings as $b): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($b['username'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($b['nama_room'] ?? '-') ?></td>
                        <td><?= isset($b['tanggal_mulai']) ? date('d-m-Y H:i', strtotime($b['tanggal_mulai'])) : '-' ?></td>
                        <td><?= isset($b['tanggal_selesai']) ? date('d-m-Y H:i', strtotime($b['tanggal_selesai'])) : '-' ?></td>
                        <td class="status-<?= strtolower($b['status'] ?? '') ?>">
                            <?= isset($b['status']) ? ucfirst($b['status']) : '-' ?>
                        </td>
                        <td><?= htmlspecialchars($b['keterangan'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <?= date('d-m-Y H:i:s') ?><br>
        <strong>Admin SmartRoom</strong><br>
        SMKN 1 Bantul
    </div>
</body>
</html>