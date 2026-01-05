<?= $this->extend('main') ?>

<?= $this->section('isi') ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        padding: 30px;
        margin: -20px -20px 30px -20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 2rem;
    }

    .page-header p {
        margin: 0;
        opacity: 0.9;
    }

    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #3498db;
    }

    .filter-section .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .filter-section .form-select {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 12px;
    }

    .filter-section .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .btn-filter {
        background-color: #3498db;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        color: white;
    }

    .btn-filter:hover {
        background-color: #2980b9;
        color: white;
    }

    .btn-reset {
        background-color: #95a5a6;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        color: white;
    }

    .btn-reset:hover {
        background-color: #7f8c8d;
        color: white;
    }

    .btn-print {
        background-color: #27ae60;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        color: white;
    }

    .btn-print:hover {
        background-color: #229954;
        color: white;
    }

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #3498db;
    }

    .stat-card .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .stat-card .stat-value {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .report-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .report-section .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ecf0f1;
        font-size: 1.3rem;
    }

    .table thead {
        background-color: #2c3e50;
        color: white;
    }

    .table thead th {
        border: none;
        padding: 15px;
        font-weight: 600;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #ecf0f1;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .badge-tujuan {
        background-color: #d1ecf1;
        color: #0c5460;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-peserta {
        background-color: #d4edda;
        color: #155724;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .button-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .summary-footer {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid #ecf0f1;
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1><i class="mdi mdi-map-marker"></i> Laporan Perjalanan Berdasarkan Tujuan</h1>
    <p>Kelola dan pantau semua perjalanan bus berdasarkan destinasi tujuan</p>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <form method="GET" action="<?= base_url('laporan/tujuan') ?>" class="row g-3">
        <div class="col-6">
            <label for="tujuan" class="form-label">Pilih Tujuan</label>
            <select class="form-select" id="tujuan" name="tujuan">
                <option value="">-- Semua Tujuan --</option>
                <?php foreach ($daftarTujuan as $item): ?>
                    <option value="<?= $item['tujuan'] ?>" <?= ($tujuanTerpilih === $item['tujuan']) ? 'selected' : '' ?>>
                        <?= $item['tujuan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-6">
            <label class="form-label">&nbsp;</label>
            <div class="button-group">
                <button type="submit" class="btn btn-filter">
                    <i class="mdi mdi-filter"></i> Filter
                </button>
                <a href="<?= base_url('laporan/tujuan') ?>" class="btn btn-reset">
                    <i class="mdi mdi-refresh"></i> Reset
                </a>
                <?php if ($totalData > 0): ?>
                    <button type="button" class="btn btn-print" onclick="window.print()">
                        <i class="mdi mdi-printer"></i> Cetak
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<!-- Statistics -->
<?php if ($totalData > 0): ?>
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-bus"></i> Total Perjalanan</div>
            <div class="stat-value"><?= $totalData ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-map-marker"></i> Tujuan</div>
            <div class="stat-value"><?= $tujuanTerpilih ?: 'Semua' ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-calendar"></i> Periode</div>
            <div class="stat-value"><?= date('Y') ?></div>
        </div>
    </div>
<?php endif; ?>

<!-- Report Section -->
<div class="report-section">
    <h2 class="section-title">
        <i class="mdi mdi-table"></i>
        <?= $tujuanTerpilih ? 'Laporan Perjalanan ke ' . $tujuanTerpilih : 'Laporan Semua Perjalanan' ?>
    </h2>

    <?php if (empty($laporan)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tujuan</th>
                        <th>Penyewa</th>
                        <th>Bus</th>
                        <th>Sopir</th>
                        <th>Kernet</th>
                        <th>Peserta</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 40px 20px; color: #7f8c8d;">
                            <i class="mdi mdi-inbox" style="font-size: 2rem; margin-bottom: 15px; opacity: 0.5; display: block;"></i>
                            <strong style="font-size: 1.1rem; color: #2c3e50;">
                                <?php if ($tujuanTerpilih): ?>
                                    Belum ada data perjalanan ke tujuan "<?= $tujuanTerpilih ?>"
                                <?php else: ?>
                                    Belum ada data perjalanan yang tercatat
                                <?php endif; ?>
                            </strong>
                            <br>
                            <small style="margin-top: 5px; display: block;">
                                <?php if ($tujuanTerpilih): ?>
                                    Coba pilih tujuan lain atau reset filter untuk melihat semua data
                                <?php else: ?>
                                    Silakan tambahkan data perjalanan terlebih dahulu
                                <?php endif; ?>
                            </small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tujuan</th>
                        <th>Penyewa</th>
                        <th>Bus</th>
                        <th>Sopir</th>
                        <th>Kernet</th>
                        <th>Peserta</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($laporan as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= date('d/m/Y', strtotime($item['tanggal_berangkat'])) ?></strong>
                                <br>
                                <small class="text-muted"><?= date('H:i', strtotime($item['tanggal_berangkat'])) ?></small>
                            </td>
                            <td>
                                <span class="badge-tujuan"><?= $item['tujuan'] ?: '-' ?></span>
                            </td>
                            <td>
                                <strong><?= $item['nama_penyewa'] ?: '-' ?></strong>
                                <br>
                                <small class="text-muted"><?= $item['nohp_penyewa'] ?: '-' ?></small>
                            </td>
                            <td>
                                <strong><?= $item['nomor_polisi'] ?: '-' ?></strong>
                                <br>
                                <small class="text-muted"><?= $item['merek'] ?: '-' ?></small>
                            </td>
                            <td>
                                <strong><?= $item['nama_sopir'] ?: '-' ?></strong>
                            </td>
                            <td>
                                <strong><?= $item['nama_kernet'] ?: '-' ?></strong>
                            </td>
                            <td>
                                <span class="badge-peserta"><?= $item['jumlah_peserta'] ?: 0 ?> orang</span>
                            </td>
                            <td>
                                <strong>Rp <?= number_format($item['total_bayar'] ?: 0, 0, ',', '.') ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Footer -->
        <div class="summary-footer">
            <div class="row">
                <div class="col-6">
                    <p><strong>Total Perjalanan:</strong> <?= count($laporan) ?> perjalanan</p>
                </div>
                <div class="col-6 text-end">
                    <p><strong>Total Pendapatan:</strong> Rp <?= number_format(array_sum(array_column($laporan, 'total_bayar')), 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>