<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah jabatan Kernet sudah ada
        $db = \Config\Database::connect();
        $existing = $db->table('jabatan')->where('nama_jabatan', 'Kernet')->get()->getRow();

        if (!$existing) {
            $data = [
                'nama_jabatan' => 'Kernet'
            ];

            $db->table('jabatan')->insert($data);
            echo "Jabatan 'Kernet' berhasil ditambahkan.\n";
        } else {
            echo "Jabatan 'Kernet' sudah ada.\n";
        }
    }
}
