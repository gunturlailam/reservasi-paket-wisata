<?php

namespace App\Controllers;

use App\Models\KaryawanModel;

class Laporankaryawan extends BaseController
{
    public function index()
    {
        $model = new KaryawanModel();
        $karyawan = $model->findAll();
        $data['karyawan'] = $karyawan;
        $data['total'] = count($karyawan);
        return view('laporan/karyawan/laporan', $data);
    }

    public function cetak()
    {
        $model = new KaryawanModel();
        $karyawan = $model->findAll();
        $data['karyawan'] = $karyawan;
        $data['total'] = count($karyawan);
        return view('laporan/karyawan/cetak', $data);
    }
}
