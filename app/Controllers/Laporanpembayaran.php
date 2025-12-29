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
        $tanggal_awal = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        // Cek apakah filter sudah disubmit
        $isFiltered = $tanggal_awal && $tanggal_akhir;

        $pembayaran = [];
        $total = 0;

        if ($isFiltered) {
            $pembayaran = $this->pembayaranModel->getLaporanPembayaran($tanggal_awal, $tanggal_akhir);
            foreach ($pembayaran as $row) {
                $total += $row['jumlah_bayar'];
            }
        }

        $data = [
            'title' => 'Laporan Pembayaran',
            'pembayaran' => $pembayaran,
            'tanggal_awal' => $tanggal_awal ?? date('Y-m-01'),
            'tanggal_akhir' => $tanggal_akhir ?? date('Y-m-d'),
            'total' => $total,
            'isFiltered' => $isFiltered,
        ];

        return view('laporan/laporan_pembayaran', $data);
    }

    public function cetak()
    {
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-01');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        $pembayaran = $this->pembayaranModel->getLaporanPembayaran($tanggal_awal, $tanggal_akhir);

        $total = 0;
        foreach ($pembayaran as $row) {
            $total += $row['jumlah_bayar'];
        }

        $data = [
            'title' => 'Laporan Pembayaran',
            'pembayaran' => $pembayaran,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'total' => $total,
        ];

        return view('laporan/laporan_pembayaran_cetak', $data);
    }
}
