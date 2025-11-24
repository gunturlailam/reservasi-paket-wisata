<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Paket Wisata</h3>
            <p class="text-muted mb-0">Ngatur Paket Wisata biar kerjaan makin rapi.</p>
        </div>

        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm" onclick="tambah()">
            <i class="mdi mdi-plus"></i> Tambah Data
        </button>
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
                            <th style="width: 180px;">ID Paket Wisata</th>
                            <th>Nama Paket</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paketwisata as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['nama_paket']) ?></td>
                                <td><?= esc($row['tujuan']) ?></td>
                                <td><?= esc($row['harga']) ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/paketwisata/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($paketwisata)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data paket wisata, yuk tambah dulu.</td>
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
        <form action="<?= site_url('/paketwisata/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah paketwisata</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="nama_paket" class="form-label">Nama paket wisata</label>
                    <input type="text" name="nama_paket" id="nama_paket" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tujuan" class="form-label">Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" required>
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
        document.getElementById('modalTitle').innerText = 'Tambah paket wisata';
        document.getElementById('id').value = '';
        document.getElementById('nama_paket').value = '';
        document.getElementById('tujuan').value = '';
        document.getElementById('harga').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/paketwisata/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit paketwisata';
                document.getElementById('id').value = data.id;
                document.getElementById('nama_paket').value = data.nama_paket;
                document.getElementById('tujuan').value = data.tujuan;
                document.getElementById('harga').value = data.harga;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>