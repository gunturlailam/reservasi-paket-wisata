<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Detail Pemesanan</h3>
            <p class="text-muted mb-0">Lengkapi info perjalanan dari setiap pemesanan.</p>
        </div>

        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm" onclick="tambah()">
            <i class="mdi mdi-plus"></i> Tambah Data
        </button>
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
                            <th>Pemesanan</th>
                            <th>Tgl Berangkat</th>
                            <th>Tgl Kembali</th>
                            <th>Penumpang</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemesanan_detail as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td>
                                    #<?= esc($row['id_pemesanan']) ?>
                                    <div class="text-muted small"><?= esc($row['nama_penyewa'] ?? '-') ?></div>
                                </td>
                                <td><?= esc($row['tanggal_berangkat']) ?></td>
                                <td><?= esc($row['tanggal_kembali']) ?></td>
                                <td><?= esc($row['jumlah_penumpang']) ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/pemesanan-detail/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
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
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_penumpang" class="form-label">Jumlah Penumpang</label>
                    <input type="number" min="1" name="jumlah_penumpang" id="jumlah_penumpang" class="form-control"
                        required>
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

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>