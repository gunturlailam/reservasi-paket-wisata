<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_jabatan'];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'nama_jabatan' => 'required|min_length[3]|max_length[100]'
    ];

    protected $validationMessages = [
        'nama_jabatan' => [
            'required' => 'Nama jabatan harus diisi',
            'min_length' => 'Nama jabatan minimal 3 karakter',
            'max_length' => 'Nama jabatan maksimal 100 karakter'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get jabatan with pagination
     */
    public function getJabatanPaginated($perPage = 10)
    {
        return $this->paginate($perPage);
    }

    /**
     * Search jabatan by name
     */
    public function searchJabatan($keyword)
    {
        return $this->like('nama_jabatan', $keyword)->findAll();
    }
}
