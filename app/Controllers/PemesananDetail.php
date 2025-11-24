<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemesananDetailModel;
use App\Models\PemesananModel;

class PemesananDetail extends BaseController
{
    protected $detailModel;
    protected $pemesananModel;

    public function __construct()
    {
        $this->detailModel = new PemesananDetailModel();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $data = [
            'pemesanan_detail' => $this->detailModel->getAll(),
            'pemesanan' => $this->pemesananModel->getAll(),
        ];

        return view('master/pemesanan_detail', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'tanggal_berangkat' => $this->request->getPost('tanggal_berangkat'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'jumlah_penumpang' => $this->request->getPost('jumlah_penumpang'),
        ];

        if ($id) {
            $this->detailModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->detailModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pemesanan-detail');
    }

    public function delete($id)
    {
        $this->detailModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemesanan-detail');
    }

    public function getpemesananDetail($id)
    {
        $data = $this->detailModel->find($id);
        return $this->response->setJSON($data);
    }
}
