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

    public function index()
    {
        $data['karyawan'] =  $this->karyawanModel->getAll();
        $data['jabatan'] =  $this->jabatanModel->findAll();
        return view('/master/karyawan', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_karyawan' => $this->request->getPost('nama_karyawan'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
        ];

        if ($id) {
            // Update
            $this->karyawanModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert
            $this->karyawanModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/karyawan');
    }

    public function delete($id)
    {
        $this->karyawanModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/karyawan');
    }

    public function getkaryawan($id)
    {
        $data = $this->karyawanModel->find($id);
        return $this->response->setJSON($data);
    }
}