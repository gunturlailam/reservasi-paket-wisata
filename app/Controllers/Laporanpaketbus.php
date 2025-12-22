<?php

namespace App\Controllers;

class Laporanpaketbus extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $paketbus = $db->table('paket_bus')
            ->select('paket_bus.id, paket_wisata.nama_paket, bus.nomor_polisi')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('bus', 'bus.id = paket_bus.id_bus', 'left')
            ->get()
            ->getResultArray();
        $data['paketbus'] = $paketbus;
        $data['total'] = count($paketbus);
        return view('laporan/paketbus/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();
        $paketbus = $db->table('paket_bus')
            ->select('paket_bus.id, paket_wisata.nama_paket, bus.nomor_polisi')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('bus', 'bus.id = paket_bus.id_bus', 'left')
            ->get()
            ->getResultArray();
        $data['paketbus'] = $paketbus;
        $data['total'] = count($paketbus);
        return view('laporan/paketbus/cetak', $data);
    }
}
