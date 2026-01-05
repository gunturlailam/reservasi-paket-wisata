<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <div>
            <h3 class="mb-0">Data Pemesanan</h3>
            <p class="text-muted mb-0">Catatan pesanan paket wisata + bus.</p>
        </div>

        <div class="d-flex gap-3">
            <a href="<?= site_url('/laporanpemesanan/cetak') ?>" class="btn btn-info" target="_blank">
                <i class="mdi mdi-printer"></i> Cetak Laporan
            </a>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm"
                onclick="tambah()">
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

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> <?= session()->getFlashdata('error') ?>
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
                            <th style="width: 80px;">ID</th>
                            <th>Tanggal Pesan</th>
                            <th>Nama Penyewa</th>
                            <th>Paket Bus</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemesanan as $row) : ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['tanggal_pesan']) ?></td>
                                <?php
                                $isMine = ($isPenyewa ?? false) && isset($row['id_penyewa']) && (int) $row['id_penyewa'] === (int) session()->get('user_id');
                                ?>
                                <td>
                                    <?= esc($row['nama_penyewa'] ?? '-') ?>
                                    <?php if ($isMine) : ?>
                                        <span class="badge badge-primary ms-1">Milik Anda</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                <td><?= number_format((float) $row['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if (!empty($row['pembayaran_id'])) : ?>
                                        <span class="badge badge-success">Sudah Bayar</span>
                                        <div class="text-muted small">Rp
                                            <?= number_format((float) ($row['jumlah_bayar'] ?? 0), 0, ',', '.') ?></div>
                                    <?php else : ?>
                                        <span class="badge badge-warning text-dark">Menunggu Pembayaran</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?php if (empty($row['pembayaran_id'])) : ?>
                                        <button class="btn btn-warning btn-sm me-1" onclick="edit(<?= $row['id'] ?>)">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <a href="<?= site_url('/pemesanan/delete/' . $row['id']) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                            <i class="mdi mdi-close"></i> Batal
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($pemesanan)) : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data pemesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (isset($pager)) : ?>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">Navigasi data</div>
                        <div><?= $pager->links() ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= site_url('/pemesanan/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Pemesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                    <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_penumpang" class="form-label">Jumlah Penumpang</label>
                    <input type="number" min="1" name="jumlah_penumpang" id="jumlah_penumpang" class="form-control"
                        required oninput="syncTotalBayar()">
                </div>

                <div class="mb-3">
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required
                        onchange="handleDateChange()">
                </div>

                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required
                        onchange="handleDateChange()">
                    <small class="text-danger" id="dateError" style="display:none;">Tanggal kembali harus setelah
                        tanggal berangkat</small>
                </div>

                <?php $isPenyewaView = $isPenyewa ?? false; ?>
                <?php if (!$isPenyewaView) : ?>
                    <div class="mb-3">
                        <label for="id_penyewa" class="form-label">Penyewa</label>
                        <select name="id_penyewa" id="id_penyewa" class="form-control" required>
                            <option value="">Pilih Penyewa</option>
                            <?php foreach ($penyewa as $item) : ?>
                                <option value="<?= esc($item['id']) ?>"><?= esc($item['nama_penyewa']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else : ?>
                    <input type="hidden" name="id_penyewa" id="id_penyewa" value="<?= session()->get('user_id') ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="id_paketbus" class="form-label">Paket Bus</label>
                    <select name="id_paketbus" id="id_paketbus" class="form-control" required
                        onchange="syncTotalBayar()">
                        <option value="">Pilih Paket Bus</option>
                        <?php foreach ($paketbus as $paket) : ?>
                            <option value="<?= esc($paket['id']) ?>" data-harga="<?= esc($paket['harga'] ?? 0) ?>">
                                #<?= esc($paket['id']) ?> - <?= esc($paket['nama_paket'] ?? 'Paket') ?> (Rp
                                <?= number_format((float) ($paket['harga'] ?? 0), 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total_bayar" class="form-label">Total Bayar</label>
                    <input type="number" min="0" name="total_bayar" id="total_bayar" class="form-control" readonly>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small">Durasi Sewa</div>
                            <div class="h5 mb-0"><span id="durasiHari">0</span> Hari</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small">Estimasi Total Bayar</div>
                            <div class="h5 mb-0" id="estimasiBayar">Rp 0</div>
                        </div>
                    </div>
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
    var currentEditId = null;

    function tambah() {
        currentEditId = null;
        document.getElementById('modalTitle').innerText = 'Tambah Pemesanan';
        document.getElementById('id').value = '';
        document.getElementById('tanggal_pesan').value = '';
        document.getElementById('tanggal_berangkat').value = '';
        document.getElementById('tanggal_kembali').value = '';
        document.getElementById('id_penyewa').value = '';
        document.getElementById('id_paketbus').value = '';
        document.getElementById('jumlah_penumpang').value = '';
        document.getElementById('total_bayar').value = '';
        document.getElementById('durasiHari').innerText = '0';
        document.getElementById('estimasiBayar').innerText = 'Rp 0';
        document.getElementById('dateError').style.display = 'none';
        hideTanggalError();
        setSubmitEnabled(true);
        syncTotalBayar();
    }

    function edit(id) {
        currentEditId = id;
        fetch('<?= site_url('/pemesanan/get/') ?>' + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('modalTitle').innerText = 'Edit Pemesanan';
                document.getElementById('id').value = data.id;
                document.getElementById('tanggal_pesan').value = data.tanggal_pesan;
                // tanggal berangkat/kembali & jumlah penumpang tidak tersimpan di DB
                document.getElementById('id_penyewa').value = data.id_penyewa;
                document.getElementById('id_paketbus').value = data.id_paketbus;
                document.getElementById('total_bayar').value = data.total_bayar;
                hideTanggalError();
                syncTotalBayar();

                const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                modal.show();
            });
    }

    function handleDateChange() {
        const tanggalBerangkat = document.getElementById('tanggal_berangkat').value;
        const tanggalKembali = document.getElementById('tanggal_kembali').value;
        const errorElement = document.getElementById('dateError');

        const tglBerangkatDate = new Date(tanggalBerangkat);
        const tglKembaliDate = new Date(tanggalKembali);
        const invalid = tanggalKembali && !(tglKembaliDate > tglBerangkatDate);

        if (invalid) {
            errorElement.style.display = 'block';
            setSubmitEnabled(false);
        } else {
            errorElement.style.display = 'none';
        }

        // Cek ketersediaan tanggal via AJAX
        if (tanggalBerangkat) {
            cekKetersediaanTanggal(tanggalBerangkat, tanggalKembali);
        }

        updateDurasi(tglBerangkatDate, tglKembaliDate, invalid);
        syncTotalBayar();
    }

    function cekKetersediaanTanggal(tanggalBerangkat, tanggalKembali) {
        var url = '<?= site_url('/pemesanan/cek-tanggal') ?>?tanggal_berangkat=' + tanggalBerangkat;
        if (tanggalKembali) {
            url += '&tanggal_kembali=' + tanggalKembali;
        }
        if (currentEditId) {
            url += '&exclude_id=' + currentEditId;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.tanggal_exists) {
                    showTanggalError('Tanggal berangkat sudah digunakan oleh pemesanan lain!');
                    setSubmitEnabled(false);
                } else if (data.range_conflict) {
                    showTanggalError('Jadwal perjalanan bentrok dengan pemesanan lain!');
                    setSubmitEnabled(false);
                } else {
                    hideTanggalError();
                    // Re-check date range validation
                    const tglBerangkatDate = new Date(tanggalBerangkat);
                    const tglKembaliDate = new Date(tanggalKembali);
                    if (!tanggalKembali || tglKembaliDate > tglBerangkatDate) {
                        setSubmitEnabled(true);
                    }
                }
            })
            .catch(err => {
                console.error('Error checking date:', err);
            });
    }

    function showTanggalError(message) {
        var errorDiv = document.getElementById('tanggalConflictError');
        if (!errorDiv) {
            errorDiv = document.createElement('small');
            errorDiv.id = 'tanggalConflictError';
            errorDiv.className = 'text-danger d-block mt-1';
            document.getElementById('tanggal_berangkat').parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }

    function hideTanggalError() {
        var errorDiv = document.getElementById('tanggalConflictError');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }

    function updateDurasi(tglBerangkat, tglKembali, invalid) {
        if (invalid || !tglBerangkat || !tglKembali || isNaN(tglBerangkat) || isNaN(tglKembali)) {
            document.getElementById('durasiHari').innerText = '0';
            return;
        }
        const diffMs = tglKembali - tglBerangkat;
        const days = Math.max(1, Math.ceil(diffMs / (1000 * 60 * 60 * 24)));
        document.getElementById('durasiHari').innerText = days.toString();
    }

    function syncTotalBayar() {
        const select = document.getElementById('id_paketbus');
        const harga = Number(select.options[select.selectedIndex]?.dataset.harga || 0);
        const penumpang = Number(document.getElementById('jumlah_penumpang').value || 0);
        const tanggalBerangkat = new Date(document.getElementById('tanggal_berangkat').value);
        const tanggalKembali = new Date(document.getElementById('tanggal_kembali').value);
        const invalidDates = !(tanggalKembali > tanggalBerangkat);

        const durasiText = document.getElementById('durasiHari').innerText;
        const durasi = Number(durasiText) || 0;

        const estimasi = invalidDates ? 0 : harga * penumpang * Math.max(1, durasi);
        document.getElementById('estimasiBayar').innerText = formatRupiah(estimasi);
        document.getElementById('total_bayar').value = estimasi;
    }

    function setSubmitEnabled(enabled) {
        document.querySelector('.modal-footer .btn-success').disabled = !enabled;
    }

    function formatRupiah(value) {
        return 'Rp ' + (value || 0).toLocaleString('id-ID');
    }

    // Form validation sebelum submit
    document.querySelector('#modalForm form').addEventListener('submit', function(e) {
        var tanggalBerangkat = document.getElementById('tanggal_berangkat').value;
        var tanggalKembali = document.getElementById('tanggal_kembali').value;
        var errorDiv = document.getElementById('tanggalConflictError');

        if (errorDiv && errorDiv.style.display !== 'none') {
            e.preventDefault();
            alert('Tidak dapat menyimpan: ' + errorDiv.textContent);
            return false;
        }

        return true;
    });

    document.addEventListener('DOMContentLoaded', syncTotalBayar);
</script>

<?= $this->endSection(); ?>