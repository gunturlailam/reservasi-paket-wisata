<?php

namespace App\Controllers;

class Laporanpenyewa extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $penyewa = $db->table('penyewa')->get()->getResultArray();
        $data['penyewa'] = $penyewa;
        $data['total'] = count($penyewa);
        return view('laporan/penyewa/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();
        $penyewa = $db->table('penyewa')->get()->getResultArray();
        $data['penyewa'] = $penyewa;
        $data['total'] = count($penyewa);
        return view('laporan/penyewa/cetak', $data);
    }
}
