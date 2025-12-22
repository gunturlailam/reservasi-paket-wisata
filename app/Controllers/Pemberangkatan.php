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

        $data = [
            'pemberangkatan' => $this->pemberangkatanModel->getAll(),
            'pemesanan' => $this->pemesananModel->findAll(),
            'bus' => $this->busModel->findAll(),
            'karyawan' => $this->karyawanModel->findAll(),
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

    public function getpemberangkatan($id)
    {
        $data = $this->pemberangkatanModel->find($id);
        return $this->response->setJSON($data);
    }
}
