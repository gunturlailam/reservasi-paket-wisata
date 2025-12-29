<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\PemesananModel;
use App\Models\PemesananDetailModel;
use App\Models\PenyewaModel;
use App\Models\PaketbusModel;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $pemesananModel;
    protected $pemesananDetailModel;
    protected $penyewaModel;
    protected $paketbusModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->pemesananModel = new PemesananModel();
        $this->pemesananDetailModel = new PemesananDetailModel();
        $this->penyewaModel = new PenyewaModel();
        $this->paketbusModel = new PaketbusModel();
    }

    public function index()
    {
        $pemesananData = $this->pembayaranModel->getPemesananBelumBayar();

        $data = [
            'title' => 'Daftar Reservasi Bus',
            'pembayaran' => $this->pembayaranModel->getPembayaranList(),
            'pemesanan' => $pemesananData,
        ];

        return view('transaksi/pembayaran', $data);
    }

    public function debug()
    {
        $pemesananData = $this->pembayaranModel->getPemesananBelumBayar();
        header('Content-Type: application/json');
        echo json_encode($pemesananData, JSON_PRETTY_PRINT);
        die();
    }

    public function tambah()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
        }

        $id_pemesanan = $this->request->getPost('id_pemesanan');
        $metode_bayar = $this->request->getPost('metode_bayar');
        $jumlah_bayar = $this->request->getPost('jumlah_bayar');
        $tanggal_bayar = $this->request->getPost('tanggal_bayar');

        // Validasi input
        if (empty($id_pemesanan) || empty($metode_bayar) || empty($jumlah_bayar)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Semua field wajib diisi']);
        }

        // Validasi pemesanan ada
        $pemesanan = $this->pemesananModel->find($id_pemesanan);
        if (!$pemesanan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pemesanan tidak ditemukan']);
        }

        // Cek apakah sudah ada pembayaran untuk pemesanan ini
        $cekPembayaran = $this->pembayaranModel->where('id_pemesanan', $id_pemesanan)->first();
        if ($cekPembayaran) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pembayaran untuk pemesanan ini sudah ada']);
        }

        // Cek apakah pemesanan_detail ada, jika tidak buat
        $cekDetail = $this->pemesananDetailModel->where('id_pemesanan', $id_pemesanan)->first();
        if (!$cekDetail) {
            $dataDetail = [
                'id_pemesanan' => $id_pemesanan,
                'tanggal_berangkat' => date('Y-m-d', strtotime('+1 day')),
                'tanggal_kembali' => date('Y-m-d', strtotime('+3 day')),
                'jumlah_penumpang' => 1,
            ];
            $this->pemesananDetailModel->insert($dataDetail);
        }

        // Buat pembayaran baru
        $dataPembayaran = [
            'id_pemesanan' => (int)$id_pemesanan,
            'tanggal_bayar' => !empty($tanggal_bayar) ? $tanggal_bayar : null,
            'jumlah_bayar' => (int)$jumlah_bayar,
            'metode_bayar' => $metode_bayar,
        ];

        try {
            $result = $this->pembayaranModel->insert($dataPembayaran);

            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Pembayaran berhasil ditambahkan']);
            }

            $errors = $this->pembayaranModel->errors();
            $errorMsg = is_array($errors) ? implode(', ', $errors) : $errors;
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan pembayaran: ' . $errorMsg]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function save()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $id_pemesanan = $this->request->getPost('id_pemesanan');
        $tanggal_bayar = $this->request->getPost('tanggal_bayar');
        $jumlah_bayar = $this->request->getPost('jumlah_bayar');
        $metode_bayar = $this->request->getPost('metode_bayar');

        // Validasi pemesanan ada
        $pemesanan = $this->pemesananModel->find($id_pemesanan);
        if (!$pemesanan) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan');
        }

        $data = [
            'id_pemesanan' => $id_pemesanan,
            'tanggal_bayar' => $tanggal_bayar,
            'jumlah_bayar' => str_replace('.', '', $jumlah_bayar),
            'metode_bayar' => $metode_bayar,
        ];

        if ($this->pembayaranModel->save($data)) {
            return redirect()->to('/pembayaran')->with('success', 'Pembayaran berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan pembayaran');
    }

    public function detail($id)
    {
        $pembayaran = $this->pembayaranModel->getPembayaranDetail($id);

        if (!$pembayaran) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan'])->setStatusCode(404);
        }

        return $this->response->setJSON($pembayaran);
    }

    public function delete($id)
    {
        if ($this->pembayaranModel->delete($id)) {
            return redirect()->to('/pembayaran')->with('success', 'Pembayaran berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus pembayaran');
    }

    public function proses($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan');
        }

        // Update tanggal bayar
        if ($this->pembayaranModel->update($id, ['tanggal_bayar' => date('Y-m-d')])) {
            return redirect()->to('/pembayaran')->with('success', 'Pembayaran berhasil dikonfirmasi');
        }

        return redirect()->back()->with('error', 'Gagal memproses pembayaran');
    }

    public function konfirmasi()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $id = $this->request->getPost('id');
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pembayaran tidak ditemukan']);
        }

        $data = ['tanggal_bayar' => date('Y-m-d')];

        // Handle upload bukti bayar jika bukan tunai
        if ($pembayaran['metode_bayar'] !== 'Tunai') {
            $bukti = $this->request->getFile('bukti_bayar');

            if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
                $newName = $bukti->getRandomName();
                $bukti->move('uploads/bukti_bayar', $newName);
                $data['bukti_bayar'] = $newName;
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Bukti pembayaran wajib diupload untuk metode ' . $pembayaran['metode_bayar']]);
            }
        }

        if ($this->pembayaranModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengkonfirmasi pembayaran']);
    }
}
