<?php

namespace App\Controllers;

use App\Models\JenisbusModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Jenisbus extends BaseController
{
    protected $jenisbusModel;

    public function __construct()
    {
        $this->jenisbusModel = new JenisbusModel();
    }

    public function index()
    {
        $data['jenisbus'] =  $this->jenisbusModel->findAll();
        return view('master/jenisbus', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_jenisbus' => $this->request->getPost('nama_jenisbus')
        ];

        if ($id) {
            // Update
            $this->jenisbusModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert
            $this->jenisbusModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/jenisbus');
    }

    public function delete($id)
    {
        $this->jenisbusModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/jenisbus');
    }

    public function getjenisbus($id)
    {
        $data = $this->jenisbusModel->find($id);
        return $this->response->setJSON($data);
    }
}
