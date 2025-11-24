<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Paket Bus</h3>
            <p class="text-muted mb-0">Hubungkan paket wisata dengan armada bus.</p>
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
                            <th style="width: 120px;">ID</th>
                            <th>Paket Wisata</th>
                            <th>Bus</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paketbus as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                <td>
                                    <?php if (! empty($row['nomor_polisi'])) : ?>
                                        <?= esc($row['nomor_polisi']) ?> - <?= esc($row['merek']) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/paketbus/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($paketbus)) : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada paket bus, yuk buat dulu.</td>
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
        <form action="<?= site_url('/paketbus/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Paket Bus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="id_paketwisata" class="form-label">Paket Wisata</label>
                    <select name="id_paketwisata" id="id_paketwisata" class="form-control" required>
                        <option value="">Pilih Paket</option>
                        <?php foreach ($paketwisata as $paket) : ?>
                            <option value="<?= esc($paket['id']) ?>"><?= esc($paket['nama_paket']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_bus" class="form-label">Bus</label>
                    <select name="id_bus" id="id_bus" class="form-control" required>
                        <option value="">Pilih Bus</option>
                        <?php foreach ($bus as $item) : ?>
                            <option value="<?= esc($item['id']) ?>">
                                <?= esc($item['nomor_polisi']) ?> - <?= esc($item['merek']) ?>
                            </option>
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
        document.getElementById('modalTitle').innerText = 'Tambah Paket Bus';
        document.getElementById('id').value = '';
        document.getElementById('id_paketwisata').value = '';
        document.getElementById('id_bus').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/paketbus/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Paket Bus';
                document.getElementById('id').value = data.id;
                document.getElementById('id_paketwisata').value = data.id_paketwisata;
                document.getElementById('id_bus').value = data.id_bus;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>