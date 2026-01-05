<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Tambah jenis bus jika belum ada
        $jenisBusData = [
            ['nama_jenisbus' => 'Big Bus'],
            ['nama_jenisbus' => 'Medium Bus'],
            ['nama_jenisbus' => 'Mini Bus'],
            ['nama_jenisbus' => 'Executive Bus'],
        ];

        foreach ($jenisBusData as $jenis) {
            $exists = $db->table('jenis_bus')->where('nama_jenisbus', $jenis['nama_jenisbus'])->get()->getRow();
            if (!$exists) {
                $db->table('jenis_bus')->insert($jenis);
                echo "Jenis bus '{$jenis['nama_jenisbus']}' ditambahkan.\n";
            }
        }

        // Ambil ID jenis bus
        $bigBus = $db->table('jenis_bus')->where('nama_jenisbus', 'Big Bus')->get()->getRow();
        $mediumBus = $db->table('jenis_bus')->where('nama_jenisbus', 'Medium Bus')->get()->getRow();
        $miniBus = $db->table('jenis_bus')->where('nama_jenisbus', 'Mini Bus')->get()->getRow();
        $execBus = $db->table('jenis_bus')->where('nama_jenisbus', 'Executive Bus')->get()->getRow();

        // Data 10 bus
        $busData = [
            [
                'nomor_polisi' => 'B 1234 ABC',
                'merek' => 'Mercedes-Benz OH 1626',
                'kapasitas' => '50',
                'id_jenisbus' => $bigBus->id,
            ],
            [
                'nomor_polisi' => 'B 5678 DEF',
                'merek' => 'Hino RK8',
                'kapasitas' => '45',
                'id_jenisbus' => $bigBus->id,
            ],
            [
                'nomor_polisi' => 'B 9012 GHI',
                'merek' => 'Scania K360',
                'kapasitas' => '55',
                'id_jenisbus' => $execBus->id,
            ],
            [
                'nomor_polisi' => 'D 3456 JKL',
                'merek' => 'Isuzu LT 134',
                'kapasitas' => '35',
                'id_jenisbus' => $mediumBus->id,
            ],
            [
                'nomor_polisi' => 'D 7890 MNO',
                'merek' => 'Mitsubishi FE 84',
                'kapasitas' => '30',
                'id_jenisbus' => $mediumBus->id,
            ],
            [
                'nomor_polisi' => 'F 1122 PQR',
                'merek' => 'Toyota Hiace',
                'kapasitas' => '15',
                'id_jenisbus' => $miniBus->id,
            ],
            [
                'nomor_polisi' => 'F 3344 STU',
                'merek' => 'Isuzu Elf NLR',
                'kapasitas' => '20',
                'id_jenisbus' => $miniBus->id,
            ],
            [
                'nomor_polisi' => 'B 5566 VWX',
                'merek' => 'Volvo B11R',
                'kapasitas' => '48',
                'id_jenisbus' => $execBus->id,
            ],
            [
                'nomor_polisi' => 'D 7788 YZA',
                'merek' => 'Hino AK8',
                'kapasitas' => '40',
                'id_jenisbus' => $bigBus->id,
            ],
            [
                'nomor_polisi' => 'B 9900 BCD',
                'merek' => 'Mercedes-Benz OF 917',
                'kapasitas' => '33',
                'id_jenisbus' => $mediumBus->id,
            ],
        ];

        foreach ($busData as $bus) {
            $exists = $db->table('bus')->where('nomor_polisi', $bus['nomor_polisi'])->get()->getRow();
            if (!$exists) {
                $db->table('bus')->insert($bus);
                echo "Bus '{$bus['nomor_polisi']} - {$bus['merek']}' ditambahkan.\n";
            } else {
                echo "Bus '{$bus['nomor_polisi']}' sudah ada.\n";
            }
        }

        echo "\nSeeder bus selesai!\n";
    }
}
