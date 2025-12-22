<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Pembayaran</h3>
            <p class="text-muted mb-0">Catat setiap pembayaran pemesanan.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('/laporanpembayaran/cetak') ?>" class="btn btn-info" target="_blank">
                <i class="mdi mdi-printer"></i> Cetak Laporan
            </a>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm" onclick="tambah()">
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Pemesanan</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah Bayar</th>
                            <th>Metode</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaran as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td>
                                    #<?= esc($row['id_pemesanan']) ?>
                                    <div class="text-muted small"><?= esc($row['nama_penyewa'] ?? '-') ?></div>
                                </td>
                                <td><?= esc($row['tanggal_bayar']) ?></td>
                                <td><?= number_format((float) $row['jumlah_bayar'], 0, ',', '.') ?></td>
                                <td><?= esc($row['metode_bayar']) ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/pembayaran/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($pembayaran)) : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pembayaran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= site_url('/pembayaran/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="id_pemesanan" class="form-label">Pemesanan</label>
                    <select name="id_pemesanan" id="id_pemesanan" class="form-control" required>
                        <option value="">Pilih Pemesanan</option>
                        <?php foreach ($pemesanan as $pesan) : ?>
                            <option value="<?= esc($pesan['id']) ?>">
                                #<?= esc($pesan['id']) ?> - <?= esc($pesan['nama_penyewa'] ?? 'Pelanggan') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                    <input type="number" min="0" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="metode_bayar" class="form-label">Metode Bayar</label>
                    <select name="metode_bayar" id="metode_bayar" class="form-control" required>
                        <option value="">Pilih Metode</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
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
        document.getElementById('modalTitle').innerText = 'Tambah Pembayaran';
        document.getElementById('id').value = '';
        document.getElementById('id_pemesanan').value = '';
        document.getElementById('tanggal_bayar').value = '';
        document.getElementById('jumlah_bayar').value = '';
        document.getElementById('metode_bayar').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/pembayaran/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Pembayaran';
                document.getElementById('id').value = data.id;
                document.getElementById('id_pemesanan').value = data.id_pemesanan;
                document.getElementById('tanggal_bayar').value = data.tanggal_bayar;
                document.getElementById('jumlah_bayar').value = data.jumlah_bayar;
                document.getElementById('metode_bayar').value = data.metode_bayar;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>