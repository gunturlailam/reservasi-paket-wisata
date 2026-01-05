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
        $session = session();
        $userRole = $session->get('user_role');
        $userId = $session->get('user_id');

        // Filter karyawan berdasarkan jabatan
        $sopir = $this->karyawanModel
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Sopir')
            ->findAll();

        $kernet = $this->karyawanModel
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Kernet')
            ->findAll();

        // Ambil data reservasi dengan join ke pembayaran dan pemberangkatan
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, 
            paket_wisata.nama_paket, 
            paket_wisata.tujuan,
            pemesanan_detail.tanggal_berangkat,
            pemesanan_detail.tanggal_kembali,
            pembayaran.id as pembayaran_id,
            pemberangkatan.id as pemberangkatan_id,
            bus.id as id_bus,
            bus.nomor_polisi,
            bus.merek');
        $builder->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left');
        $builder->join('bus', 'bus.id = paket_bus.id_bus', 'left');
        $builder->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left');
        $builder->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id', 'left');
        $builder->join('pembayaran', 'pembayaran.id_pemesanan = pemesanan.id', 'left');
        $builder->join('pemberangkatan', 'pemberangkatan.id_pemesanan = pemesanan.id', 'left');

        // Jika penyewa, filter berdasarkan id_penyewa
        if ($userRole === 'penyewa' && $userId) {
            $builder->where('pemesanan.id_penyewa', $userId);
        }

        $builder->orderBy('pemesanan.id', 'DESC');
        $reservasi = $builder->get()->getResultArray();

        $data = [
            'pemberangkatan' => $this->pemberangkatanModel->getAll(),
            'pemesanan' => $this->pemesananModel->findAll(),
            'bus' => $this->busModel->findAll(),
            'karyawan' => $this->karyawanModel->findAll(),
            'sopir' => $sopir,
            'kernet' => $kernet,
            'reservasi' => $reservasi,
            'userRole' => $userRole,
        ];

        return view('transaksi/pemberangkatan', $data);
    }

    public function create()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa tambah
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk menambah data');
        }

        $data = [
            'pemesanan' => $this->pemesananModel->findAll(),
            'bus' => $this->busModel->findAll(),
            'karyawan' => $this->karyawanModel->findAll(),
        ];

        return view('transaksi/pemberangkatan/create', $data);
    }

    public function store()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa simpan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk menambah data');
        }

        $rules = [
            'id_pemesanan' => 'required|numeric',
            'id_bus' => 'required|numeric',
            'id_sopir' => 'required|numeric',
            'id_kernet' => 'required|numeric',
            'tanggal_berangkat' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pemberangkatanModel->insert([
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'id_bus' => $this->request->getPost('id_bus'),
            'id_sopir' => $this->request->getPost('id_sopir'),
            'id_kernet' => $this->request->getPost('id_kernet'),
            'tanggal_berangkat' => $this->request->getPost('tanggal_berangkat'),
        ]);

        return redirect()->to('/pemberangkatan')->with('success', 'Data pemberangkatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa edit
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk edit data');
        }

        $data = [
            'pemberangkatan' => $this->pemberangkatanModel->find($id),
            'pemesanan' => $this->pemesananModel->findAll(),
            'bus' => $this->busModel->findAll(),
            'karyawan' => $this->karyawanModel->findAll(),
        ];

        if (!$data['pemberangkatan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pemberangkatan tidak ditemukan');
        }

        return view('transaksi/pemberangkatan/edit', $data);
    }

    public function update($id)
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa update
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk edit data');
        }

        $rules = [
            'id_pemesanan' => 'required|numeric',
            'id_bus' => 'required|numeric',
            'id_sopir' => 'required|numeric',
            'id_kernet' => 'required|numeric',
            'tanggal_berangkat' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pemberangkatanModel->update($id, [
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'id_bus' => $this->request->getPost('id_bus'),
            'id_sopir' => $this->request->getPost('id_sopir'),
            'id_kernet' => $this->request->getPost('id_kernet'),
            'tanggal_berangkat' => $this->request->getPost('tanggal_berangkat'),
        ]);

        return redirect()->to('/pemberangkatan')->with('success', 'Data pemberangkatan berhasil diperbarui');
    }

    public function delete($id)
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa hapus
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk hapus data');
        }

        $this->pemberangkatanModel->delete($id);
        return redirect()->to('/pemberangkatan')->with('success', 'Data pemberangkatan berhasil dihapus');
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $idBus = $this->request->getPost('id_bus');
        $idSopir = $this->request->getPost('id_sopir');
        $idKernet = $this->request->getPost('id_kernet');
        $tanggal = $this->request->getPost('tanggal_berangkat');

        // Validasi ketersediaan bus
        if (!$this->pemberangkatanModel->isBusAvailable($idBus, $tanggal, $id)) {
            session()->setFlashdata('error', 'Bus sudah digunakan pada tanggal tersebut!');
            return redirect()->back()->withInput();
        }

        // Validasi ketersediaan sopir
        if (!$this->pemberangkatanModel->isSopirAvailable($idSopir, $tanggal, $id)) {
            session()->setFlashdata('error', 'Sopir sudah bertugas pada tanggal tersebut!');
            return redirect()->back()->withInput();
        }

        // Validasi ketersediaan kernet
        if (!$this->pemberangkatanModel->isKernetAvailable($idKernet, $tanggal, $id)) {
            session()->setFlashdata('error', 'Kernet sudah bertugas pada tanggal tersebut!');
            return redirect()->back()->withInput();
        }

        // Validasi sopir dan kernet tidak boleh sama
        if ($idSopir == $idKernet) {
            session()->setFlashdata('error', 'Sopir dan Kernet tidak boleh orang yang sama!');
            return redirect()->back()->withInput();
        }

        $data = [
            'id_pemesanan' => $this->request->getPost('id_pemesanan'),
            'id_bus' => $idBus,
            'id_sopir' => $idSopir,
            'id_kernet' => $idKernet,
            'tanggal_berangkat' => $tanggal,
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

    /**
     * AJAX endpoint untuk cek ketersediaan berdasarkan tanggal
     */
    public function cekKetersediaan()
    {
        $tanggal = $this->request->getGet('tanggal');
        $excludeId = $this->request->getGet('exclude_id');

        if (!$tanggal) {
            return $this->response->setJSON(['error' => 'Tanggal diperlukan']);
        }

        $unavailableBus = $this->pemberangkatanModel->getUnavailableBus($tanggal, $excludeId);
        $unavailableSopir = $this->pemberangkatanModel->getUnavailableSopir($tanggal, $excludeId);
        $unavailableKernet = $this->pemberangkatanModel->getUnavailableKernet($tanggal, $excludeId);

        return $this->response->setJSON([
            'unavailable_bus' => $unavailableBus,
            'unavailable_sopir' => $unavailableSopir,
            'unavailable_kernet' => $unavailableKernet,
        ]);
    }

    public function getpemberangkatan($id)
    {
        $data = $this->pemberangkatanModel->find($id);
        return $this->response->setJSON($data);
    }

    /**
     * Cetak Surat Jalan Keberangkatan
     */
    public function cetak($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemberangkatan');
        $builder->select('pemberangkatan.*, 
            pemesanan.id as kode_pemesanan,
            pemesanan.tanggal_pesan,
            pemesanan.total_bayar,
            penyewa.nama_penyewa,
            penyewa.alamat as alamat_penyewa,
            penyewa.no_telp as nohp_penyewa,
            bus.nomor_polisi,
            bus.merek,
            bus.kapasitas,
            sopir.nama_karyawan as nama_sopir,
            kernet.nama_karyawan as nama_kernet,
            paket_wisata.nama_paket,
            paket_wisata.tujuan,
            pemesanan_detail.tanggal_berangkat as tgl_berangkat_detail,
            pemesanan_detail.tanggal_kembali');
        $builder->join('pemesanan', 'pemesanan.id = pemberangkatan.id_pemesanan', 'left');
        $builder->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left');
        $builder->join('bus', 'bus.id = pemberangkatan.id_bus', 'left');
        $builder->join('karyawan as sopir', 'sopir.id = pemberangkatan.id_sopir', 'left');
        $builder->join('karyawan as kernet', 'kernet.id = pemberangkatan.id_kernet', 'left');
        $builder->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left');
        $builder->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left');
        $builder->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id', 'left');
        $builder->where('pemberangkatan.id', $id);

        $pemberangkatan = $builder->get()->getRowArray();

        if (!$pemberangkatan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pemberangkatan tidak ditemukan');
        }

        $data = [
            'pemberangkatan' => $pemberangkatan
        ];

        return view('transaksi/pemberangkatan_cetak', $data);
    }

    /**
     * Laporan Perjalanan Berdasarkan Tujuan
     */
    public function laporanTujuan()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa akses laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses ke laporan');
        }

        // Ambil filter tujuan dari GET parameter
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan
        $laporan = $this->pemberangkatanModel->getLaporanByTujuan($tujuan);

        // Ambil daftar tujuan untuk dropdown filter
        $daftarTujuan = $this->pemberangkatanModel->getDaftarTujuan();

        $data = [
            'laporan' => $laporan,
            'daftarTujuan' => $daftarTujuan,
            'tujuanTerpilih' => $tujuan,
            'totalData' => count($laporan),
        ];

        return view('laporan/v_laporan_tujuan', $data);
    }

    /**
     * Cetak Laporan Perjalanan Berdasarkan Tujuan
     */
    public function cetakLaporanTujuan()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa cetak laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk cetak laporan');
        }

        // Ambil filter tujuan dari GET parameter
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan
        $laporan = $this->pemberangkatanModel->getLaporanByTujuan($tujuan);

        $data = [
            'laporan' => $laporan,
            'tujuanTerpilih' => $tujuan,
            'tanggalCetak' => date('d-m-Y H:i:s'),
        ];

        return view('laporan/v_laporan_tujuan_cetak', $data);
    }

    /**
     * Laporan Perjalanan Berdasarkan Periode
     */
    public function laporanPeriode()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa akses laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses ke laporan');
        }

        // Ambil filter dari GET parameter
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai');
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan berdasarkan periode
        $laporan = $this->pemberangkatanModel->getLaporanByPeriode($tanggalMulai, $tanggalSelesai, $tujuan);

        // Ambil daftar tujuan untuk dropdown filter
        $daftarTujuan = $this->pemberangkatanModel->getDaftarTujuan();

        $data = [
            'laporan' => $laporan,
            'daftarTujuan' => $daftarTujuan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'tujuanTerpilih' => $tujuan,
            'totalData' => count($laporan),
        ];

        return view('laporan/v_laporan_periode', $data);
    }

    /**
     * Cetak Laporan Perjalanan Berdasarkan Periode
     */
    public function cetakLaporanPeriode()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa cetak laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses untuk cetak laporan');
        }

        // Ambil filter dari GET parameter
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai');
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan berdasarkan periode
        $laporan = $this->pemberangkatanModel->getLaporanByPeriode($tanggalMulai, $tanggalSelesai, $tujuan);

        $data = [
            'laporan' => $laporan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'tujuanTerpilih' => $tujuan,
            'tanggalCetak' => date('d-m-Y H:i:s'),
        ];

        return view('laporan/v_laporan_periode_cetak', $data);
    }

    public function laporan()
    {
        $model = new \App\Models\PemberangkatanModel();

        $tujuanSelected = $this->request->getGet('tujuan');
        $tglAwal       = $this->request->getGet('tgl_awal');
        $tglAkhir      = $this->request->getGet('tgl_akhir');

        $laporan = $model->getLaporanByPeriodeTujuan($tujuanSelected, $tglAwal, $tglAkhir);

        $data = [
            'daftarTujuan'   => $model->getDaftarTujuan(),
            'tujuanTerpilih' => $tujuanSelected,
            'tgl_awal'       => $tglAwal,
            'tgl_akhir'      => $tglAkhir,
            'laporan'        => $laporan,
            'totalData'      => count($laporan),
        ];

        return view('laporan/v_laporan_periode', $data);
    }

    /**
     * Laporan Perjalanan Berdasarkan Tujuan - Terintegrasi dengan Main Template
     */
    public function laporanTujuanMain()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa akses laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses ke laporan');
        }

        // Ambil filter tujuan dari GET parameter
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan
        $laporan = $this->pemberangkatanModel->getLaporanByTujuan($tujuan);

        // Ambil daftar tujuan untuk dropdown filter
        $daftarTujuan = $this->pemberangkatanModel->getDaftarTujuan();

        $data = [
            'laporan' => $laporan,
            'daftarTujuan' => $daftarTujuan,
            'tujuanTerpilih' => $tujuan,
            'totalData' => count($laporan),
        ];

        return view('laporan/laporan_tujuan_main', $data);
    }

    /**
     * Laporan Perjalanan Berdasarkan Periode - Terintegrasi dengan Main Template
     */
    public function laporanPeriodeMain()
    {
        $session = session();
        $userRole = $session->get('user_role');

        // Hanya admin dan karyawan yang bisa akses laporan
        if ($userRole !== 'admin' && $userRole !== 'karyawan') {
            return redirect()->to('/pemberangkatan')->with('error', 'Anda tidak memiliki akses ke laporan');
        }

        // Ambil filter dari GET parameter
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai');
        $tujuan = $this->request->getGet('tujuan');

        // Ambil data laporan berdasarkan periode
        $laporan = $this->pemberangkatanModel->getLaporanByPeriode($tanggalMulai, $tanggalSelesai, $tujuan);

        // Ambil daftar tujuan untuk dropdown filter
        $daftarTujuan = $this->pemberangkatanModel->getDaftarTujuan();

        $data = [
            'laporan' => $laporan,
            'daftarTujuan' => $daftarTujuan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'tujuanTerpilih' => $tujuan,
            'totalData' => count($laporan),
        ];

        return view('laporan/laporan_periode_main', $data);
    }
}
