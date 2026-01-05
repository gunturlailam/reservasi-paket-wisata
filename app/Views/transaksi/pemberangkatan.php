<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<style>
    .card-header-custom {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 0 auto;
    }

    .pesanan-info {
        background: #e3f2fd;
        border: 2px solid #1a73e8;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .pesanan-info .icon {
        color: #1a73e8;
        font-size: 1.2rem;
    }

    .btn-konfirmasi {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
        border: none;
        padding: 12px;
        font-weight: 600;
    }

    .btn-konfirmasi:hover {
        background: linear-gradient(135deg, #0d47a1 0%, #1a73e8 100%);
    }
</style>

<div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-0">Riwayat Reservasi Bus</h3>
        </div>
        <a href="<?= site_url('/pemesanan') ?>" class="btn btn-outline-primary">
            <i class="mdi mdi-plus"></i> Tambah Pesanan
        </a>
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

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <span class="text-muted">Pemesanan Berhasil</span>
                <i class="mdi mdi-check-circle text-success ml-2"></i>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tgl Pesan</th>
                            <th>Paket Wisata & Tujuan</th>
                            <th>Jadwal Keberangkatan</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reservasi)) : ?>
                            <?php foreach ($reservasi as $row) : ?>
                                <tr>
                                    <td>#<?= esc($row['id']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal_pesan'])) ?></td>
                                    <td>
                                        <div class="fw-bold"><?= esc($row['nama_paket'] ?? '-') ?></div>
                                        <small class="text-muted"><?= esc($row['tujuan'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['tanggal_berangkat'])) : ?>
                                            <?= date('d/m/Y', strtotime($row['tanggal_berangkat'])) ?>
                                            <br><small class="text-muted">s/d <?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></small>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>Rp</div>
                                        <div class="fw-bold"><?= number_format((float)($row['total_bayar'] ?? 0), 0, ',', '.') ?></div>
                                    </td>
                                    <td>
                                        <?php if (empty($row['pembayaran_id'])) : ?>
                                            <span class="badge" style="background-color: #ffc107; color: #000; padding: 6px 12px;">Menunggu Pembayaran</span>
                                        <?php else : ?>
                                            <span class="badge" style="background-color: #28a745; color: white; padding: 6px 12px;">Lunas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (empty($row['pembayaran_id'])) : ?>
                                            <!-- Belum bayar -->
                                            <a href="<?= site_url('/pembayaran') ?>" class="btn btn-success btn-sm">Bayar</a>
                                            <a href="<?= site_url('/pemesanan/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan pesanan ini?')">Batal</a>
                                        <?php elseif (empty($row['pemberangkatan_id'])) : ?>
                                            <!-- Sudah bayar, belum atur keberangkatan -->
                                            <button type="button" class="btn btn-primary btn-sm" onclick="aturKeberangkatan(<?= $row['id'] ?>, '<?= esc($row['nama_paket']) ?>')">
                                                Atur Keberangkatan
                                            </button>
                                        <?php else : ?>
                                            <!-- Sudah ada keberangkatan -->
                                            <a href="<?= site_url('/pemberangkatan/cetak/' . $row['pemberangkatan_id']) ?>" class="btn btn-outline-success btn-sm" target="_blank">
                                                <i class="mdi mdi-file-document"></i> Cetak Surat Jalan
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data reservasi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atur Keberangkatan -->
<div class="modal fade" id="modalAturKeberangkatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="form-card modal-content" style="border: none;">
            <div class="card-header-custom text-center">
                <h5 class="mb-1"><i class="mdi mdi-bus"></i> Atur Keberangkatan</h5>
                <small>Lengkapi data armada dan kru sebelum berangkat</small>
            </div>
            <form action="<?= site_url('/pemberangkatan/save') ?>" method="post">
                <div class="modal-body p-4">
                    <input type="hidden" name="id_pemesanan" id="modal_id_pemesanan">
                    <input type="hidden" name="tanggal_berangkat" id="modal_tanggal_berangkat">
                    <input type="hidden" name="id_bus" id="modal_id_bus">

                    <div class="pesanan-info">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-file-document-outline icon mr-2"></i>
                            <div>
                                <div class="fw-bold" id="modal_pesanan_label">Pesanan #0</div>
                                <small class="text-muted" id="modal_paket_label">-</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="mdi mdi-calendar"></i> Tanggal Keberangkatan</label>
                        <div class="form-control bg-light" id="modal_tanggal_display">-</div>
                        <small class="text-muted">Tanggal otomatis dari data pemesanan</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="mdi mdi-bus"></i> Bus (Armada)</label>
                        <div class="form-control bg-light" id="modal_bus_display">-</div>
                        <small class="text-muted">Bus otomatis dari paket yang dipilih</small>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"><i class="mdi mdi-account"></i> Sopir <span class="text-danger">*</span></label>
                            <select name="id_sopir" id="modal_id_sopir" class="form-control" required>
                                <option value="">Pilih Sopir</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label"><i class="mdi mdi-account-multiple"></i> Kernet <span class="text-danger">*</span></label>
                            <select name="id_kernet" id="modal_id_kernet" class="form-control" required>
                                <option value="">Pilih Kernet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <div class="w-100">
                        <button type="submit" class="btn btn-primary btn-konfirmasi w-100 mb-2">
                            <i class="mdi mdi-check"></i> Konfirmasi Sekarang
                        </button>
                        <button type="button" class="btn btn-link w-100 text-muted" data-dismiss="modal">
                            ← Kembali ke Riwayat
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Data reservasi dan karyawan untuk JavaScript -->
<script>
    var reservasiData = <?= json_encode($reservasi ?? []) ?>;
    var allSopir = <?= json_encode($sopir ?? []) ?>;
    var allKernet = <?= json_encode($kernet ?? []) ?>;
