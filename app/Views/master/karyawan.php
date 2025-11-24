<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Karyawan</h3>
            <p class="text-muted mb-0">Ngatur karyawan biar makin rapi.</p>
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
                            <th style="width: 120px;">ID Karyawan</th>
                            <th>Nama Karyawan</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Nama Jabatan</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($karyawan as $row) : ?>
                        <tr>
                            <td><?= esc($row['id']) ?></td>
                            <td><?= esc($row['nama_karyawan']) ?></td>
                            <td><?= esc($row['alamat']) ?></td>
                            <td><?= esc($row['nohp']) ?></td>
                            <td><?= esc($row['nama_jabatan']) ?></td>
                            <td class="text-nowrap">
                                <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                    <i class="mdi mdi-pencil"></i> Edit
                                </button>
                                <a href="<?= site_url('/karyawan/delete/' . $row['id']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="mdi mdi-delete"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($karyawan)) : ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data karyawan, yuk tambah dulu.
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
        <form action="<?= site_url('/karyawan/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nohp" class="form-label">No HP</label>
                    <input type="text" name="nohp" id="nohp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_jabatan" class="form-label">Nama Jabatan</label>
                    <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        <?php foreach ($jabatan as $j) : ?>
                        <option value="<?= esc($j['id']) ?>"><?= esc($j['nama_jabatan']) ?></option>
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
    document.getElementById('modalTitle').innerText = 'Tambah Karyawan';
    document.getElementById('id').value = '';
    document.getElementById('nama_karyawan').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('nohp').value = '';
    document.getElementById('id_jabatan').value = '';
}

function edit(id) {
    fetch('<?= site_url('/karyawan/get/') ?>' + id)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('modalTitle').innerText = 'Edit Karyawan';
            document.getElementById('id').value = data.id;
            document.getElementById('nama_karyawan').value = data.nama_karyawan;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('nohp').value = data.nohp;
            document.getElementById('id_jabatan').value = data.id_jabatan;

            const modal = new bootstrap.Modal(document.getElementById('modalForm'));
            modal.show();
        });
}
</script>

<?= $this->endSection(); ?>