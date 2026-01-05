<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan Keberangkatan - PB-<?= $pemberangkatan['id'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            padding: 20px;
            background: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 2px solid #000;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: normal;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 25px;
        }

        .nomor-surat span {
            border: 1px solid #000;
            padding: 5px 20px;
            font-weight: bold;
        }

        .content {
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            background: #f0f0f0;
            padding: 8px 10px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 10px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        .detail-table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-box .title {
            margin-bottom: 60px;
        }

        .signature-box .name {
            border-top: 1px solid #000;
            padding-top: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @media print {
            body {
                padding: 0;
            }

            .container {
                border: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 25px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print:hover {
            background: #0d47a1;
        }
    </style>
</head>

<body>
    <button class="btn-print no-print" onclick="window.print()">
        🖨️ Cetak Surat Jalan
    </button>

    <div class="container">
        <div class="header">
            <h1>SURAT JALAN KEBERANGKATAN</h1>
            <h2>PO. Bus Pariwisata</h2>
        </div>

        <div class="nomor-surat">
            <span>No: PB-<?= str_pad($pemberangkatan['id'], 4, '0', STR_PAD_LEFT) ?></span>
        </div>

        <div class="content">
            <!-- Info Penyewa -->
            <div class="section">
                <div class="section-title">DATA PENYEWA</div>
                <table class="info-table">
                    <tr>
                        <td>Nama Penyewa</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['nama_penyewa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['alamat_penyewa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['nohp_penyewa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>No. Pemesanan</td>
                        <td>:</td>
                        <td>#<?= esc($pemberangkatan['kode_pemesanan'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>

            <!-- Info Perjalanan -->
            <div class="section">
                <div class="section-title">DATA PERJALANAN</div>
                <table class="info-table">
                    <tr>
                        <td>Paket Wisata</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['nama_paket'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['tujuan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Berangkat</td>
                        <td>:</td>
                        <td><?= date('d F Y', strtotime($pemberangkatan['tanggal_berangkat'])) ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Kembali</td>
                        <td>:</td>
                        <td><?= !empty($pemberangkatan['tanggal_kembali']) ? date('d F Y', strtotime($pemberangkatan['tanggal_kembali'])) : '-' ?></td>
                    </tr>
                </table>
            </div>

            <!-- Info Armada -->
            <div class="section">
                <div class="section-title">DATA ARMADA & KRU</div>
                <table class="info-table">
                    <tr>
                        <td>Nomor Polisi</td>
                        <td>:</td>
                        <td><strong><?= esc($pemberangkatan['nomor_polisi'] ?? '-') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Merek / Tipe Bus</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['merek'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Kapasitas</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['kapasitas'] ?? '-') ?> Penumpang</td>
                    </tr>
                    <tr>
                        <td>Sopir</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['nama_sopir'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td>Kernet</td>
                        <td>:</td>
                        <td><?= esc($pemberangkatan['nama_kernet'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>

            <!-- Catatan -->
            <div class="section">
                <div class="section-title">CATATAN</div>
                <ol style="margin-left: 20px; margin-top: 10px;">
                    <li>Surat jalan ini wajib dibawa selama perjalanan.</li>
                    <li>Sopir bertanggung jawab atas keselamatan penumpang dan kendaraan.</li>
                    <li>Dilarang mengangkut barang terlarang.</li>
                    <li>Patuhi peraturan lalu lintas yang berlaku.</li>
                </ol>
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="signatures">
            <div class="signature-box">
                <div class="title">Sopir,</div>
                <div class="name">( <?= esc($pemberangkatan['nama_sopir'] ?? '....................') ?> )</div>
            </div>
            <div class="signature-box">
                <div class="title">Kernet,</div>
                <div class="name">( <?= esc($pemberangkatan['nama_kernet'] ?? '....................') ?> )</div>
            </div>
            <div class="signature-box">
                <div class="title">Admin Operasional,</div>
                <div class="name">( ........................ )</div>
            </div>
        </div>

        <div class="footer">
            Dicetak pada: <?= date('d F Y H:i:s') ?> WIB
        </div>
    </div>
</body>

</html>