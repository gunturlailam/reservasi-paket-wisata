<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemesananModel;
use App\Models\PenyewaModel;
use App\Models\PaketbusModel;

class Pemesanan extends BaseController
{
    protected $pemesananModel;
    protected $penyewaModel;
    protected $paketbusModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->penyewaModel = new PenyewaModel();
        $this->paketbusModel = new PaketbusModel();
    }

    public function index()
    {
        $data = [
            'pemesanan' => $this->pemesananModel->getAll(),
            'penyewa' => $this->penyewaModel->findAll(),
            'paketbus' => $this->paketbusModel->getAll(),
        ];

        return view('transaksi/pemesanan', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'tanggal_pesan' => $this->request->getPost('tanggal_pesan'),
            'id_penyewa' => $this->request->getPost('id_penyewa'),
            'id_paketbus' => $this->request->getPost('id_paketbus'),
            'total_bayar' => $this->request->getPost('total_bayar'),
        ];

        if ($id) {
            $this->pemesananModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->pemesananModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pemesanan');
    }

    public function delete($id)
    {
        $this->pemesananModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemesanan');
    }

    public function getpemesanan($id)
    {
        $data = $this->pemesananModel->find($id);
        return $this->response->setJSON($data);
    }
}
