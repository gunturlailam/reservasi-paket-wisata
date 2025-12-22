<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Paket Wisata</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 10px;
            font-weight: 800;
        }

        .header p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 13px;
            color: #555;
        }

        .info-row span {
            display: flex;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #667eea;
        }

        td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            font-size: 13px;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #f0f0f0;
        }

        tbody tr:last-child td {
            border-bottom: 2px solid #667eea;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            border-radius: 4px;
            font-size: 13px;
            color: #555;
        }

        .summary strong {
            color: #667eea;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }

        @page {
            size: A4;
            margin: 10mm;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>✈️ LAPORAN DATA PAKET WISATA</h1>
            <p>G-Tour Reservasi Wisata</p>
            <div class="info-row">
                <span>
                    <strong>Tanggal Cetak:</strong>
                    <?= date('d F Y', strtotime(date('Y-m-d'))) ?>
                </span>
                <span>
                    <strong>Waktu:</strong>
                    <?= date('H:i:s') ?>
                </span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 30%;">Nama Paket</th>
                    <th style="width: 30%;">Tujuan</th>
                    <th style="width: 32%;">Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($paketwisata as $item) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $item['nama_paket'] ?></td>
                        <td><?= $item['tujuan'] ?></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary">
            <strong>Total Paket Wisata:</strong> <?= count($paketwisata) ?> paket
        </div>

        <div class="footer">
            <p>Laporan ini dicetak secara otomatis oleh sistem G-Tour</p>
            <p>© <?= date('Y') ?> G-Tour Reservasi Wisata. All rights reserved.</p>
        </div>
    </div>
</body>

</html>