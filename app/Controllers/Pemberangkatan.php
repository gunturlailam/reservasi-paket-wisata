<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BusModel;
use App\Models\KaryawanModel;
use App\Models\PemberangkatanModel;
use App\Models\PemesananModel;

class Pemberangkatan extends BaseController
{
    protected $pemberangkatanModel;
    protected $pemesananModel;
    protected $busModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->pemberangkatanModel = new PemberangkatanModel();
        $this->pemesananModel = new PemesananModel();
        $this->busModel = new BusModel();
        $this->karyawanModel = new KaryawanModel();
    }

    public function index()
    {
        $data = [
            'pemberangkatan' => $this->pemberangkatanModel->getAll(),
            'pemesanan' => $this->pemesananModel->findAll(),
            'bus' => $this->busModel->findAll(),
            'karyawan' => $this->karyawanModel->findAll(),
        ];

        return view('master/pemberangkatan', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'id_bus' => $this->request->getPost('id_bus'),
            'id_sopir' => $this->request->getPost('id_sopir'),
            'id_kernet' => $this->request->getPost('id_kernet'),
            'tanggal_berangkat' => $this->request->getPost('tanggal_berangkat'),
        ];

        if ($id) {
            $this->pemberangkatanModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->pemberangkatanModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pemberangkatan');
    }

    public function delete($id)
    {
        $this->pemberangkatanModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemberangkatan');
    }

    public function getpemberangkatan($id)
    {
        $data = $this->pemberangkatanModel->find($id);
        return $this->response->setJSON($data);
    }
}
