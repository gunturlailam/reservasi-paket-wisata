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

    .filter-section .form-select,
    .filter-section .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 12px;
    }

    .filter-section .form-select:focus,
    .filter-section .form-control:focus {
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

    .periode-info {
        background-color: #e8f4fd;
        border: 1px solid #bee5eb;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .periode-info .periode-label {
        font-weight: 600;
        color: #0c5460;
        margin-bottom: 5px;
    }

    .periode-info .periode-value {
        color: #2c3e50;
        font-size: 1.1rem;
    }

    .tujuan-highlight {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white !important;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: bold;
        display: inline-block;
        margin-left: 10px;
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }

        50% {
            box-shadow: 0 4px 16px rgba(231, 76, 60, 0.5);
        }

        100% {
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }
    }

    .tujuan-selected-input {
        border: 2px solid #e74c3c !important;
        background-color: #fdf2f2 !important;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25) !important;
    }

    .tujuan-badge {
        background: #e74c3c;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        margin-left: 8px;
        display: inline-block;
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1><i class="mdi mdi-calendar-range"></i> Laporan Perjalanan Berdasarkan Periode
        <?php if ($tujuanTerpilih): ?>
            <span class="tujuan-highlight"><?= $tujuanTerpilih ?></span>
        <?php endif; ?>
    </h1>
    <p>Kelola dan pantau perjalanan bus berdasarkan rentang tanggal keberangkatan
        <?php if ($tujuanTerpilih): ?>
            <br><strong style="color: #f39c12; font-size: 1.1rem;">🎯 Menampilkan data khusus untuk tujuan: <?= $tujuanTerpilih ?></strong>
        <?php endif; ?>
    </p>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <form method="GET" action="<?= base_url('laporan/periode') ?>" class="row g-3">
        <div class="col-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                value="<?= $tanggalMulai ?>">
        </div>

        <div class="col-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                value="<?= $tanggalSelesai ?>">
        </div>

        <div class="col-3">
            <label for="tujuan" class="form-label">
                Tujuan (Opsional)
                <?php if ($tujuanTerpilih): ?>
                    <span class="tujuan-badge">Dipilih: <?= $tujuanTerpilih ?></span>
                <?php endif; ?>
            </label>
            <select class="form-select <?= $tujuanTerpilih ? 'tujuan-selected-input' : '' ?>" id="tujuan" name="tujuan">
                <option value="">-- Semua Tujuan --</option>
                <?php foreach ($daftarTujuan as $item): ?>
                    <option value="<?= $item['tujuan'] ?>" <?= ($tujuanTerpilih === $item['tujuan']) ? 'selected' : '' ?>>
                        <?= $item['tujuan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-3">
            <label class="form-label">&nbsp;</label>
            <div class="button-group">
                <button type="submit" class="btn btn-filter">
                    <i class="mdi mdi-filter"></i> Filter
                </button>
                <a href="<?= base_url('laporan/periode') ?>" class="btn btn-reset">
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

<!-- Periode Info -->
<?php if ($tanggalMulai || $tanggalSelesai || $tujuanTerpilih): ?>
    <div class="periode-info" style="<?= $tujuanTerpilih ? 'border-left: 4px solid #e74c3c;' : '' ?>">
        <div class="periode-label">
            <?php if ($tujuanTerpilih): ?>
                🎯 Filter Aktif:
            <?php else: ?>
                Periode Laporan:
            <?php endif; ?>
        </div>
        <div class="periode-value">
            <?php if ($tanggalMulai && $tanggalSelesai): ?>
                📅 <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
            <?php elseif ($tanggalMulai): ?>
                📅 Mulai dari <?= date('d/m/Y', strtotime($tanggalMulai)) ?>
            <?php elseif ($tanggalSelesai): ?>
                📅 Sampai dengan <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
            <?php endif; ?>
            <?php if ($tujuanTerpilih): ?>
                <?php if ($tanggalMulai || $tanggalSelesai): ?><br><?php endif; ?>
                <strong style="color: #e74c3c; font-size: 1.2rem;">🎯 Tujuan: <?= $tujuanTerpilih ?></strong>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Statistics -->
<?php if ($totalData > 0): ?>
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-bus"></i> Total Perjalanan</div>
            <div class="stat-value"><?= $totalData ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-account-group"></i> Total Peserta</div>
            <div class="stat-value"><?= array_sum(array_column($laporan, 'jumlah_peserta')) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="mdi mdi-cash"></i> Total Pendapatan</div>
            <div class="stat-value">Rp <?= number_format(array_sum(array_column($laporan, 'total_bayar')), 0, ',', '.') ?></div>
        </div>
        <?php if ($tujuanTerpilih): ?>
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <div class="stat-label" style="color: #e74c3c;"><i class="mdi mdi-map-marker"></i> Tujuan Dipilih</div>
                <div class="stat-value" style="color: #e74c3c; font-size: 1.2rem;"><?= $tujuanTerpilih ?></div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Report Section -->
<div class="report-section">
    <h2 class="section-title">
        <i class="mdi mdi-table"></i>
        Laporan Perjalanan
        <?php if ($tujuanTerpilih): ?>
            <span style="color: #e74c3c; background: #fdf2f2; padding: 4px 12px; border-radius: 20px; font-size: 0.9rem;">
                Tujuan: <?= $tujuanTerpilih ?>
            </span>
        <?php endif; ?>
        <?php if ($tanggalMulai || $tanggalSelesai): ?>
            <br><small style="color: #7f8c8d; font-weight: normal;">
                Periode
                <?php if ($tanggalMulai && $tanggalSelesai): ?>
                    <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
                <?php elseif ($tanggalMulai): ?>
                    dari <?= date('d/m/Y', strtotime($tanggalMulai)) ?>
                <?php elseif ($tanggalSelesai): ?>
                    sampai <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
                <?php endif; ?>
            </small>
        <?php else: ?>
            <br><small style="color: #7f8c8d; font-weight: normal;">Semua Periode</small>
        <?php endif; ?>
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
                            <i class="mdi mdi-calendar-remove" style="font-size: 2rem; margin-bottom: 15px; opacity: 0.5; display: block;"></i>
                            <strong style="font-size: 1.1rem; color: #2c3e50;">
                                <?php if ($tanggalMulai || $tanggalSelesai): ?>
                                    <?php if ($tanggalMulai && $tanggalSelesai): ?>
                                        Belum ada data perjalanan pada periode <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
                                    <?php elseif ($tanggalMulai): ?>
                                        Belum ada data perjalanan mulai dari <?= date('d/m/Y', strtotime($tanggalMulai)) ?>
                                    <?php elseif ($tanggalSelesai): ?>
                                        Belum ada data perjalanan sampai dengan <?= date('d/m/Y', strtotime($tanggalSelesai)) ?>
                                    <?php endif; ?>
                                    <?php if ($tujuanTerpilih): ?>
                                        ke tujuan "<?= $tujuanTerpilih ?>"
                                    <?php endif; ?>
                                <?php else: ?>
                                    Belum ada data perjalanan yang tercatat
                                <?php endif; ?>
                            </strong>
                            <br>
                            <small style="margin-top: 5px; display: block;">
                                <?php if ($tanggalMulai || $tanggalSelesai || $tujuanTerpilih): ?>
                                    Coba ubah periode atau filter tujuan, atau reset semua filter
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
                <div class="col-4">
                    <p><strong>Total Perjalanan:</strong> <?= count($laporan) ?> perjalanan</p>
                </div>
                <div class="col-4">
                    <p><strong>Total Peserta:</strong> <?= array_sum(array_column($laporan, 'jumlah_peserta')) ?> orang</p>
                </div>
                <div class="col-4 text-end">
                    <p><strong>Total Pendapatan:</strong> Rp <?= number_format(array_sum(array_column($laporan, 'total_bayar')), 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>