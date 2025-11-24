<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketbusModel extends Model
{
    protected $table            = 'paket_bus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_paketwisata',
        'id_bus'
    ];

    public function getAll()
    {
        return $this->select('paket_bus.id, paket_bus.id_paketwisata, paket_bus.id_bus, paket_wisata.nama_paket, bus.nomor_polisi, bus.merek')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('bus', 'bus.id = paket_bus.id_bus', 'left')
            ->findAll();
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
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
