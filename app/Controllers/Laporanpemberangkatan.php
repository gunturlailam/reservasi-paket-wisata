<?php

namespace App\Controllers;

class Laporanpemberangkatan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Join dengan tabel pemesanan, bus, dan karyawan
        $pemberangkatan = $db->table('pemberangkatan')
            ->select('pemberangkatan.id, pemberangkatan.tanggal_berangkat, bus.nomor_polisi, sopir.nama_karyawan as nama_sopir, kernet.nama_karyawan as nama_kernet')
            ->join('bus', 'bus.id = pemberangkatan.id_bus', 'left')
            ->join('karyawan as sopir', 'sopir.id = pemberangkatan.id_sopir', 'left')
            ->join('karyawan as kernet', 'kernet.id = pemberangkatan.id_kernet', 'left')
            ->orderBy('pemberangkatan.tanggal_berangkat', 'DESC')
            ->get()
            ->getResultArray();

        $data['pemberangkatan'] = $pemberangkatan;
        $data['total'] = count($pemberangkatan);

        return view('laporan/pemberangkatan/laporan', $data);
    }

    public function cetak()
    {
        $db = \Config\Database::connect();

        // Join dengan tabel pemesanan, bus, dan karyawan
        $pemberangkatan = $db->table('pemberangkatan')
            ->select('pemberangkatan.id, pemberangkatan.tanggal_berangkat, bus.nomor_polisi, sopir.nama_karyawan as nama_sopir, kernet.nama_karyawan as nama_kernet')
            ->join('bus', 'bus.id = pemberangkatan.id_bus', 'left')
            ->join('karyawan as sopir', 'sopir.id = pemberangkatan.id_sopir', 'left')
            ->join('karyawan as kernet', 'kernet.id = pemberangkatan.id_kernet', 'left')
            ->orderBy('pemberangkatan.tanggal_berangkat', 'DESC')
            ->get()
            ->getResultArray();

        $data['pemberangkatan'] = $pemberangkatan;
        $data['total'] = count($pemberangkatan);

        return view('laporan/pemberangkatan/cetak', $data);
    }
}
