<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container p-4">
        <h3>Data Jabatan</h3>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="tambah()">Tambah Jabatan</button>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Jabatan</th>
                    <th>Nama Jabatan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($jabatan as $mhs) : ?>
                    <tr>
                        <td><?= $mhs['id'] ?></td>
                        <td><?= $mhs['nama_jabatan']  ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="edit(<?= $mhs['id'] ?>)">Edit</button>
                            <a href="<?= site_url('/jabatan/delete/' . $mhs['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/jabatan/save" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label>Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function tambah() {
            document.getElementById('modalTitle').innerText = 'Tambah Jabatan';
            document.getElementById('id').value = '';
            document.getElementById('nama_jabatan').value = '';
        }

        function edit(id) {
            fetch('/jabatan/get/' + id) // ✅
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = 'Edit jabatan';
                    document.getElementById('id').value = data.id;
                    document.getElementById('nama_jabatan').value = data.nama_jabatan;

                    new bootstrap.Modal(document.getElementById('modalForm')).show();
                });
        }
    </script>
</body>

</html>

<?= $this->endSection(); ?>