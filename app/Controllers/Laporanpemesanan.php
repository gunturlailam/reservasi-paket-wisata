<?php

namespace App\Controllers;

use App\Models\PemesananModel;

class Laporanpemesanan extends BaseController
{
    protected $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $data['pemesanan'] = $this->pemesananModel->select('pemesanan.*, penyewa.nama_penyewa, paket_wisata.nama_paket')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->findAll();

        $data['total'] = count($data['pemesanan']);

        return view('laporan/pemesanan/laporan', $data);
    }

    public function cetak()
    {
        $data['pemesanan'] = $this->pemesananModel->select('pemesanan.*, penyewa.nama_penyewa, paket_wisata.nama_paket')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->findAll();

        $data['total'] = count($data['pemesanan']);

        return view('laporan/pemesanan/cetak', $data);
    }
}
