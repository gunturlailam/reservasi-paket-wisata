<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Jabatan extends BaseController
{
    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data['jabatan'] =  $this->jabatanModel->findAll();
        return view('master/jabatan', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan')
        ];

        if ($id) {
            // Update
            $this->jabatanModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert
            $this->jabatanModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/jabatan');
    }

    public function delete($id)
    {
        $this->jabatanModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/jabatan');
    }

    public function getjabatan($id)
    {
        $data = $this->jabatanModel->find($id);
        return $this->response->setJSON($data);
    }
}