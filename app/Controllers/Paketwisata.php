<?php

namespace App\Controllers;

use App\Models\PaketwisataModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Paketwisata extends BaseController
{
    protected $paketwisataModel;

    public function __construct()
    {
        $this->paketwisataModel = new paketwisataModel();
    }

    public function index()
    {
        $data['paketwisata'] =  $this->paketwisataModel->findAll();
        return view('master/paketwisata', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'tujuan' => $this->request->getPost('tujuan'),
            'harga' => $this->request->getPost('harga')
        ];

        if ($id) {
            // Update
            $this->paketwisataModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert
            $this->paketwisataModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/paketwisata');
    }

    public function delete($id)
    {
        $this->paketwisataModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/paketwisata');
    }

    public function getpaketwisata($id)
    {
        $data = $this->paketwisataModel->find($id);
        return $this->response->setJSON($data);
    }
}
