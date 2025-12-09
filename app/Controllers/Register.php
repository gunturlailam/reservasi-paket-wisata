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

        // Validasi email unik - cek di semua tabel
        $db = \Config\Database::connect();

        // Cek di tabel karyawan
        $existsInKaryawan = $db->table('karyawan')->where('email', $email)->countAllResults() > 0;

        // Cek di tabel penyewa
        $existsInPenyewa = $db->table('penyewa')->where('email', $email)->countAllResults() > 0;

        // Cek di tabel pemilik
        $existsInPemilik = $db->table('pemilik')->where('email', $email)->countAllResults() > 0;

        if ($existsInKaryawan || $existsInPenyewa || $existsInPemilik) {
            session()->setFlashdata('error', 'Email sudah terdaftar. Silakan gunakan email lain atau login.');
            return redirect()->to('/register')->withInput();
        }

        // Handle upload foto
        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Generate nama file unik
            $fotoName = $foto->getRandomName();

            // Pindahkan file ke folder uploads
            $foto->move(WRITEPATH . '../public/uploads', $fotoName);
        }

        // Hanya penyewa yang bisa register
        if ($role == 'penyewa') {
            $model = new \App\Models\PenyewaModel();
            $data = [
                'nama_penyewa' => $nama,
                'email'        => $email,
                'no_telp'      => $nohp,
                'password'     => $password,
                'alamat'       => $alamat,
            ];

            if ($fotoName) {
                $data['foto'] = $fotoName;
            }

            $model->insert($data);
        } else {
            return redirect()->to('/register')->with('error', 'Hanya penyewa yang bisa mendaftar melalui halaman ini.');
        }

        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
