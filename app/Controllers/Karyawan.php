<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KaryawanModel;
use App\Models\JabatanModel;

class Karyawan extends BaseController
{
    protected $jabatanModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel;
        $this->jabatanModel = new JabatanModel();
    }

    // Fungsi untuk cek login
    private function checkLogin()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return null;
    }

    public function index()
    {
        // Cek login
        $login = $this->checkLogin();
        if ($login) return $login;

        $data['karyawan'] =  $this->karyawanModel->getAll();
        $data['jabatan'] =  $this->jabatanModel->findAll();
        return view('/master/karyawan', $data);
    }

    public function save()
    {
        // Cek login
        $login = $this->checkLogin();
        if ($login) return $login;

        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');

        // Validasi email unik - cek di semua tabel kecuali data yang sedang diedit
        $db = \Config\Database::connect();

        // Cek di tabel karyawan (kecuali data yang sedang diedit)
        $queryKaryawan = $db->table('karyawan')->where('email', $email);
        if ($id) {
            $queryKaryawan->where('id !=', $id);
        }
        $existsInKaryawan = $queryKaryawan->countAllResults() > 0;

        // Cek di tabel penyewa
        $existsInPenyewa = $db->table('penyewa')->where('email', $email)->countAllResults() > 0;

        // Cek di tabel pemilik
        $existsInPemilik = $db->table('pemilik')->where('email', $email)->countAllResults() > 0;

        if ($existsInKaryawan || $existsInPenyewa || $existsInPemilik) {
            session()->setFlashdata('error', 'Email sudah terdaftar. Silakan gunakan email lain.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_karyawan' => $this->request->getPost('nama_karyawan'),
            'email' => $email,
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
        ];

        // Handle password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle upload foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama jika update
            if ($id) {
                $oldData = $this->karyawanModel->find($id);
                if (!empty($oldData['foto']) && file_exists(FCPATH . 'uploads/' . $oldData['foto'])) {
                    unlink(FCPATH . 'uploads/' . $oldData['foto']);
                }
            }

            // Upload foto baru
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads', $fotoName);
            $data['foto'] = $fotoName;
        }

        if ($id) {
            // Update
            $this->karyawanModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert - password wajib untuk data baru
            if (empty($password)) {
                session()->setFlashdata('error', 'Password wajib diisi untuk data baru');
                return redirect()->back()->withInput();
            }
            $this->karyawanModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/karyawan');
    }

    public function delete($id)
    {
        // Cek login
        $login = $this->checkLogin();
        if ($login) return $login;

        $this->karyawanModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/karyawan');
    }

    public function getkaryawan($id)
    {
        // Cek login
        $login = $this->checkLogin();
        if ($login) return $login;

        $data = $this->karyawanModel->find($id);
        return $this->response->setJSON($data);
    }
}
