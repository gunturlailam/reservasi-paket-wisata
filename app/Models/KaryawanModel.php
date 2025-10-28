<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_karyawan',
        'alamat',
        'no_hp',
        'id_jabatan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama_karyawan' => 'required|min_length[3]|max_length[100]',
        'alamat' => 'required|min_length[10]|max_length[255]',
        'no_hp' => 'required|min_length[10]|max_length[15]|numeric',
        'id_jabatan' => 'required|integer'
    ];

    protected $validationMessages = [
        'nama_karyawan' => [
            'required' => 'Nama karyawan harus diisi',
            'min_length' => 'Nama karyawan minimal 3 karakter',
            'max_length' => 'Nama karyawan maksimal 100 karakter'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 10 karakter',
            'max_length' => 'Alamat maksimal 255 karakter'
        ],
        'no_hp' => [
            'required' => 'Nomor HP harus diisi',
            'min_length' => 'Nomor HP minimal 10 digit',
            'max_length' => 'Nomor HP maksimal 15 digit',
            'numeric' => 'Nomor HP harus berupa angka'
        ],
        'id_jabatan' => [
            'required' => 'Jabatan harus dipilih',
            'integer' => 'ID Jabatan harus berupa angka'
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
     * Get all karyawan with jabatan info
     */
    public function getKaryawanWithJabatan()
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan')
                    ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
                    ->findAll();
    }

    /**
     * Get karyawan by ID with jabatan info
     */
    public function getKaryawanById($id)
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan')
                    ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
                    ->find($id);
    }

    /**
     * Search karyawan by name
     */
    public function searchKaryawan($keyword)
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan')
                    ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
                    ->like('nama_karyawan', $keyword)
                    ->findAll();
    }

    /**
     * Get karyawan by jabatan
     */
    public function getKaryawanByJabatan($id_jabatan)
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan')
                    ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
                    ->where('karyawan.id_jabatan', $id_jabatan)
                    ->findAll();
    }
}