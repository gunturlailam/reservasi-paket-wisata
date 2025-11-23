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
            <li><a href="<?= site_url('dokter/index') ?>">Dokter</a></li>
            <li><a href="charts-chartist.html">Pasien</a></li>
            <li><a href="charts-chartjs.html">Ruangan</a></li>
        </ul>
    </li>
</ul>