<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Pemesanan</h3>
            <p class="text-muted mb-0">Catatan pesanan paket wisata + bus.</p>
        </div>

        <div class="d-flex gap-3">
            <a href="<?= site_url('/laporanpemesanan/cetak') ?>" class="btn btn-info" target="_blank">
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
                            <th style="width: 90px;">ID</th>
                            <th>Tanggal Pesan</th>
                            <th>Nama Penyewa</th>
                            <th>Paket Bus</th>
                            <th>Total Bayar</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemesanan as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['tanggal_pesan']) ?></td>
                                <td><?= esc($row['nama_penyewa'] ?? '-') ?></td>
                                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                <td><?= number_format((float) $row['total_bayar'], 0, ',', '.') ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/pemesanan/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($pemesanan)) : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data pemesanan.</td>
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
        <form action="<?= site_url('/pemesanan/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Pemesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                    <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="id_penyewa" class="form-label">Penyewa</label>
                    <select name="id_penyewa" id="id_penyewa" class="form-control" required>
                        <option value="">Pilih Penyewa</option>
                        <?php foreach ($penyewa as $item) : ?>
                            <option value="<?= esc($item['id']) ?>"><?= esc($item['nama_penyewa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_paketbus" class="form-label">Paket Bus</label>
                    <select name="id_paketbus" id="id_paketbus" class="form-control" required
                        onchange="syncTotalBayar()">
                        <option value="">Pilih Paket Bus</option>
                        <?php foreach ($paketbus as $paket) : ?>
                            <option value="<?= esc($paket['id']) ?>" data-harga="<?= esc($paket['harga'] ?? 0) ?>">
                                #<?= esc($paket['id']) ?> - <?= esc($paket['nama_paket'] ?? 'Paket') ?> (Rp
                                <?= number_format((float) ($paket['harga'] ?? 0), 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total_bayar" class="form-label">Total Bayar</label>
                    <input type="number" min="0" name="total_bayar" id="total_bayar" class="form-control" readonly>
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
        document.getElementById('modalTitle').innerText = 'Tambah Pemesanan';
        document.getElementById('id').value = '';
        document.getElementById('tanggal_pesan').value = '';
        document.getElementById('id_penyewa').value = '';
        document.getElementById('id_paketbus').value = '';
        document.getElementById('total_bayar').value = '';
        syncTotalBayar();
    }

    function edit(id) {
        fetch('<?= site_url('/pemesanan/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Pemesanan';
                document.getElementById('id').value = data.id;
                document.getElementById('tanggal_pesan').value = data.tanggal_pesan;
                document.getElementById('id_penyewa').value = data.id_penyewa;
                document.getElementById('id_paketbus').value = data.id_paketbus;
                document.getElementById('total_bayar').value = data.total_bayar;
                syncTotalBayar();

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }

    function syncTotalBayar() {
        const select = document.getElementById('id_paketbus');
        const harga = select.options[select.selectedIndex]?.dataset.harga || 0;
        document.getElementById('total_bayar').value = harga;
    }
</script>

<?= $this->endSection(); ?>