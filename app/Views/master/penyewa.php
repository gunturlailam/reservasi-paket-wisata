<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Penyewa</h3>
            <p class="text-muted mb-0">Catatan pelanggan yang pernah menyewa bus.</p>
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
                            <th style="width: 100px;">ID</th>
                            <th>Nama Penyewa</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penyewa as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['nama_penyewa']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
                                <td><?= esc($row['no_telp']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/penyewa/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($penyewa)) : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data penyewa, yuk tambah dulu.</td>
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
        <form action="<?= site_url('/penyewa/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Penyewa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="nama_penyewa" class="form-label">Nama Penyewa</label>
                    <input type="text" name="nama_penyewa" id="nama_penyewa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
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
        document.getElementById('modalTitle').innerText = 'Tambah Penyewa';
        document.getElementById('id').value = '';
        document.getElementById('nama_penyewa').value = '';
        document.getElementById('alamat').value = '';
        document.getElementById('no_telp').value = '';
        document.getElementById('email').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/penyewa/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Penyewa';
                document.getElementById('id').value = data.id;
                document.getElementById('nama_penyewa').value = data.nama_penyewa;
                document.getElementById('alamat').value = data.alamat;
                document.getElementById('no_telp').value = data.no_telp;
                document.getElementById('email').value = data.email;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>