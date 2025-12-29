<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemesananModel;
use App\Models\PemesananDetailModel;
use App\Models\PaketwisataModel;
use App\Models\PenyewaModel;
use App\Models\PaketbusModel;

class Pemesanan extends BaseController
{
    protected $pemesananModel;
    protected $pemesananDetailModel;
    protected $penyewaModel;
    protected $paketwisataModel;
    protected $paketbusModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->pemesananDetailModel = new PemesananDetailModel();
        $this->penyewaModel = new PenyewaModel();
        $this->paketwisataModel = new PaketwisataModel();
        $this->paketbusModel = new PaketbusModel();
    }

    public function index()
    {
        $perPage = 10;
        $session = session();
        $isPenyewa = $session->get('user_role') === 'penyewa';
        $penyewaId = $session->get('user_id');

        $data = [
            // Penyewa kini bisa melihat seluruh data pemesanan
            'pemesanan' => $this->pemesananModel->getPaged($perPage),
            'pager' => $this->pemesananModel->pager,
            'penyewa' => $isPenyewa ? [] : $this->penyewaModel->findAll(),
            'paketbus' => $this->paketbusModel->getAll(),
            'isPenyewa' => $isPenyewa,
        ];

        return view('transaksi/pemesanan', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $session = session();
        $isPenyewa = $session->get('user_role') === 'penyewa';
        $penyewaId = $isPenyewa ? $session->get('user_id') : $this->request->getPost('id_penyewa');

        $tanggalBerangkat = $this->request->getPost('tanggal_berangkat');
        $tanggalKembali   = $this->request->getPost('tanggal_kembali');
        $jumlahPenumpang  = (int) $this->request->getPost('jumlah_penumpang');

        // Validasi dasar
        if ($jumlahPenumpang <= 0) {
            return redirect()->back()->withInput()->with('error', 'Jumlah penumpang harus lebih dari 0');
        }

        if (! $this->isValidDateRange($tanggalBerangkat, $tanggalKembali)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal kembali harus setelah tanggal berangkat');
        }

        $totalBayar = $this->calculateTotalBayar(
            $this->request->getPost('id_paketbus'),
            $jumlahPenumpang,
            $tanggalBerangkat,
            $tanggalKembali
        );

        $data = [
            'tanggal_pesan' => $this->request->getPost('tanggal_pesan'),
            'id_penyewa' => $penyewaId,
            'id_paketbus' => $this->request->getPost('id_paketbus'),
            'total_bayar' => $totalBayar,
        ];

        if ($id) {
            // Update pemesanan
            $this->pemesananModel->update($id, $data);

            // Update atau insert pemesanan_detail
            $existingDetail = $this->pemesananDetailModel->where('id_pemesanan', $id)->first();
            $detailData = [
                'id_pemesanan' => $id,
                'tanggal_berangkat' => $tanggalBerangkat,
                'tanggal_kembali' => $tanggalKembali,
                'jumlah_penumpang' => $jumlahPenumpang,
            ];

            if ($existingDetail) {
                $this->pemesananDetailModel->update($existingDetail['id'], $detailData);
            } else {
                $this->pemesananDetailModel->insert($detailData);
            }

            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            // Insert pemesanan baru
            $pemesananId = $this->pemesananModel->insert($data);

            // Insert pemesanan_detail
            $detailData = [
                'id_pemesanan' => $pemesananId,
                'tanggal_berangkat' => $tanggalBerangkat,
                'tanggal_kembali' => $tanggalKembali,
                'jumlah_penumpang' => $jumlahPenumpang,
            ];
            $this->pemesananDetailModel->insert($detailData);

            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        return redirect()->to('/pemesanan');
    }

    private function calculateHargaPaket($idPaketBus): int
    {
        if (! $idPaketBus) {
            return 0;
        }

        $paketBus = $this->paketbusModel->find($idPaketBus);
        if (! $paketBus || empty($paketBus['id_paketwisata'])) {
            return 0;
        }

        $paketWisata = $this->paketwisataModel->find($paketBus['id_paketwisata']);

        return (int) ($paketWisata['harga'] ?? 0);
    }

    private function calculateTotalBayar($idPaketBus, int $jumlahPenumpang, $tanggalBerangkat, $tanggalKembali): int
    {
        $hargaPerPaket = $this->calculateHargaPaket($idPaketBus);

        $durasiHari = $this->hitungDurasiHari($tanggalBerangkat, $tanggalKembali);
        if ($durasiHari <= 0) {
            return 0;
        }

        return $hargaPerPaket * max(0, $jumlahPenumpang) * $durasiHari;
    }

    private function hitungDurasiHari($tanggalBerangkat, $tanggalKembali): int
    {
        $start = strtotime($tanggalBerangkat);
        $end   = strtotime($tanggalKembali);

        if (! $start || ! $end || $end <= $start) {
            return 0;
        }

        // Durasi minimal 1 hari
        $days = (int) ceil(($end - $start) / 86400);
        return max(1, $days);
    }

    private function isValidDateRange($tanggalBerangkat, $tanggalKembali): bool
    {
        $start = strtotime($tanggalBerangkat);
        $end   = strtotime($tanggalKembali);

        return $start && $end && $end > $start;
    }

    public function delete($id)
    {
        // Hapus pemesanan_detail dulu
        $this->pemesananDetailModel->where('id_pemesanan', $id)->delete();
        // Hapus pemesanan
        $this->pemesananModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemesanan');
    }

    public function getpemesanan($id)
    {
        $data = $this->pemesananModel->find($id);
        return $this->response->setJSON($data);
    }

    public function laporan()
    {
        $data = [
            'pemesanan' => $this->pemesananModel->getAll(),
            'title' => 'Laporan Data Pemesanan'
        ];

        return view('laporan/laporan_pemesanan', $data);
    }
}
