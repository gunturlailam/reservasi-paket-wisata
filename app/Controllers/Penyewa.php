<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenyewaModel;

class Penyewa extends BaseController
{
    protected $penyewaModel;

    public function __construct()
    {
        $this->penyewaModel = new PenyewaModel();
    }

    public function index()
    {
        $data['penyewa'] = $this->penyewaModel->findAll();
        return view('master/penyewa', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_penyewa' => $this->request->getPost('nama_penyewa'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telp' => $this->request->getPost('no_telp'),
            'email' => $this->request->getPost('email'),
        ];

        if ($id) {
            $this->penyewaModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->penyewaModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/penyewa');
    }

    public function delete($id)
    {
        $this->penyewaModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/penyewa');
    }

    public function getpenyewa($id)
    {
        $data = $this->penyewaModel->find($id);
        return $this->response->setJSON($data);
    }
}
