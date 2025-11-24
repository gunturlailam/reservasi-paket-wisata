<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JenisbusModel;
use App\Models\BusModel;

class Bus extends BaseController
{
    protected $jenis_busModel;
    protected $busModel;

    public function __construct()
    {
        $this->busModel = new BusModel();
        $this->jenis_busModel = new JenisbusModel();
    }

    public function index()
    {
        $data['bus'] =  $this->busModel->getAll();
        $data['jenisbus'] =  $this->jenis_busModel->findAll();
        return view('/master/bus', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nomor_polisi' => $this->request->getPost('nomor_polisi'),
            'merek' => $this->request->getPost('merek'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'id_jenisbus' => $this->request->getPost('id_jenisbus'),
        ];

        if ($id) {
            // Update
            $this->busModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert
            $this->busModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/bus');
    }

    public function delete($id)
    {
        $this->busModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/bus');
    }

    public function getbus($id)
    {
        $data = $this->busModel->find($id);
        return $this->response->setJSON($data);
    }
}
