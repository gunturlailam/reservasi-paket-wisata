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
