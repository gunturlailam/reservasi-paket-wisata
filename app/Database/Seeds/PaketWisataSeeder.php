<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaketWisataSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Data paket wisata
        $paketWisataData = [
            [
                'nama_paket' => 'Paket Wisata Bali',
                'tujuan' => 'Bali',
                'harga' => 150000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Yogyakarta',
                'tujuan' => 'Yogyakarta',
                'harga' => 100000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Bandung',
                'tujuan' => 'Bandung',
                'harga' => 75000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Malang',
                'tujuan' => 'Malang',
                'harga' => 85000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Bromo',
                'tujuan' => 'Gunung Bromo',
                'harga' => 125000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Pangandaran',
                'tujuan' => 'Pangandaran',
                'harga' => 90000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Dieng',
                'tujuan' => 'Dieng Plateau',
                'harga' => 95000.00,
            ],
            [
                'nama_paket' => 'Paket Wisata Lombok',
                'tujuan' => 'Lombok',
                'harga' => 175000.00,
            ],
            [
                'nama_paket' => 'Paket Study Tour Jakarta',
                'tujuan' => 'Jakarta',
                'harga' => 80000.00,
            ],
            [
                'nama_paket' => 'Paket Ziarah Wali Songo',
                'tujuan' => 'Jawa Timur - Jawa Tengah',
                'harga' => 110000.00,
            ],
        ];

        foreach ($paketWisataData as $paket) {
            $exists = $db->table('paket_wisata')->where('nama_paket', $paket['nama_paket'])->get()->getRow();
            if (!$exists) {
                $db->table('paket_wisata')->insert($paket);
                echo "Paket wisata '{$paket['nama_paket']}' ditambahkan.\n";
            } else {
                echo "Paket wisata '{$paket['nama_paket']}' sudah ada.\n";
            }
        }

        echo "\nSeeder paket wisata selesai!\n";
    }
}
