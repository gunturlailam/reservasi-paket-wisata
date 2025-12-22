<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Pemberangkatan</h3>
            <p class="text-muted mb-0">Atur jadwal berangkat lengkap dengan bus & kru.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('/laporanpemberangkatan/cetak') ?>" class="btn btn-info" target="_blank">
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
                            <th>Tanggal Berangkat</th>
                            <th>Pemesanan</th>
                            <th>Bus</th>
                            <th>Sopir</th>
                            <th>Kernet</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemberangkatan as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['tanggal_berangkat']) ?></td>
                                <td>
                                    #<?= esc($row['id_pemesanan']) ?>
                                    <div class="text-muted small"><?= esc($row['nama_penyewa'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <?php if (! empty($row['nomor_polisi'])) : ?>
                                        <?= esc($row['nomor_polisi']) ?> - <?= esc($row['merek']) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['nama_sopir'] ?? '-') ?></td>
                                <td><?= esc($row['nama_kernet'] ?? '-') ?></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= site_url('/pemberangkatan/delete/' . $row['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($pemberangkatan)) : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data pemberangkatan.</td>
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
        <form action="<?= site_url('/pemberangkatan/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Pemberangkatan</h5>
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
                        <?php foreach ($pemesanan as $p) : ?>
                            <option value="<?= esc($p['id']) ?>">
                                #<?= esc($p['id']) ?> - <?= esc($p['nama_penyewa'] ?? 'Pelanggan') ?>
                            </option>
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

                <div class="mb-3">
                    <label for="id_sopir" class="form-label">Sopir</label>
                    <select name="id_sopir" id="id_sopir" class="form-control" required>
                        <option value="">Pilih Sopir</option>
                        <?php foreach ($karyawan as $kr) : ?>
                            <option value="<?= esc($kr['id']) ?>"><?= esc($kr['nama_karyawan']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_kernet" class="form-label">Kernet</label>
                    <select name="id_kernet" id="id_kernet" class="form-control" required>
                        <option value="">Pilih Kernet</option>
                        <?php foreach ($karyawan as $kr) : ?>
                            <option value="<?= esc($kr['id']) ?>"><?= esc($kr['nama_karyawan']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required>
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
        document.getElementById('modalTitle').innerText = 'Tambah Pemberangkatan';
        document.getElementById('id').value = '';
        document.getElementById('id_pemesanan').value = '';
        document.getElementById('id_bus').value = '';
        document.getElementById('id_sopir').value = '';
        document.getElementById('id_kernet').value = '';
        document.getElementById('tanggal_berangkat').value = '';
    }

    function edit(id) {
        fetch('<?= site_url('/pemberangkatan/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Pemberangkatan';
                document.getElementById('id').value = data.id;
                document.getElementById('id_pemesanan').value = data.id_pemesanan;
                document.getElementById('id_bus').value = data.id_bus;
                document.getElementById('id_sopir').value = data.id_sopir;
                document.getElementById('id_kernet').value = data.id_kernet;
                document.getElementById('tanggal_berangkat').value = data.tanggal_berangkat;

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }
</script>

<?= $this->endSection(); ?>