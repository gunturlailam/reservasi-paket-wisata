<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Karyawan</h3>
            <p class="text-muted mb-0">Ngatur karyawan biar makin rapi.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('/laporankaryawan/cetak') ?>" class="btn btn-info" target="_blank">
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
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
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
                            <th style="width: 80px;">Foto</th>
                            <th>Nama Karyawan</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Jabatan</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($karyawan as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="<?= base_url('uploads/' . esc($row['foto'])) ?>"
                                            alt="Foto" class="rounded"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-secondary text-white d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; font-size: 20px;">
                                            <?= strtoupper(substr($row['nama_karyawan'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['nama_karyawan']) ?></td>
                                <td><?= esc($row['email'] ?? '-') ?></td>
                                <td><?= esc($row['nohp']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
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
                                <td colspan="8" class="text-center text-muted">Belum ada data karyawan, yuk tambah dulu.</td>
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
    <div class="modal-dialog modal-lg">
        <form action="<?= site_url('/karyawan/save') ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan *</label>
                        <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nohp" class="form-label">No HP *</label>
                        <input type="text" name="nohp" id="nohp" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_jabatan" class="form-label">Jabatan *</label>
                        <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan as $j) : ?>
                                <option value="<?= esc($j['id']) ?>"><?= esc($j['nama_jabatan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat *</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-muted">(Kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                    <div id="preview-foto" class="mt-2"></div>
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
        document.getElementById('email').value = '';
        document.getElementById('nohp').value = '';
        document.getElementById('alamat').value = '';
        document.getElementById('id_jabatan').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password').required = true;
        document.getElementById('foto').value = '';
        document.getElementById('preview-foto').innerHTML = '';
    }

    function edit(id) {
        fetch('<?= site_url('/karyawan/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Karyawan';
                document.getElementById('id').value = data.id;
                document.getElementById('nama_karyawan').value = data.nama_karyawan;
                document.getElementById('email').value = data.email || '';
                document.getElementById('nohp').value = data.nohp;
                document.getElementById('alamat').value = data.alamat;
                document.getElementById('id_jabatan').value = data.id_jabatan;
                document.getElementById('password').value = '';
                document.getElementById('password').required = false;

                // Preview foto jika ada
                if (data.foto) {
                    document.getElementById('preview-foto').innerHTML =
                        '<img src="<?= base_url('uploads/') ?>' + data.foto + '" class="rounded" style="max-width: 150px;">';
                } else {
                    document.getElementById('preview-foto').innerHTML = '';
                }

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }

    // Preview foto saat dipilih
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-foto').innerHTML =
                    '<img src="' + e.target.result + '" class="rounded" style="max-width: 150px;">';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?= $this->endSection(); ?>