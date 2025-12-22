<?php

namespace App\Controllers;

use App\Models\PembayaranModel;

class Laporanpembayaran extends BaseController
{
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $data['pembayaran'] = $this->pembayaranModel->select('pembayaran.*, pemesanan.id as no_pemesanan, penyewa.nama_penyewa')
            ->join('pemesanan', 'pemesanan.id = pembayaran.id_pemesanan')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa')
            ->findAll();

        $data['total'] = count($data['pembayaran']);

        return view('laporan/pembayaran/laporan', $data);
    }

    public function cetak()
    {
        $data['pembayaran'] = $this->pembayaranModel->select('pembayaran.*, pemesanan.id as no_pemesanan, penyewa.nama_penyewa')
            ->join('pemesanan', 'pemesanan.id = pembayaran.id_pemesanan')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa')
            ->findAll();

        $data['total'] = count($data['pembayaran']);

        return view('laporan/pembayaran/cetak', $data);
    }
}
