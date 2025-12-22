<?php

namespace App\Controllers;

use App\Models\BusModel;

class Laporanbus extends BaseController
{
    public function index()
    {
        $model = new BusModel();
        $db = \Config\Database::connect();

        // Join dengan tabel jenis_bus untuk mendapatkan nama jenis bus
        $bus = $db->table('bus')
            ->select('bus.id, bus.nomor_polisi, bus.merek, bus.kapasitas, jenis_bus.nama_jenisbus')
            ->join('jenis_bus', 'jenis_bus.id = bus.id_jenisbus', 'left')
            ->get()
            ->getResultArray();

        $data['bus'] = $bus;
        $data['total'] = count($bus);

        return view('laporan/bus/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();

        // Join dengan tabel jenis_bus untuk mendapatkan nama jenis bus
        $bus = $db->table('bus')
            ->select('bus.id, bus.nomor_polisi, bus.merek, bus.kapasitas, jenis_bus.nama_jenisbus')
            ->join('jenis_bus', 'jenis_bus.id = bus.id_jenisbus', 'left')
            ->get()
            ->getResultArray();

        $data['bus'] = $bus;
        $data['total'] = count($bus);

        return view('laporan/bus/cetak', $data);
    }
}
