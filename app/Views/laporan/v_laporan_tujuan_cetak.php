<?php
$session = session();
$userRole = $session->get('user_role');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Perjalanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            padding: 20px;
        }

        .print-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
        }

        .print-header h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .print-header p {
            color: #7f8c8d;
            margin: 5px 0;
            font-size: 0.95rem;
        }

        .print-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #555;
        }

        .print-info div {
            flex: 1;
        }

        .table {
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .table thead {
            background-color: #2c3e50;
            color: white;
        }

        .table thead th {
            border: 1px solid #2c3e50;
            padding: 12px;
            font-weight: 600;
            text-align: left;
        }

        .table tbody td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #2c3e50;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .summary-row strong {
            color: #2c3e50;
        }

        .footer-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .signature-box {
            width: 30%;
            text-align: center;
        }

        .signature-box p {
            margin: 5px 0;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        @media print {
            body {
                padding: 0;
            }

            .print-header {
                page-break-after: avoid;
            }

            .table {
                page-break-inside: avoid;
            }

            .summary-section {
                page-break-inside: avoid;
            }

            .footer-section {
                page-break-before: avoid;
            }

            @page {
                margin: 1cm;
                size: A4;
            }
        }

        @media (max-width: 768px) {
            .print-header h1 {
                font-size: 1.3rem;
            }

            .table {
                font-size: 0.8rem;
            }

            .table thead th,
            .table tbody td {
                padding: 6px;
            }

            .footer-section {
                flex-direction: column;
            }

            .signature-box {
                width: 100%;
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>
    <!-- Print Header -->
    <div class="print-header">
        <h1>LAPORAN PERJALANAN BUS</h1>
        <p>PT. Perusahaan Transportasi Wisata</p>
        <p>Jl. Contoh No. 123, Kota - Provinsi</p>
    </div>

    <!-- Print Info -->
    <div class="print-info">
        <div>
            <strong>Tujuan:</strong> <?= $tujuanTerpilih ?: 'Semua Tujuan' ?>
        </div>
        <div>
            <strong>Tanggal Cetak:</strong> <?= $tanggalCetak ?>
        </div>
        <div style="text-align: right;">
            <strong>Total Data:</strong> <?= count($laporan) ?> perjalanan
        </div>
    </div>

    <!-- Report Table -->
    <?php if (empty($laporan)): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 12%">Tanggal Berangkat</th>
                        <th style="width: 12%">Tujuan</th>
                        <th style="width: 15%">Penyewa</th>
                        <th style="width: 12%">Bus</th>
                        <th style="width: 12%">Sopir</th>
                        <th style="width: 12%">Kernet</th>
                        <th style="width: 8%">Peserta</th>
                        <th style="width: 12%">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 30px; color: #7f8c8d;">
                            <strong style="font-size: 1.1rem; color: #2c3e50;">
                                <?php if ($tujuanTerpilih): ?>
                                    Belum ada data perjalanan ke tujuan "<?= $tujuanTerpilih ?>"
                                <?php else: ?>
                                    Belum ada data perjalanan yang tercatat
                                <?php endif; ?>
                            </strong>
                            <br><br>
                            <em>Laporan ini tidak memiliki data untuk ditampilkan</em>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 12%">Tanggal Berangkat</th>
                        <th style="width: 12%">Tujuan</th>
                        <th style="width: 15%">Penyewa</th>
                        <th style="width: 12%">Bus</th>
                        <th style="width: 12%">Sopir</th>
                        <th style="width: 12%">Kernet</th>
                        <th style="width: 8%">Peserta</th>
                        <th style="width: 12%">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $totalPeserta = 0;
                    $totalBayar = 0;
                    ?>
                    <?php foreach ($laporan as $item): ?>
                        <?php
                        $totalPeserta += $item['jumlah_peserta'] ?: 0;
                        $totalBayar += $item['total_bayar'] ?: 0;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($item['tanggal_berangkat'])) ?></td>
                            <td><?= $item['tujuan'] ?: '-' ?></td>
                            <td><?= $item['nama_penyewa'] ?: '-' ?></td>
                            <td><?= $item['nomor_polisi'] ?: '-' ?> (<?= $item['merek'] ?: '-' ?>)</td>
                            <td><?= $item['nama_sopir'] ?: '-' ?></td>
                            <td><?= $item['nama_kernet'] ?: '-' ?></td>
                            <td><?= $item['jumlah_peserta'] ?: 0 ?></td>
                            <td>Rp <?= number_format($item['total_bayar'] ?: 0, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-row">
                <strong>Total Perjalanan:</strong>
                <strong><?= count($laporan) ?> perjalanan</strong>
            </div>
            <div class="summary-row">
                <strong>Total Peserta:</strong>
                <strong><?= $totalPeserta ?> orang</strong>
            </div>
            <div class="summary-row">
                <strong>Total Pendapatan:</strong>
                <strong>Rp <?= number_format($totalBayar, 0, ',', '.') ?></strong>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="footer-section">
            <div class="signature-box">
                <p>Mengetahui,</p>
                <p>Kepala Operasional</p>
                <div class="signature-line"></div>
                <p>(_________________)</p>
            </div>
            <div class="signature-box">
                <p>Dibuat oleh,</p>
                <p>Admin Sistem</p>
                <div class="signature-line"></div>
                <p>(_________________)</p>
            </div>
            <div class="signature-box">
                <p>Disetujui,</p>
                <p>Direktur</p>
                <div class="signature-line"></div>
                <p>(_________________)</p>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Auto print ketika halaman dimuat
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>