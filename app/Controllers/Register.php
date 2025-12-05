<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\PenyewaModel;
use App\Models\JabatanModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    public function register()
    {
        $jabatanModel = new JabatanModel();
        $data['jabatan'] = $jabatanModel->findAll();
        return view('register_view', $data);
    }

    public function index()
    {
        // opsional, bisa redirect ke register
        return redirect()->to('/register');
    }

    public function store()
    {
        $role = $this->request->getPost('role');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $alamat = $this->request->getPost('alamat');
        $nohp = $this->request->getPost('nohp');

        if ($role == 'karyawan') {
            $model = new \App\Models\KaryawanModel();
            $model->insert([
                'nama_karyawan' => $nama,
                'email'         => $email,
                'nohp'          => $nohp,
                'password'      => $password,
                'alamat'        => $alamat,
                'id_jabatan'    => $this->request->getPost('id_jabatan'),
            ]);
        } elseif ($role == 'penyewa') {
            $model = new \App\Models\PenyewaModel();
            $model->insert([
                'nama_penyewa' => $nama,
                'email'        => $email,
                'no_telp'      => $nohp,
                'password'     => $password,
                'alamat'       => $alamat,
            ]);
        }
        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
