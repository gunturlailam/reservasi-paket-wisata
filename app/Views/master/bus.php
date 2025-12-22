<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Bus</h3>
            <p class="text-muted mb-0">Kumpulan Daftar Bus.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('/laporanbus/cetak') ?>" class="btn btn-info" target="_blank">
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
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">ID Bus</th>
                            <th>Nomor Polisi</th>
                            <th>Merek</th>
                            <th>Kapasitas</th>
                            <th>Nama Jenis Bus</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bus as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['nomor_polisi']) ?></td>
                                <td><?= esc($row['merek']) ?></td>
                                <td><?= esc($row['kapasitas']) ?></td>
                                <td><?= esc($row['nama_jenisbus']) ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/bus/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($bus)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data bus, yuk tambah dulu.
                                </td>
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
        <form action="<?= site_url('/bus/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah bus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="merek" class="form-label">Merek</label>
                    <input type="text" name="merek" id="merek" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="text" name="kapasitas" id="kapasitas" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_jenisbus" class="form-label">Nama jenisbus</label>
                    <select name="id_jenisbus" id="id_jenisbus" class="form-control" required>
                        <option value="">Pilih jenisbus</option>
                        <?php foreach ($jenisbus as $j) : ?>
                            <option value="<?= esc($j['id']) ?>"><?= esc($j['nama_jenisbus']) ?></option>
                        <?php endforeach; ?>
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
        document.getElementById('modalTitle').innerText = 'Tambah bus';
        document.getElementById('id').value = '';
        document.getElementById('nomor_polisi').value = '';
        document.getElementById('merek').value = '';
        document.getElementById('kapasitas').value = '';
        document.getElementById('id_jenisbus').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/bus/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit bus';
                document.getElementById('id').value = data.id;
                document.getElementById('nomor_polisi').value = data.nomor_polisi;
                document.getElementById('merek').value = data.merek;
                document.getElementById('kapasitas').value = data.kapasitas;
                document.getElementById('id_jenisbus').value = data.id_jenisbus;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>