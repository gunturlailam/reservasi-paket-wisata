<ul>
    <li>
        <a href="<?= site_url('/') ?>" class="waves-effect">
            <i class="mdi mdi-airplay"></i>
            <span> Beranda </span>
        </a>
    </li>

    <li class="has_sub">
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-gauge"></i>
            <span>Master </span>
            <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
        </a>

        <ul class="list-unstyled">
            <li><a href="<?= site_url('/jabatan') ?>">Jabatan</a></li>
            <li><a href="<?= site_url('/karyawan') ?>">Karyawan</a></li>
            <li><a href="<?= site_url('/jenisbus') ?>">Jenis Bus</a></li>
            <li><a href="<?= site_url('/bus') ?>">Bus</a></li>
            <li><a href="<?= site_url('/paketwisata') ?>">Paket Wisata</a></li>
            <li><a href="<?= site_url('/paketbus') ?>">Paket Bus</a></li>
            <li><a href="<?= site_url('/penyewa') ?>">Penyewa</a></li>
        </ul>
    </li>

    <li class="has_sub">
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-gauge"></i>
            <span>Transaksi </span>
            <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
        </a>

        <ul class="list-unstyled">
            <li><a href="<?= site_url('/pemesanan') ?>">Pemesanan</a></li>
            <li><a href="<?= site_url('/pemesanan-detail') ?>">Pemesanan Detail</a></li>
            <li><a href="<?= site_url('/pemberangkatan') ?>">Pemberangkatan</a></li>
            <li><a href="<?= site_url('/pembayaran') ?>">Pembayaran</a></li>
        </ul>
    </li>
</ul>