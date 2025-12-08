<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_karyawan',
        'alamat',
        'nohp',
        'id_jabatan',
        'email',
        'password',
        'foto'
    ];

    public function getAll()
    {
        return $this->select('karyawan.id,jabatan.nama_jabatan, karyawan.nama_karyawan, karyawan.alamat,karyawan.nohp, karyawan.id_jabatan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
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

    public function authenticate()
    {
        helper(['form']);
        $session = session();
        $request = service('request');

        $email = $request->getPost('email');
        $password = $request->getPost('password');
        $role = $request->getPost('role');

        if (empty($email) || empty($password) || empty($role)) {
            $session->setFlashdata('error', 'Email, password, dan role wajib diisi.');
            return redirect()->to('login');
        }

        $userModel = new \App\Models\UserModel();
        $user = null;

        if ($role == 'karyawan') {
            $user = $userModel->findKaryawanByEmail($email);
        } elseif ($role == 'penyewa') {
            $user = $userModel->findPenyewaByEmail($email);
        }

        if (!$user) {
            $session->setFlashdata('error', 'Email tidak ditemukan untuk role tersebut.');
            return redirect()->to('login');
        }

        if (!$userModel->verifyPassword($user['password'], $password)) {
            $session->setFlashdata('error', 'Password salah.');
            return redirect()->to('login');
        }

        $session->set('user', $user);
        // Redirect ke halaman utama (main.php)
        return redirect()->to('/');
    }
}
