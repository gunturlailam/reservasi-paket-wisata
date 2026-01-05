<?php

namespace App\Models;

use CodeIgniter\Model;

class PemberangkatanModel extends Model
{
    protected $table            = 'pemberangkatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pemesanan',
        'id_bus',
        'id_sopir',
        'id_kernet',
        'tanggal_berangkat',
    ];

    public function getAll()
    {
        return $this->select('pemberangkatan.*, pemesanan.id as kode_pemesanan, penyewa.nama_penyewa, bus.nomor_polisi, bus.merek, sopir.nama_karyawan as nama_sopir, kernet.nama_karyawan as nama_kernet')
            ->join('pemesanan', 'pemesanan.id = pemberangkatan.id_pemesanan', 'left')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('bus', 'bus.id = pemberangkatan.id_bus', 'left')
            ->join('karyawan as sopir', 'sopir.id = pemberangkatan.id_sopir', 'left')
            ->join('karyawan as kernet', 'kernet.id = pemberangkatan.id_kernet', 'left')
            ->findAll();
    }

    /**
     * Cek apakah bus tersedia pada tanggal tertentu
     */
    public function isBusAvailable($idBus, $tanggal, $excludeId = null)
    {
        $builder = $this->where('id_bus', $idBus)
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    /**
     * Cek apakah sopir tersedia pada tanggal tertentu
     */
    public function isSopirAvailable($idSopir, $tanggal, $excludeId = null)
    {
        $builder = $this->where('id_sopir', $idSopir)
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    /**
     * Cek apakah kernet tersedia pada tanggal tertentu
     */
    public function isKernetAvailable($idKernet, $tanggal, $excludeId = null)
    {
        $builder = $this->where('id_kernet', $idKernet)
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    /**
     * Get bus yang tidak tersedia pada tanggal tertentu
     */
    public function getUnavailableBus($tanggal, $excludeId = null)
    {
        $builder = $this->select('id_bus')
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        $result = $builder->findAll();
        return array_column($result, 'id_bus');
    }

    /**
     * Get sopir yang tidak tersedia pada tanggal tertentu
     */
    public function getUnavailableSopir($tanggal, $excludeId = null)
    {
        $builder = $this->select('id_sopir')
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        $result = $builder->findAll();
        return array_map('intval', array_column($result, 'id_sopir'));
    }

    /**
     * Get kernet yang tidak tersedia pada tanggal tertentu
     */
    public function getUnavailableKernet($tanggal, $excludeId = null)
    {
        $builder = $this->select('id_kernet')
            ->where('tanggal_berangkat', $tanggal);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        $result = $builder->findAll();
        return array_map('intval', array_column($result, 'id_kernet'));
    }

    /**
     * Laporan perjalanan berdasarkan periode tanggal (dengan filter tujuan opsional)
     *
     * Digunakan oleh Pemberangkatan::laporanPeriode() dan cetakLaporanPeriode().
     */
    public function getLaporanByPeriode(?string $tanggalMulai = null, ?string $tanggalSelesai = null, ?string $tujuan = null): array
    {
        $builder = $this->db->table('pemberangkatan');

        $builder->select('
                pemberangkatan.id,
                pemberangkatan.tanggal_berangkat,
                pemesanan.id as kode_pemesanan,
                pemesanan.tanggal_pesan,
                pemesanan.total_bayar,
                penyewa.nama_penyewa,
                penyewa.alamat as alamat_penyewa,
                penyewa.no_telp as nohp_penyewa,
                bus.nomor_polisi,
                bus.merek,
                bus.kapasitas,
                sopir.nama_karyawan as nama_sopir,
                kernet.nama_karyawan as nama_kernet,
                paket_wisata.nama_paket,
                paket_wisata.tujuan,
                pemesanan_detail.tanggal_berangkat as tgl_berangkat_detail,
                pemesanan_detail.tanggal_kembali,
                pemesanan_detail.jumlah_penumpang as jumlah_peserta,
                paket_wisata.harga
            ');

        $builder->join('pemesanan', 'pemesanan.id = pemberangkatan.id_pemesanan', 'left');
        $builder->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left');
        $builder->join('bus', 'bus.id = pemberangkatan.id_bus', 'left');
        $builder->join('karyawan as sopir', 'sopir.id = pemberangkatan.id_sopir', 'left');
        $builder->join('karyawan as kernet', 'kernet.id = pemberangkatan.id_kernet', 'left');
        $builder->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left');
        $builder->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left');
        $builder->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id', 'left');

        // Filter periode tanggal (kombinasi sesuai panduan)
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $builder->where('DATE(pemesanan_detail.tanggal_berangkat) >=', $tanggalMulai);
            $builder->where('DATE(pemesanan_detail.tanggal_berangkat) <=', $tanggalSelesai);
        } elseif (!empty($tanggalMulai)) {
            $builder->where('DATE(pemesanan_detail.tanggal_berangkat) >=', $tanggalMulai);
        } elseif (!empty($tanggalSelesai)) {
            $builder->where('DATE(pemesanan_detail.tanggal_berangkat) <=', $tanggalSelesai);
        }

        // Filter tujuan jika dipilih
        if (!empty($tujuan)) {
            $builder->where('paket_wisata.tujuan', $tujuan);
        }

        $builder->orderBy('pemesanan_detail.tanggal_berangkat', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Laporan perjalanan berdasarkan tujuan saja (tanpa filter tanggal)
     * Dipakai oleh laporan tujuan.
     */
    public function getLaporanByTujuan(?string $tujuan = null): array
    {
        return $this->getLaporanByPeriode(null, null, $tujuan);
    }

    /**
     * Ambil daftar tujuan unik untuk pilihan filter laporan tujuan/periode
     */
    public function getDaftarTujuan(): array
    {
        return $this->db->table('paket_wisata')
            ->select('tujuan')
            ->distinct() // Cara benar di CI4 
            ->where('tujuan IS NOT NULL')
            ->orderBy('tujuan', 'ASC')
            ->get()
            ->getResultArray();
    }
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}