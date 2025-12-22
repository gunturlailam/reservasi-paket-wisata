<?php

namespace App\Controllers;

class Laporanpemilik extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $pemilik = $db->table('pemilik')->get()->getResultArray();
        $data['pemilik'] = $pemilik;
        $data['total'] = count($pemilik);
        return view('laporan/pemilik/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();
        $pemilik = $db->table('pemilik')->get()->getResultArray();
        $data['pemilik'] = $pemilik;
        $data['total'] = count($pemilik);
        return view('laporan/pemilik/cetak', $data);
    }
}
