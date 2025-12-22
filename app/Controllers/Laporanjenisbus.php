<?php

namespace App\Controllers;

use App\Models\JenisbusModel;

class Laporanjenisbus extends BaseController
{
    public function index()
    {
        $model = new JenisbusModel();
        $jenisbus = $model->findAll();
        $data['jenisbus'] = $jenisbus;
        $data['total'] = count($jenisbus);
        return view('laporan/jenisbus/laporan', $data);
    }

    public function cetak()
    {
        $model = new JenisbusModel();
        $jenisbus = $model->findAll();
        $data['jenisbus'] = $jenisbus;
        $data['total'] = count($jenisbus);
        return view('laporan/jenisbus/cetak', $data);
    }
}
