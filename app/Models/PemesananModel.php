<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal_pesan',
        'id_penyewa',
        'id_paketbus',
        'total_bayar',
    ];

    public function getAll()
    {
        return $this->select('pemesanan.*, penyewa.nama_penyewa, paket_bus.id as kode_paketbus, paket_wisata.nama_paket')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->findAll();
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
