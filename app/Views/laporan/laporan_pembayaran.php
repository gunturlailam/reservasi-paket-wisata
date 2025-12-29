<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
        <div>
            <h3 class="mb-0">Laporan Pembayaran</h3>
            <p class="text-muted mb-0">Laporan data pembayaran berdasarkan periode</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">
                <i class="mdi mdi-filter"></i> Filter Laporan Periode
            </h5>
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal"
                        value="<?= esc($tanggal_awal) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                        value="<?= esc($tanggal_akhir) ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-magnify"></i> Tampilkan
                    </button>
                    <?php if (!empty($isFiltered) && !empty($pembayaran)) : ?>
                        <a href="<?= site_url('/laporanpembayaran/cetak?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir) ?>"
                            class="btn btn-success" target="_blank">
                            <i class="mdi mdi-printer"></i> Cetak
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($isFiltered)) : ?>
        <?php if (!empty($pembayaran)) : ?>
            <?php
            $jumlahTransaksi = count($pembayaran);
            $rataRata = $jumlahTransaksi > 0 ? $total / $jumlahTransaksi : 0;
            ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Total Transaksi</h6>
                                    <h3 class="mb-0 text-primary"><?= $jumlahTransaksi ?></h3>
                                </div>
                                <div class="text-primary" style="font-size: 2.5rem;">
                                    <i class="mdi mdi-cash-multiple"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Total Pendapatan</h6>
                                    <h3 class="mb-0 text-success">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                                </div>
                                <div class="text-success" style="font-size: 2.5rem;">
                                    <i class="mdi mdi-currency-usd"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Rata-rata Pembayaran</h6>
                                    <h3 class="mb-0 text-info">Rp <?= number_format($rataRata, 0, ',', '.') ?></h3>
                                </div>
                                <div class="text-info" style="font-size: 2.5rem;">
                                    <i class="mdi mdi-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="mdi mdi-table"></i> Data Pembayaran
                    <small class="text-muted">Periode: <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d
                        <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></small>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>ID Pembayaran</th>
                                <th>Tgl Bayar</th>
                                <th>Penyewa</th>
                                <th>Paket Wisata</th>
                                <th>Metode</th>
                                <th class="text-end">Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembayaran)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($pembayaran as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="badge badge-secondary">#<?= esc($row['id']) ?></span></td>
                                        <td><?= !empty($row['tanggal_bayar']) ? date('d/m/Y', strtotime($row['tanggal_bayar'])) : '-' ?></td>
                                        <td><?= esc($row['nama_penyewa'] ?? '-') ?></td>
                                        <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                        <td>
                                            <span class="badge badge-info"><?= esc($row['metode_bayar'] ?? '-') ?></span>
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            Rp <?= number_format((float) ($row['jumlah_bayar'] ?? 0), 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-success">
                                    <td colspan="6" class="text-end fw-bold">TOTAL PENDAPATAN</td>
                                    <td class="text-end fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="mdi mdi-information-outline" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada data pembayaran untuk periode ini</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="mdi mdi-filter-outline text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Pilih Periode Laporan</h5>
                <p class="text-muted">Silakan pilih tanggal awal dan tanggal akhir, lalu klik tombol <strong>Tampilkan</strong> untuk melihat data.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>