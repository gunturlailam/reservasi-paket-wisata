<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #333;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            font-size: 13px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background-color: #f8f9fa;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }

        table th {
            font-weight: bold;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .summary h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .summary p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .btn-print {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }

        @media print {
            .btn-print {
                display: none;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak Laporan</button>

    <div class="header">
        <h1>LAPORAN DATA PEMESANAN</h1>
        <p>Sistem Informasi Pemesanan Paket Wisata & Bus</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> <?= date('d F Y, H:i') ?> WIB</p>
        <p><strong>Total Data:</strong> <?= count($pemesanan) ?> Pemesanan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th style="width: 80px;">ID</th>
                <th>Tanggal Pesan</th>
                <th>Nama Penyewa</th>
                <th>Paket Bus</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pemesanan)) : ?>
                <?php
                $no = 1;
                $totalKeseluruhan = 0;
                foreach ($pemesanan as $row) :
                    $totalKeseluruhan += (float) $row['total_bayar'];
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($row['id']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_pesan'])) ?></td>
                        <td><?= esc($row['nama_penyewa'] ?? '-') ?></td>
                        <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                        <td class="text-right">Rp <?= number_format((float) $row['total_bayar'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="background-color: #e9ecef; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL KESELURUHAN:</td>
                    <td class="text-right">Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data pemesanan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p>📊 Jumlah Pemesanan: <strong><?= count($pemesanan) ?></strong></p>
        <p>💰 Total Pendapatan: <strong>Rp <?= number_format($totalKeseluruhan ?? 0, 0, ',', '.') ?></strong></p>
    </div>
</body>

</html>