<?php
$session = session();
$userRole = $session->get('user_role');
?>

<ul>
    <!-- Dashboard - Semua Role -->
    <li>
        <a href="<?= site_url('/dashboard') ?>" class="waves-effect">
            <i class="mdi mdi-airplay"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <?php if ($userRole === 'admin' || $userRole === 'karyawan'): ?>
        <!-- Menu Master - Hanya Admin/Karyawan -->
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="mdi mdi-database"></i>
                <span>Master Data </span>
                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
            </a>

            <ul class="list-unstyled">
                <li><a href="<?= site_url('/jabatan') ?>">Jabatan</a></li>
                <li><a href="<?= site_url('/karyawan') ?>">Karyawan</a></li>
                <li><a href="<?= site_url('/pemilik') ?>">Pemilik</a></li>
                <li><a href="<?= site_url('/jenisbus') ?>">Jenis Bus</a></li>
                <li><a href="<?= site_url('/bus') ?>">Armada Bus</a></li>
                <li><a href="<?= site_url('/paketwisata') ?>">Paket Wisata</a></li>
                <li><a href="<?= site_url('/paketbus') ?>">Paket Bus</a></li>
                <li><a href="<?= site_url('/penyewa') ?>">Data Penyewa</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ($userRole === 'penyewa'): ?>
        <!-- Menu untuk Penyewa -->
        <li>
            <a href="<?= site_url('/bus') ?>" class="waves-effect">
                <i class="mdi mdi-bus"></i>
                <span> Ketersediaan Bus </span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($userRole === 'admin' || $userRole === 'karyawan' || $userRole === 'penyewa'): ?>
        <!-- Menu Transaksi - Admin, Karyawan, Penyewa -->
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="mdi mdi-cart"></i>
                <span>Transaksi </span>
                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
            </a>

            <ul class="list-unstyled">
                <li><a href="<?= site_url('/pemesanan') ?>">Pemesanan Bus</a></li>
                <?php if ($userRole === 'admin' || $userRole === 'karyawan'): ?>
                    <li><a href="<?= site_url('/pemesanan-detail') ?>">Detail Pemesanan</a></li>
                <?php endif; ?>
                <li><a href="<?= site_url('/pembayaran') ?>">Pembayaran</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ($userRole === 'admin' || $userRole === 'karyawan' || $userRole === 'supir' || $userRole === 'pemilik'): ?>
        <!-- Jadwal Keberangkatan - Admin, Karyawan, Supir, Pemilik -->
        <li>
            <a href="<?= site_url('/pemberangkatan') ?>" class="waves-effect">
                <i class="mdi mdi-calendar-clock"></i>
                <span> Jadwal Keberangkatan </span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($userRole === 'admin' || $userRole === 'karyawan' || $userRole === 'pemilik'): ?>
        <!-- Laporan - Admin, Karyawan, Pemilik -->
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="mdi mdi-file-document"></i>
                <span>Laporan </span>
                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
            </a>

            <ul class="list-unstyled">
                <li><a href="<?= site_url('/laporanpemesanan') ?>">Laporan Pemesanan</a></li>
                <li><a href="<?= site_url('/laporanpembayaran') ?>">Laporan Pembayaran</a></li>
                <li><a href="<?= site_url('/laporanpemesanandetail') ?>">Laporan Detail Pemesanan</a></li>
                <li><a href="<?= site_url('/laporanpemberangkatan') ?>">Laporan Keberangkatan</a></li>
                <li><a href="<?= site_url('/laporan/periode') ?>"></i> Laporan Periode - Tujuan </a></li>
                <li><a href="<?= site_url('/laporankaryawan') ?>">Laporan Karyawan</a></li>
                <li><a href="<?= site_url('/laporanjabatan') ?>">Laporan Jabatan</a></li>
                <li><a href="<?= site_url('/laporanjenisbus') ?>">Laporan Jenis Bus</a></li>
                <li><a href="<?= site_url('/laporanbus') ?>">Laporan Bus</a></li>
                <li><a href="<?= site_url('/laporanpaketwisata') ?>">Laporan Paket Wisata</a></li>
                <li><a href="<?= site_url('/laporanpaketbus') ?>">Laporan Paket Bus</a></li>
                <li><a href="<?= site_url('/laporanpemilik') ?>">Laporan Pemilik</a></li>
                <li><a href="<?= site_url('/laporanpenyewa') ?>">Laporan Penyewa</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <!-- Logout - Semua Role -->
    <li>
        <a href="<?= site_url('/logout') ?>" class="waves-effect" onclick="return confirm('Apakah Anda yakin ingin logout?')">
            <i class="mdi mdi-logout"></i>
            <span> Logout </span>
        </a>
    </li>
</ul>