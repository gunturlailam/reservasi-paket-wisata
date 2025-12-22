<?php

namespace App\Controllers;

use App\Models\JabatanModel;

class Laporanjabatan extends BaseController
{
    public function index()
    {
        $model = new JabatanModel();
        $jabatan = $model->findAll();
        $data['jabatan'] = $jabatan;
        $data['total'] = count($jabatan);
        return view('laporan/jabatan/laporan', $data);
    }

    public function cetak()
    {
        $model = new JabatanModel();
        $jabatan = $model->findAll();
        $data['jabatan'] = $jabatan;
        $data['total'] = count($jabatan);
        return view('laporan/jabatan/cetak', $data);
    }
}
