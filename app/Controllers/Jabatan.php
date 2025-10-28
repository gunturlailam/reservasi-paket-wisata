<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
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
        $data['jabatan'] = $this->jabatanModel->findAll();
        return view('jabatan/index', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'namajabatan' => $this->request->getPost('namajabatan')
        ];

        if ($id) {
            // Update
            $this->jabatanModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui.');
        } else {
            // Insert 
            $this->jabatanModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
        }

        return redirect()->to('/jabatan');
    }

    public function delete($id)
    {
        $data = $this->jabatanModel->find($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('/jabatan');
    }

    public function getJabatan($id)
    {
        $data = $this->jabatanModel->find($id);
        return $this->response->setJSON($data);
    }
}
