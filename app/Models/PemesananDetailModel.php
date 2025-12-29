<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananDetailModel extends Model
{
    protected $table            = 'pemesanan_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pemesanan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'jumlah_penumpang',
    ];

    public function getAll()
    {
        return $this->withPaymentSelect()
            ->findAll();
    }

    public function getPaged(int $perPage = 10)
    {
        return $this->withPaymentSelect()
            ->orderBy('pemesanan_detail.id', 'DESC')
            ->paginate($perPage);
    }

    public function getPagedByPenyewa(int $penyewaId, int $perPage = 10)
    {
        return $this->withPaymentSelect()
            ->where('pemesanan.id_penyewa', $penyewaId)
            ->orderBy('pemesanan_detail.id', 'DESC')
            ->paginate($perPage);
    }

    private function withPaymentSelect()
    {
        return $this->select('pemesanan_detail.*, pemesanan.tanggal_pesan, penyewa.nama_penyewa, paket_wisata.nama_paket, paket_wisata.harga, pembayaran.id as pembayaran_id, pembayaran.jumlah_bayar, pembayaran.tanggal_bayar')
            ->join('pemesanan', 'pemesanan.id = pemesanan_detail.id_pemesanan', 'left')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('pembayaran', 'pembayaran.id_pemesanan = pemesanan_detail.id_pemesanan', 'left');
    }

    public function checkBusAvailability($idBus, $tanggalBerangkat, $tanggalKembali, $excludeId = null)
    {
        $query = $this->db->table('pemberangkatan')
            ->select('pemberangkatan.id')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemberangkatan.id_pemesanan', 'left')
            ->where('pemberangkatan.id_bus', $idBus)
            ->where('((pemesanan_detail.tanggal_berangkat <= "' . $tanggalKembali . '" AND pemesanan_detail.tanggal_kembali >= "' . $tanggalBerangkat . '"))');

        if ($excludeId) {
            $query = $query->where('pemesanan_detail.id !=', $excludeId);
        }

        return $query->get()->getNumRows() === 0;
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