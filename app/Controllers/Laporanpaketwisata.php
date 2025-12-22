<?php

namespace App\Controllers;

class Laporanpaketwisata extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $paketwisata = $db->table('paket_wisata')->get()->getResultArray();
        $data['paketwisata'] = $paketwisata;
        $data['total'] = count($paketwisata);
        return view('laporan/paketwisata/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();
        $paketwisata = $db->table('paket_wisata')->get()->getResultArray();
        $data['paketwisata'] = $paketwisata;
        $data['total'] = count($paketwisata);
        return view('laporan/paketwisata/cetak', $data);
    }
}
