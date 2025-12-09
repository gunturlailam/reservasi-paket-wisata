<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemilikModel;

class Pemilik extends BaseController
{
    protected $pemilikModel;

    public function __construct()
    {
        $this->pemilikModel = new PemilikModel();
    }

    public function index()
    {
        $data['pemilik'] = $this->pemilikModel->findAll();
        return view('/master/pemilik', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');

        // Validasi email unik - cek di semua tabel kecuali data yang sedang diedit
        $db = \Config\Database::connect();

        // Cek di tabel karyawan
        $existsInKaryawan = $db->table('karyawan')->where('email', $email)->countAllResults() > 0;

        // Cek di tabel penyewa
        $existsInPenyewa = $db->table('penyewa')->where('email', $email)->countAllResults() > 0;

        // Cek di tabel pemilik (kecuali data yang sedang diedit)
        $queryPemilik = $db->table('pemilik')->where('email', $email);
        if ($id) {
            $queryPemilik->where('id !=', $id);
        }
        $existsInPemilik = $queryPemilik->countAllResults() > 0;

        if ($existsInKaryawan || $existsInPenyewa || $existsInPemilik) {
            session()->setFlashdata('error', 'Email sudah terdaftar. Silakan gunakan email lain.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_pemilik' => $this->request->getPost('nama_pemilik'),
            'email' => $email,
            'nohp' => $this->request->getPost('nohp'),
            'alamat' => $this->request->getPost('alamat'),
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
                $oldData = $this->pemilikModel->find($id);
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
            $this->pemilikModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert - password wajib untuk data baru
            if (empty($password)) {
                session()->setFlashdata('error', 'Password wajib diisi untuk data baru');
                return redirect()->back()->withInput();
            }
            $this->pemilikModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pemilik');
    }

    public function delete($id)
    {
        // Hapus foto jika ada
        $data = $this->pemilikModel->find($id);
        if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/' . $data['foto'])) {
            unlink(FCPATH . 'uploads/' . $data['foto']);
        }

        $this->pemilikModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemilik');
    }

    public function getpemilik($id)
    {
        $data = $this->pemilikModel->find($id);
        return $this->response->setJSON($data);
    }
}
