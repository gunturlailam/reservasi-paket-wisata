<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BusModel;
use App\Models\PaketbusModel;
use App\Models\PaketwisataModel;

class Paketbus extends BaseController
{
    protected $paketbusModel;
    protected $paketwisataModel;
    protected $busModel;

    public function __construct()
    {
        $this->paketbusModel = new PaketbusModel();
        $this->paketwisataModel = new PaketwisataModel();
        $this->busModel = new BusModel();
    }

    public function index()
    {
        $data = [
            'paketbus' => $this->paketbusModel->getAll(),
            'paketwisata' => $this->paketwisataModel->findAll(),
            'bus' => $this->busModel->findAll(),
        ];

        return view('master/paketbus', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'id_paketwisata' => $this->request->getPost('id_paketwisata'),
            'id_bus' => $this->request->getPost('id_bus'),
        ];

        if ($id) {
            $this->paketbusModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->paketbusModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/paketbus');
    }

    public function delete($id)
    {
        $this->paketbusModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/paketbus');
    }

    public function getpaketbus($id)
    {
        $data = $this->paketbusModel->find($id);
        return $this->response->setJSON($data);
    }
}
