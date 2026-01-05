<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaketBusSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ambil semua paket wisata
        $paketWisata = $db->table('paket_wisata')->get()->getResultArray();

        // Ambil semua bus
        $buses = $db->table('bus')->get()->getResultArray();

        if (empty($paketWisata)) {
            echo "Tidak ada data paket wisata. Jalankan PaketWisataSeeder terlebih dahulu.\n";
            return;
        }

        if (empty($buses)) {
            echo "Tidak ada data bus. Jalankan BusSeeder terlebih dahulu.\n";
            return;
        }

        // Buat kombinasi paket bus (paket wisata + bus)
        $paketBusData = [];

        // Paket Bali dengan Big Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Bali'),
            'id_bus' => $this->getBusId($buses, 'B 1234 ABC'),
        ];

        // Paket Bali dengan Executive Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Bali'),
            'id_bus' => $this->getBusId($buses, 'B 9012 GHI'),
        ];

        // Paket Yogyakarta dengan Big Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Yogyakarta'),
            'id_bus' => $this->getBusId($buses, 'B 5678 DEF'),
        ];

        // Paket Yogyakarta dengan Medium Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Yogyakarta'),
            'id_bus' => $this->getBusId($buses, 'D 3456 JKL'),
        ];

        // Paket Bandung dengan Medium Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Bandung'),
            'id_bus' => $this->getBusId($buses, 'D 7890 MNO'),
        ];

        // Paket Bandung dengan Mini Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Bandung'),
            'id_bus' => $this->getBusId($buses, 'F 1122 PQR'),
        ];

        // Paket Malang dengan Big Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Malang'),
            'id_bus' => $this->getBusId($buses, 'D 7788 YZA'),
        ];

        // Paket Bromo dengan Mini Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Bromo'),
            'id_bus' => $this->getBusId($buses, 'F 3344 STU'),
        ];

        // Paket Pangandaran dengan Medium Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Pangandaran'),
            'id_bus' => $this->getBusId($buses, 'B 9900 BCD'),
        ];

        // Paket Dieng dengan Mini Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Dieng'),
            'id_bus' => $this->getBusId($buses, 'F 1122 PQR'),
        ];

        // Paket Lombok dengan Executive Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Wisata Lombok'),
            'id_bus' => $this->getBusId($buses, 'B 5566 VWX'),
        ];

        // Paket Study Tour Jakarta dengan Big Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Study Tour Jakarta'),
            'id_bus' => $this->getBusId($buses, 'B 1234 ABC'),
        ];

        // Paket Ziarah dengan Big Bus
        $paketBusData[] = [
            'id_paketwisata' => $this->getPaketId($paketWisata, 'Paket Ziarah Wali Songo'),
            'id_bus' => $this->getBusId($buses, 'B 5678 DEF'),
        ];

        foreach ($paketBusData as $paketBus) {
            if ($paketBus['id_paketwisata'] && $paketBus['id_bus']) {
                $exists = $db->table('paket_bus')
                    ->where('id_paketwisata', $paketBus['id_paketwisata'])
                    ->where('id_bus', $paketBus['id_bus'])
                    ->get()->getRow();

                if (!$exists) {
                    $db->table('paket_bus')->insert($paketBus);
                    echo "Paket bus (Wisata ID: {$paketBus['id_paketwisata']}, Bus ID: {$paketBus['id_bus']}) ditambahkan.\n";
                } else {
                    echo "Paket bus sudah ada.\n";
                }
            }
        }

        echo "\nSeeder paket bus selesai!\n";
    }

    private function getPaketId($paketWisata, $namaPaket)
    {
        foreach ($paketWisata as $paket) {
            if ($paket['nama_paket'] === $namaPaket) {
                return $paket['id'];
            }
        }
        return null;
    }

    private function getBusId($buses, $nomorPolisi)
    {
        foreach ($buses as $bus) {
            if ($bus['nomor_polisi'] === $nomorPolisi) {
                return $bus['id'];
            }
        }
        return null;
    }
}