</script>

<script>
    var currentEditId = null;

    function aturKeberangkatan(idPemesanan, namaPaket) {
        currentEditId = null;
        document.getElementById('modal_id_pemesanan').value = idPemesanan;
        document.getElementById('modal_pesanan_label').innerText = 'Pesanan #' + idPemesanan;
        document.getElementById('modal_paket_label').innerText = namaPaket || '-';
        document.getElementById('modal_id_sopir').value = '';
        document.getElementById('modal_id_kernet').value = '';

        // Cari data reservasi
        var reservasiItem = null;
        for (var i = 0; i < reservasiData.length; i++) {
            if (reservasiData[i].id == idPemesanan) {
                reservasiItem = reservasiData[i];
                break;
            }
        }

        if (!reservasiItem) {
            alert('Data reservasi tidak ditemukan!');
            return;
        }

        var tanggalBerangkat = reservasiItem.tanggal_berangkat || '';
        var idBus = reservasiItem.id_bus || '';
        var nomorPolisi = reservasiItem.nomor_polisi || '';
        var merek = reservasiItem.merek || '';

        // Set tanggal berangkat
        document.getElementById('modal_tanggal_berangkat').value = tanggalBerangkat;

        // Format tanggal untuk display
        if (tanggalBerangkat) {
            var d = new Date(tanggalBerangkat);
            var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            document.getElementById('modal_tanggal_display').innerText = d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
        } else {
            document.getElementById('modal_tanggal_display').innerText = 'Tanggal belum ditentukan';
        }

        // Set bus otomatis dari pemesanan
        document.getElementById('modal_id_bus').value = idBus;
        if (nomorPolisi && merek) {
            document.getElementById('modal_bus_display').innerText = nomorPolisi + ' - ' + merek;
        } else {
            document.getElementById('modal_bus_display').innerText = 'Bus belum ditentukan';
        }

        // Cek ketersediaan sopir/kernet dan populate dropdown
        if (tanggalBerangkat) {
            cekKetersediaanDanPopulate(tanggalBerangkat);
        }

        $('#modalAturKeberangkatan').modal('show');
    }

    function cekKetersediaanDanPopulate(tanggal) {
        var url = '<?= site_url('/pemberangkatan/cek-ketersediaan') ?>?tanggal=' + tanggal;
        if (currentEditId) {
            url += '&exclude_id=' + currentEditId;
        }

        console.log('Fetching ketersediaan:', url); // Debug

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data); // Debug

                // Convert semua ke integer untuk konsistensi
                var unavailableSopir = (data.unavailable_sopir || []).map(function(id) {
                    return parseInt(id);
                });
                var unavailableKernet = (data.unavailable_kernet || []).map(function(id) {
                    return parseInt(id);
                });

                console.log('Unavailable Sopir IDs:', unavailableSopir); // Debug
                console.log('Unavailable Kernet IDs:', unavailableKernet); // Debug

                // Populate sopir dropdown (exclude yang tidak tersedia)
                populateSopirDropdown(unavailableSopir);

                // Populate kernet dropdown (exclude yang tidak tersedia)
                populateKernetDropdown(unavailableKernet);
            })
            .catch(function(error) {
                console.error('Error fetching ketersediaan:', error);
            });
    }

    function populateSopirDropdown(unavailableIds) {
        var select = document.getElementById('modal_id_sopir');
        select.innerHTML = '<option value="">Pilih Sopir</option>';

        console.log('All Sopir:', allSopir); // Debug

        allSopir.forEach(function(sopir) {
            var sopirId = parseInt(sopir.id);
            var isUnavailable = unavailableIds.indexOf(sopirId) !== -1;

            console.log('Sopir:', sopir.nama_karyawan, 'ID:', sopirId, 'Unavailable:', isUnavailable); // Debug

            // Hanya tampilkan jika tidak ada di unavailable list
            if (!isUnavailable) {
                var option = document.createElement('option');
                option.value = sopir.id;
                option.textContent = sopir.nama_karyawan;
                select.appendChild(option);
            }
        });

        // Jika tidak ada sopir tersedia
        if (select.options.length === 1) {
            var option = document.createElement('option');
            option.value = '';
            option.textContent = '-- Tidak ada sopir tersedia --';
            option.disabled = true;
            select.appendChild(option);
        }
    }

    function populateKernetDropdown(unavailableIds) {
        var select = document.getElementById('modal_id_kernet');
        select.innerHTML = '<option value="">Pilih Kernet</option>';

        console.log('All Kernet:', allKernet); // Debug

        allKernet.forEach(function(kernet) {
            var kernetId = parseInt(kernet.id);
            var isUnavailable = unavailableIds.indexOf(kernetId) !== -1;

            console.log('Kernet:', kernet.nama_karyawan, 'ID:', kernetId, 'Unavailable:', isUnavailable); // Debug

            // Hanya tampilkan jika tidak ada di unavailable list
            if (!isUnavailable) {
                var option = document.createElement('option');
                option.value = kernet.id;
                option.textContent = kernet.nama_karyawan;
                select.appendChild(option);
            }
        });

        // Jika tidak ada kernet tersedia
        if (select.options.length === 1) {
            var option = document.createElement('option');
            option.value = '';
            option.textContent = '-- Tidak ada kernet tersedia --';
            option.disabled = true;
            select.appendChild(option);
        }
    }

    // Validasi sopir dan kernet tidak boleh sama
    document.getElementById('modal_id_kernet').addEventListener('change', function() {
        var sopir = document.getElementById('modal_id_sopir').value;
        var kernet = this.value;

        if (sopir && kernet && sopir === kernet) {
            alert('Sopir dan Kernet tidak boleh orang yang sama!');
            this.value = '';
        }
    });

    document.getElementById('modal_id_sopir').addEventListener('change', function() {
        var sopir = this.value;
        var kernet = document.getElementById('modal_id_kernet').value;

        if (sopir && kernet && sopir === kernet) {
            alert('Sopir dan Kernet tidak boleh orang yang sama!');
            document.getElementById('modal_id_kernet').value = '';
        }
    });

    // Form validation sebelum submit
    document.querySelector('#modalAturKeberangkatan form').addEventListener('submit', function(e) {
        var tanggal = document.getElementById('modal_tanggal_berangkat').value;
        var bus = document.getElementById('modal_id_bus').value;
        var sopir = document.getElementById('modal_id_sopir').value;
        var kernet = document.getElementById('modal_id_kernet').value;

        if (!tanggal) {
            e.preventDefault();
            alert('Tanggal keberangkatan tidak valid!');
            return false;
        }

        if (!bus) {
            e.preventDefault();
            alert('Bus tidak valid! Pastikan paket memiliki bus.');
            return false;
        }

        if (!sopir) {
            e.preventDefault();
            alert('Pilih sopir terlebih dahulu!');
            return false;
        }

        if (!kernet) {
            e.preventDefault();
            alert('Pilih kernet terlebih dahulu!');
            return false;
        }

        if (sopir === kernet) {
            e.preventDefault();
            alert('Sopir dan Kernet tidak boleh orang yang sama!');
            return false;
        }

        return true;
    });
</script>

<?= $this->endSection(); ?>