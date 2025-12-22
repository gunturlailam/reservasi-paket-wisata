<?php

namespace App\Controllers;

use App\Models\PemesananDetailModel;

class Laporanpemesanandetail extends BaseController
{
    protected $pemesananDetailModel;

    public function __construct()
    {
        $this->pemesananDetailModel = new PemesananDetailModel();
    }

    public function index()
    {
        $data['pemesananDetail'] = $this->pemesananDetailModel->select('pemesanan_detail.*, pemesanan.id as no_pemesanan')
            ->join('pemesanan', 'pemesanan.id = pemesanan_detail.id_pemesanan')
            ->findAll();

        $data['total'] = count($data['pemesananDetail']);

        return view('laporan/pemesanandetail/laporan', $data);
    }

    public function cetak()
    {
        $data['pemesananDetail'] = $this->pemesananDetailModel->select('pemesanan_detail.*, pemesanan.id as no_pemesanan')
            ->join('pemesanan', 'pemesanan.id = pemesanan_detail.id_pemesanan')
            ->findAll();

        $data['total'] = count($data['pemesananDetail']);

        return view('laporan/pemesanandetail/cetak', $data);
    }
}
