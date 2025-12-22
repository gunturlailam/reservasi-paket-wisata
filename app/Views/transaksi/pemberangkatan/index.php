<?= $this->extend('main') ?>

<?= $this->section('isi') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Pemberangkatan</h5>
                    <?php if ($userRole === 'admin' || $userRole === 'karyawan'): ?>
                        <a href="<?= site_url('/pemberangkatan/create') ?>" class="btn btn-primary btn-sm float-right">
                            <i class="mdi mdi-plus"></i> Tambah Pemberangkatan
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pemesanan</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nomor Polisi</th>
                                    <th>Nama Sopir</th>
                                    <th>Nama Kernet</th>
                                    <th>Tanggal Berangkat</th>
                                    <?php if ($userRole === 'admin' || $userRole === 'karyawan'): ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pemberangkatan)): ?>
                                    <?php $no = 1;
                                    foreach ($pemberangkatan as $item): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $item['kode_pemesanan'] ?></td>
                                            <td><?= $item['nama_penyewa'] ?></td>
                                            <td><?= $item['nomor_polisi'] ?></td>
                                            <td><?= $item['nama_sopir'] ?></td>
                                            <td><?= $item['nama_kernet'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($item['tanggal_berangkat'])) ?></td>
                                            <?php if ($userRole === 'admin' || $userRole === 'karyawan'): ?>
                                                <td>
                                                    <a href="<?= site_url('/pemberangkatan/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('/pemberangkatan/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= ($userRole === 'admin' || $userRole === 'karyawan') ? '8' : '7' ?>" class="text-center">Tidak ada data pemberangkatan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>