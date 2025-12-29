<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Detail Pemesanan</h3>
            <p class="text-muted mb-0">Lengkapi info perjalanan dari setiap pemesanan.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('/laporanpemesanandetail/cetak') ?>" class="btn btn-info" target="_blank">
                <i class="mdi mdi-printer"></i> Cetak Laporan
            </a>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm"
                onclick="tambah()">
                <i class="mdi mdi-plus"></i> Tambah Data
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Pemesanan</th>
                            <th>Jadwal</th>
                            <th>Penumpang</th>
                            <th>Status Pembayaran</th>
                            <th>Estimasi Total</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemesanan_detail as $row) : ?>
                            <?php
                            $start = strtotime($row['tanggal_berangkat']);
                            $end = strtotime($row['tanggal_kembali']);
                            $durasi = ($start && $end && $end > $start) ? max(1, ceil(($end - $start) / 86400)) : 0;
                            $harga = (int) ($row['harga'] ?? 0);
                            $penumpang = (int) ($row['jumlah_penumpang'] ?? 0);
                            $estimasi = $durasi > 0 ? $harga * $penumpang * $durasi : 0;
                            ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td>
                                    #<?= esc($row['id_pemesanan']) ?>
                                    <div class="text-muted small"><?= esc($row['nama_penyewa'] ?? '-') ?></div>
                                    <div class="text-muted small"><?= esc($row['nama_paket'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <div><?= esc($row['tanggal_berangkat']) ?> s/d</div>
                                    <div><?= esc($row['tanggal_kembali']) ?></div>
                                    <div class="text-muted small">Durasi: <?= $durasi ?> hari</div>
                                </td>
                                <td><?= esc($row['jumlah_penumpang']) ?></td>
                                <td>
                                    <?php if (!empty($row['pembayaran_id'])) : ?>
                                        <span class="badge badge-success">Sudah Bayar</span>
                                        <div class="text-muted small">Rp
                                            <?= number_format((float) ($row['jumlah_bayar'] ?? 0), 0, ',', '.') ?></div>
                                    <?php else : ?>
                                        <span class="badge badge-warning text-dark">Menunggu Pembayaran</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-primary"><?= 'Rp ' . number_format($estimasi, 0, ',', '.') ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/pemesanan-detail/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan detail ini?')">
                                        <i class="mdi mdi-close"></i> Batal
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($pemesanan_detail)) : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada detail pemesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (isset($pager)) : ?>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">Navigasi data</div>
                        <div><?= $pager->links() ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= site_url('/pemesanan-detail/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Detail Pemesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="id_pemesanan" class="form-label">Pemesanan</label>
                    <select name="id_pemesanan" id="id_pemesanan" class="form-control" required onchange="syncHarga()">
                        <option value="">Pilih Pemesanan</option>
                        <?php foreach ($pemesanan as $pesan) : ?>
                            <option value="<?= esc($pesan['id']) ?>" data-harga="<?= esc($pesan['harga'] ?? 0) ?>">
                                #<?= esc($pesan['id']) ?> - <?= esc($pesan['nama_penyewa'] ?? 'Pelanggan') ?> (Rp
                                <?= number_format((float) ($pesan['harga'] ?? 0), 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required
                        onchange="validateDates()">
                </div>

                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required
                        onchange="validateDates()">
                    <small class="text-danger" id="dateError" style="display:none;">Tanggal kembali harus setelah
                        tanggal berangkat</small>
                </div>

                <div class="mb-3">
                    <label for="jumlah_penumpang" class="form-label">Jumlah Penumpang</label>
                    <input type="number" min="1" name="jumlah_penumpang" id="jumlah_penumpang" class="form-control"
                        required oninput="updateEstimasi()">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small">Durasi Sewa</div>
                            <div class="h5 mb-0"><span id="durasiHari">0</span> Hari</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small">Estimasi Total Bayar</div>
                            <div class="h5 mb-0" id="estimasiBayar">Rp 0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Detail Pemesanan';
        document.getElementById('id').value = '';
        document.getElementById('id_pemesanan').value = '';
        document.getElementById('tanggal_berangkat').value = '';
        document.getElementById('tanggal_kembali').value = '';
        document.getElementById('jumlah_penumpang').value = '';
        document.getElementById('dateError').style.display = 'none';
        document.getElementById('durasiHari').innerText = '0';
        document.getElementById('estimasiBayar').innerText = 'Rp 0';
        setSubmitEnabled(true);
    }

    function edit(id) {
        fetch('<?= site_url('/pemesanan-detail/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Detail Pemesanan';
                document.getElementById('id').value = data.id;
                document.getElementById('id_pemesanan').value = data.id_pemesanan;
                document.getElementById('tanggal_berangkat').value = data.tanggal_berangkat;
                document.getElementById('tanggal_kembali').value = data.tanggal_kembali;
                document.getElementById('jumlah_penumpang').value = data.jumlah_penumpang;
                document.getElementById('dateError').style.display = 'none';
                syncHarga();
                updateEstimasi();
                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }

    function validateDates() {
        const tanggalBerangkat = new Date(document.getElementById('tanggal_berangkat').value);
        const tanggalKembali = new Date(document.getElementById('tanggal_kembali').value);
        const errorElement = document.getElementById('dateError');
        const invalid = !(tanggalKembali > tanggalBerangkat);
        if (invalid) {
            errorElement.style.display = 'block';
            setSubmitEnabled(false);
        } else {
            errorElement.style.display = 'none';
            setSubmitEnabled(true);
        }
        updateDurasi(tanggalBerangkat, tanggalKembali, invalid);
        updateEstimasi();
    }

    function setSubmitEnabled(enabled) {
        document.querySelector('.modal-footer .btn-success').disabled = !enabled;
    }

    function updateDurasi(tglBerangkat, tglKembali, invalid) {
        if (invalid || !tglBerangkat || !tglKembali || isNaN(tglBerangkat) || isNaN(tglKembali)) {
            document.getElementById('durasiHari').innerText = '0';
            return;
        }
        const diffMs = tglKembali - tglBerangkat;
        const days = Math.max(0, Math.round(diffMs / (1000 * 60 * 60 * 24)));
        document.getElementById('durasiHari').innerText = days.toString();
    }

    function syncHarga() {
        updateEstimasi();
    }

    function updateEstimasi() {
        const select = document.getElementById('id_pemesanan');
        const harga = Number(select.options[select.selectedIndex]?.dataset.harga || 0);
        const penumpang = Number(document.getElementById('jumlah_penumpang').value || 0);
        const tanggalBerangkat = new Date(document.getElementById('tanggal_berangkat').value);
        const tanggalKembali = new Date(document.getElementById('tanggal_kembali').value);
        const invalidDates = !(tanggalKembali > tanggalBerangkat);
        updateDurasi(tanggalBerangkat, tanggalKembali, invalidDates);
        const estimasi = invalidDates ? 0 : harga * penumpang;
        document.getElementById('estimasiBayar').innerText = formatRupiah(estimasi);
    }

    function formatRupiah(value) {
        return 'Rp ' + (value || 0).toLocaleString('id-ID');
    }
</script>

<?= $this->endSection(); ?>