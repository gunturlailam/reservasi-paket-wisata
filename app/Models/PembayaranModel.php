<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_pemesanan',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_bayar',
        'bukti_bayar',
    ];
    protected $useTimestamps = false;
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getPembayaranList()
    {
        return $this->db->table('pembayaran')
            ->select('
                pembayaran.id,
                pembayaran.id_pemesanan,
                pembayaran.tanggal_bayar,
                pembayaran.jumlah_bayar,
                pembayaran.metode_bayar,
                pembayaran.bukti_bayar,
                pemesanan.tanggal_pesan,
                pemesanan.total_bayar,
                pemesanan_detail.tanggal_berangkat,
                pemesanan_detail.tanggal_kembali,
                paket_wisata.nama_paket,
                paket_wisata.tujuan
            ')
            ->join('pemesanan', 'pemesanan.id = pembayaran.id_pemesanan', 'inner')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pembayaran.id_pemesanan', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->orderBy('pembayaran.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPembayaranDetail($id)
    {
        return $this->db->table('pembayaran')
            ->select('
                pembayaran.*,
                pemesanan.tanggal_pesan,
                pemesanan.total_bayar,
                pemesanan_detail.tanggal_berangkat,
                pemesanan_detail.tanggal_kembali,
                paket_wisata.nama_paket,
                paket_wisata.tujuan
            ')
            ->join('pemesanan', 'pemesanan.id = pembayaran.id_pemesanan', 'left')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pembayaran.id_pemesanan', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->where('pembayaran.id', $id)
            ->get()
            ->getRowArray();
    }

    public function getLaporanPembayaran($tanggal_awal, $tanggal_akhir)
    {
        return $this->db->table('pembayaran')
            ->select('
                pembayaran.id,
                pembayaran.tanggal_bayar,
                pembayaran.jumlah_bayar,
                pembayaran.metode_bayar,
                penyewa.nama_penyewa,
                paket_wisata.nama_paket
            ')
            ->join('pemesanan', 'pemesanan.id = pembayaran.id_pemesanan', 'left')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->where('pembayaran.tanggal_bayar >=', $tanggal_awal)
            ->where('pembayaran.tanggal_bayar <=', $tanggal_akhir)
            ->where('pembayaran.tanggal_bayar IS NOT NULL', null, false)
            ->orderBy('pembayaran.tanggal_bayar', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPemesananBelumBayar()
    {
        return $this->db->table('pemesanan')
            ->select('
                pemesanan.id,
                pemesanan.tanggal_pesan,
                pemesanan.total_bayar,
                penyewa.nama_penyewa,
                paket_wisata.nama_paket,
                paket_wisata.tujuan,
                pemesanan_detail.tanggal_berangkat,
                pemesanan_detail.tanggal_kembali
            ')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id', 'left')
            ->where('pemesanan.id NOT IN (SELECT id_pemesanan FROM pembayaran)', null, false)
            ->get()
            ->getResultArray();
    }
}
