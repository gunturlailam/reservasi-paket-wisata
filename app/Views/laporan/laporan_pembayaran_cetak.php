<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .header p {
        margin: 5px 0;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-weight: bold;
        font-size: 12px;
    }

    td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 12px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .total-row {
        background-color: #e3f2fd;
        font-weight: bold;
    }

    .text-right {
        text-align: right;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #999;
    }

    @media print {
        body {
            margin: 0;
        }
    }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PEMBAYARAN BUS PARIWISATA</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">ID</th>
                <th style="width: 12%;">Tgl Bayar</th>
                <th style="width: 18%;">Penyewa</th>
                <th style="width: 20%;">Paket Wisata</th>
                <th style="width: 13%;">Metode</th>
                <th style="width: 22%; text-align: right;">Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pembayaran)) : ?>
            <?php $no = 1; ?>
            <?php foreach ($pembayaran as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>#<?= esc($row['id']) ?></td>
                <td><?= !empty($row['tanggal_bayar']) ? date('d/m/Y', strtotime($row['tanggal_bayar'])) : '-' ?></td>
                <td><?= esc($row['nama_penyewa'] ?? '-') ?></td>
                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                <td><?= esc($row['metode_bayar'] ?? '-') ?></td>
                <td class="text-right">Rp <?= number_format((float) ($row['jumlah_bayar'] ?? 0), 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
            <?php else : ?>
            <tr>
                <td colspan="7" class="no-data">Tidak ada data pembayaran untuk periode ini</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
    window.print();
    </script>
</body>

</html>