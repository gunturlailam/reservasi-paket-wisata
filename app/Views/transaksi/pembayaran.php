<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
        <div>
            <h3 class="mb-0">Daftar Pembayaran</h3>
        </div>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalTambahPembayaran">
            <i class="mdi mdi-plus"></i> Tambah Pembayaran
        </button>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tgl Pesan</th>
                            <th>Paket Wisata</th>
                            <th>Jadwal</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pembayaran)) : ?>
                            <?php foreach ($pembayaran as $row) : ?>
                                <tr>
                                    <td>#<?= esc($row['id']) ?></td>
                                    <td><?= !empty($row['tanggal_pesan']) ? date('d/m/Y', strtotime($row['tanggal_pesan'])) : '-' ?></td>
                                    <td>
                                        <div class="fw-bold"><?= esc($row['nama_paket'] ?? '-') ?></div>
                                        <small class="text-muted"><?= esc($row['tujuan'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <?= !empty($row['tanggal_berangkat']) ? date('Y-m-d', strtotime($row['tanggal_berangkat'])) : '-' ?> s/d <?= !empty($row['tanggal_kembali']) ? date('Y-m-d', strtotime($row['tanggal_kembali'])) : '-' ?>
                                    </td>
                                    <td class="fw-bold text-primary">Rp <?= number_format((float)($row['jumlah_bayar'] ?? 0), 0, ',', '.') ?></td>
                                    <td>
                                        <?php if (!empty($row['tanggal_bayar'])) : ?>
                                            <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 4px;">Sudah Dibayar</span>
                                        <?php else : ?>
                                            <span class="badge" style="background-color: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px;">Menunggu Pembayaran</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (empty($row['tanggal_bayar'])) : ?>
                                            <button type="button" class="btn btn-success btn-sm btn-bayar"
                                                data-id="<?= $row['id'] ?>"
                                                data-metode="<?= esc($row['metode_bayar'] ?? 'Tunai') ?>"
                                                style="margin-right: 5px;">Bayar</button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?= $row['id'] ?>)">Batal</button>
                                        <?php else : ?>
                                            <span class="badge" style="background-color: #6c757d; color: white; padding: 5px 15px; border-radius: 4px;">Lunas</span>
                                            <?php if (!empty($row['bukti_bayar'])) : ?>
                                                <button type="button" class="btn btn-info btn-sm ml-1" onclick="lihatBukti('<?= esc($row['bukti_bayar']) ?>')"><i class="mdi mdi-eye"></i></button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">Belum ada data pembayaran</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formTambahPembayaran" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembayaran Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pemesanan</label>
                        <select name="id_pemesanan" id="id_pemesanan" class="form-control" required>
                            <option value="">Pilih Pemesanan</option>
                            <?php if (!empty($pemesanan)) : ?>
                                <?php foreach ($pemesanan as $p) : ?>
                                    <option value="<?= $p['id'] ?>">#<?= $p['id'] ?> - <?= $p['nama_penyewa'] ?? '' ?> (<?= $p['nama_paket'] ?? '' ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_bayar" id="metode_bayar" class="form-control" required>
                            <option value="">Pilih Metode</option>
                            <option value="Transfer">Transfer Bank</option>
                            <option value="Tunai">Tunai</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Penyewa</label>
                        <div class="form-control bg-light" id="detailPenyewa">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Paket Wisata</label>
                        <div class="form-control bg-light" id="detailPaket">-</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tujuan</label>
                        <div class="form-control bg-light" id="detailTujuan">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pesan</label>
                        <div class="form-control bg-light" id="detailTanggalPesan">-</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Berangkat</label>
                        <div class="form-control bg-light" id="detailTanggalBerangkat">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <div class="form-control bg-light" id="detailTanggalKembali">-</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Total Harus Dibayar</label>
                        <div class="form-control bg-light fw-bold text-primary" id="detailTotalHarus">Rp 0</div>
                        <input type="hidden" name="jumlah_bayar" id="jumlah_bayar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload Bukti Pembayaran -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog">
        <form id="formKonfirmasi" method="post" enctype="multipart/form-data" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="konfirmasi_id">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Metode: <strong id="konfirmasi_metode">-</strong>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                </div>
                <div id="previewBukti" class="text-center" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Lihat Bukti -->
<div class="modal fade" id="modalLihatBukti" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img id="imgBukti" src="" alt="Bukti Pembayaran" style="max-width: 100%; border-radius: 8px;">
            </div>
        </div>
    </div>
</div>

<!-- Data Pemesanan dalam JSON -->
<script>
    var pemesananData = <?= json_encode($pemesanan ?? []) ?>;
    console.log('Data Pemesanan Loaded:', pemesananData);

    // Event listener untuk dropdown pemesanan
    document.getElementById('id_pemesanan').addEventListener('change', function() {
        var selectedId = this.value;
        console.log('Selected ID:', selectedId);

        if (!selectedId) {
            resetForm();
            return;
        }

        // Cari data berdasarkan ID
        var data = null;
        for (var i = 0; i < pemesananData.length; i++) {
            if (pemesananData[i].id == selectedId) {
                data = pemesananData[i];
                break;
            }
        }

        console.log('Found Data:', data);

        if (!data) {
            resetForm();
            return;
        }

        // Isi form dengan data
        document.getElementById('detailPenyewa').innerText = data.nama_penyewa || '-';
        document.getElementById('detailPaket').innerText = data.nama_paket || '-';
        document.getElementById('detailTujuan').innerText = data.tujuan || '-';
        document.getElementById('detailTanggalPesan').innerText = formatTanggal(data.tanggal_pesan);
        document.getElementById('detailTanggalBerangkat').innerText = formatTanggal(data.tanggal_berangkat);
        document.getElementById('detailTanggalKembali').innerText = formatTanggal(data.tanggal_kembali);

        var total = parseInt(data.total_bayar) || 0;
        document.getElementById('detailTotalHarus').innerText = 'Rp ' + formatRupiah(total);
        document.getElementById('jumlah_bayar').value = total;
    });

    function resetForm() {
        document.getElementById('detailPenyewa').innerText = '-';
        document.getElementById('detailPaket').innerText = '-';
        document.getElementById('detailTujuan').innerText = '-';
        document.getElementById('detailTanggalPesan').innerText = '-';
        document.getElementById('detailTanggalBerangkat').innerText = '-';
        document.getElementById('detailTanggalKembali').innerText = '-';
        document.getElementById('detailTotalHarus').innerText = 'Rp 0';
        document.getElementById('jumlah_bayar').value = '';
    }

    function formatRupiah(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function formatTanggal(dateStr) {
        if (!dateStr) return '-';
        var d = new Date(dateStr);
        var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Submit form
    document.getElementById('formTambahPembayaran').addEventListener('submit', function(e) {
        e.preventDefault();

        var idPemesanan = document.getElementById('id_pemesanan').value;
        var metodeBayar = document.getElementById('metode_bayar').value;
        var jumlahBayar = document.getElementById('jumlah_bayar').value;

        if (!idPemesanan) {
            alert('Pilih pemesanan!');
            return;
        }
        if (!metodeBayar) {
            alert('Pilih metode pembayaran!');
            return;
        }
        if (!jumlahBayar) {
            alert('Data total bayar tidak valid!');
            return;
        }

        var formData = new FormData(this);

        fetch('<?= site_url('/pembayaran/tambah') ?>', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    alert('Pembayaran berhasil disimpan!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(function(error) {
                alert('Error: ' + error);
            });
    });

    // Event delegation untuk tombol Bayar
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-bayar')) {
            e.preventDefault();
            var id = e.target.getAttribute('data-id');
            var metode = e.target.getAttribute('data-metode');

            if (metode === 'Tunai') {
                // Tunai langsung proses
                if (confirm('Konfirmasi pembayaran tunai?')) {
                    window.location.href = '<?= site_url('/pembayaran/proses/') ?>' + id;
                }
            } else {
                // Non-tunai buka modal upload bukti
                document.getElementById('konfirmasi_id').value = id;
                document.getElementById('konfirmasi_metode').innerText = metode;
                document.getElementById('bukti_bayar').value = '';
                document.getElementById('previewBukti').style.display = 'none';
                $('#modalKonfirmasi').modal('show');
            }
        }
    });

    function hapus(id) {
        if (confirm('Batalkan pembayaran #' + id + '?')) {
            window.location.href = '<?= site_url('/pembayaran/delete/') ?>' + id;
        }
    }

    function lihatBukti(filename) {
        document.getElementById('imgBukti').src = '<?= base_url('uploads/bukti_bayar/') ?>' + filename;
        $('#modalLihatBukti').modal('show');
    }

    // Preview bukti bayar
    document.getElementById('bukti_bayar').addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('previewBukti').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit konfirmasi
    document.getElementById('formKonfirmasi').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('<?= site_url('/pembayaran/konfirmasi') ?>', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    alert('Pembayaran berhasil dikonfirmasi!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(function(error) {
                alert('Error: ' + error);
            });
    });
</script>

<?= $this->endSection(); ?>