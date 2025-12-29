<?php

namespace App\Controllers;

use App\Models\PaketbusModel;
use App\Models\PaketwisataModel;

class Home extends BaseController
{
    protected $paketbusModel;
    protected $paketwisataModel;

    public function __construct()
    {
        $this->paketbusModel = new PaketbusModel();
        $this->paketwisataModel = new PaketwisataModel();
    }

    public function index()
    {
        // Ambil paket wisata untuk ditampilkan di landing page
        $paketWisata = $this->paketwisataModel->findAll();

        $data = [
            'title' => 'Wisata Bus - Pesan Paket Wisata Terbaik',
            'paketWisata' => $paketWisata,
        ];

        return view('landing', $data);
    }
}
