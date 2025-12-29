<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemesananDetailModel;
use App\Models\PemesananModel;
use App\Models\PaketbusModel;
use App\Models\PaketwisataModel;

class PemesananDetail extends BaseController
{
    protected $detailModel;
    protected $pemesananModel;
    protected $paketbusModel;
    protected $paketwisataModel;

    public function __construct()
    {
        $this->detailModel = new PemesananDetailModel();
        $this->pemesananModel = new PemesananModel();
        $this->paketbusModel = new PaketbusModel();
        $this->paketwisataModel = new PaketwisataModel();
    }

    public function index()
    {
        $perPage = 10;
        $session = session();
        $isPenyewa = $session->get('user_role') === 'penyewa';
        $penyewaId = $session->get('user_id');

        $data = [
            'pemesanan_detail' => $isPenyewa
                ? $this->detailModel->getPagedByPenyewa($penyewaId, $perPage)
                : $this->detailModel->getPaged($perPage),
            'pager' => $this->detailModel->pager,
            'pemesanan' => $isPenyewa
                ? $this->pemesananModel->listByPenyewa($penyewaId)
                : $this->pemesananModel->getAll(),
            'isPenyewa' => $isPenyewa,
        ];

        return view('transaksi/pemesanan_detail', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $session = session();
        $isPenyewa = $session->get('user_role') === 'penyewa';
        $penyewaId = $session->get('user_id');
        $tanggalBerangkat = $this->request->getPost('tanggal_berangkat');
        $tanggalKembali = $this->request->getPost('tanggal_kembali');
        $idPemesanan = $this->request->getPost('id_pemesanan');

        // Validasi tanggal kembali harus setelah tanggal berangkat
        if (strtotime($tanggalKembali) <= strtotime($tanggalBerangkat)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal kembali harus setelah tanggal berangkat');
        }

        // Jika penyewa, pastikan pemesanan miliknya
        if ($isPenyewa) {
            $pemesanan = $this->pemesananModel->find($idPemesanan);
            if (! $pemesanan || (int) $pemesanan['id_penyewa'] !== (int) $penyewaId) {
                return redirect()->back()->withInput()->with('error', 'Tidak boleh mengubah detail pemesanan milik orang lain');
            }
        }

        // Validasi bus tidak boleh dipesan di jadwal yang sama
        if (!$this->isBusAvailable($idPemesanan, $tanggalBerangkat, $tanggalKembali, $id)) {
            return redirect()->back()->withInput()->with('error', 'Bus sudah dipesan untuk jadwal tersebut');
        }

        $data = [
            'id_pemesanan' => $idPemesanan,
            'tanggal_berangkat' => $tanggalBerangkat,
            'tanggal_kembali' => $tanggalKembali,
            'jumlah_penumpang' => $this->request->getPost('jumlah_penumpang'),
        ];

        if ($id) {
            $this->detailModel->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diperbarui');
        } else {
            $this->detailModel->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
        }

        // Sinkronkan total biaya pemesanan berdasarkan total penumpang
        $this->updateTotalBayarPemesanan($idPemesanan);

        return redirect()->to('/pemesanan-detail');
    }

    private function isBusAvailable($idPemesanan, $tanggalBerangkat, $tanggalKembali, $excludeId = null)
    {
        $db = \Config\Database::connect();

        // Ambil bus dari pemesanan yang akan disimpan
        $pemesanan = $this->pemesananModel->find($idPemesanan);
        if (!$pemesanan) {
            return false;
        }

        // Ambil id_bus dari paket_bus
        // Builder tidak memiliki method find(), pakai where + getRowArray
        $paketBus = $db->table('paket_bus')
            ->where('id', $pemesanan['id_paketbus'])
            ->get()
            ->getRowArray();
        if (!$paketBus) {
            return false;
        }

        $idBus = $paketBus['id_bus'];

        // Cek apakah bus sudah dipesan di jadwal yang sama
        $builder = $db->table('pemberangkatan')
            ->select('pemberangkatan.id')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemberangkatan.id_pemesanan', 'left')
            ->where('pemberangkatan.id_bus', $idBus)
            ->where('((pemesanan_detail.tanggal_berangkat <= "' . $tanggalKembali . '" AND pemesanan_detail.tanggal_kembali >= "' . $tanggalBerangkat . '"))');

        if ($excludeId) {
            $builder = $builder->where('pemesanan_detail.id !=', $excludeId);
        }

        return $builder->get()->getNumRows() === 0;
    }

    private function updateTotalBayarPemesanan($idPemesanan): void
    {
        // Hitung total penumpang untuk pemesanan ini
        $totalPenumpang = (int) ($this->detailModel
            ->selectSum('jumlah_penumpang')
            ->where('id_pemesanan', $idPemesanan)
            ->first()['jumlah_penumpang'] ?? 0);

        if ($totalPenumpang <= 0) {
            $this->pemesananModel->update($idPemesanan, ['total_bayar' => 0]);
            return;
        }

        // Ambil harga paket wisata yang terkait dengan paket bus pemesanan
        $pemesanan = $this->pemesananModel->find($idPemesanan);
        if (! $pemesanan || empty($pemesanan['id_paketbus'])) {
            return;
        }

        $paketBus = $this->paketbusModel->find($pemesanan['id_paketbus']);
        if (! $paketBus || empty($paketBus['id_paketwisata'])) {
            return;
        }

        $paketWisata = $this->paketwisataModel->find($paketBus['id_paketwisata']);
        $harga = (int) ($paketWisata['harga'] ?? 0);

        $totalBayar = $harga * $totalPenumpang;

        $this->pemesananModel->update($idPemesanan, ['total_bayar' => $totalBayar]);
    }

    public function delete($id)
    {
        $detail = $this->detailModel->find($id);
        $this->detailModel->delete($id);
        if ($detail && isset($detail['id_pemesanan'])) {
            $this->updateTotalBayarPemesanan($detail['id_pemesanan']);
        }
        session()->setFlashdata('success', 'Data berhasil dihapus!');
        return redirect()->to('/pemesanan-detail');
    }

    public function getpemesananDetail($id)
    {
        $data = $this->detailModel->find($id);
        return $this->response->setJSON($data);
    }
}