<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemesananModel;
use App\Models\PembayaranModel;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $pemesananModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $data = [
            'pembayaran' => $this->pembayaranModel->getAll(),
            'pemesanan' => $this->pemesananModel->getAll(),
        ];

        return view('transaksi/pembayaran', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'jumlah_bayar' => $this->request->getPost('jumlah_bayar'),
            'metode_bayar' => $this->request->getPost('metode_bayar'),
        ];

        if ($id) {
            $this->pembayaranModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->pembayaranModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pembayaran');
    }

    public function delete($id)
    {
        $this->pembayaranModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pembayaran');
    }

    public function getpembayaran($id)
    {
        $data = $this->pembayaranModel->find($id);
        return $this->response->setJSON($data);
    }
}
