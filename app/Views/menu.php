<ul>
    <li class="menu-title">Main</li>

    <li>
        <a href="<?= site_url('/') ?>" class="waves-effect">
            <i class="mdi mdi-airplay"></i> <span> Beranda </span>
        </a>
    </li>

    <li class="menu-title">Manajemen</li>

    <li class="has_sub">
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-gauge"></i> <span> Master </span>
            <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
        </a>
        <ul class="list-unstyled">
            <li><a href="<?= site_url('/kamar') ?>">Jabatan</a></li>
            <!-- <li><a href="<?= site_url('/kasir') ?>">KASIR</a></li>
            <li><a href="<?= site_url('/produk') ?>">PRODUK</a></li> -->
        </ul>
    </li>
</ul>