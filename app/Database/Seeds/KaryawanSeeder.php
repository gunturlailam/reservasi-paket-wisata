<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Pastikan jabatan Sopir dan Kernet ada
        $jabatanSopir = $db->table('jabatan')->where('nama_jabatan', 'Sopir')->get()->getRow();
        $jabatanKernet = $db->table('jabatan')->where('nama_jabatan', 'Kernet')->get()->getRow();

        if (!$jabatanSopir) {
            $db->table('jabatan')->insert(['nama_jabatan' => 'Sopir']);
            $jabatanSopir = $db->table('jabatan')->where('nama_jabatan', 'Sopir')->get()->getRow();
            echo "Jabatan 'Sopir' ditambahkan.\n";
        }

        if (!$jabatanKernet) {
            $db->table('jabatan')->insert(['nama_jabatan' => 'Kernet']);
            $jabatanKernet = $db->table('jabatan')->where('nama_jabatan', 'Kernet')->get()->getRow();
            echo "Jabatan 'Kernet' ditambahkan.\n";
        }

        // Data Sopir (5 orang)
        $sopirData = [
            [
                'nama_karyawan' => 'Ahmad Supardi',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'nohp' => '081234567001',
                'id_jabatan' => $jabatanSopir->id,
                'email' => 'ahmad.supardi@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Budi Santoso',
                'alamat' => 'Jl. Sudirman No. 25, Bandung',
                'nohp' => '081234567002',
                'id_jabatan' => $jabatanSopir->id,
                'email' => 'budi.santoso@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Cahyo Wibowo',
                'alamat' => 'Jl. Diponegoro No. 15, Semarang',
                'nohp' => '081234567003',
                'id_jabatan' => $jabatanSopir->id,
                'email' => 'cahyo.wibowo@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Dedi Kurniawan',
                'alamat' => 'Jl. Ahmad Yani No. 30, Surabaya',
                'nohp' => '081234567004',
                'id_jabatan' => $jabatanSopir->id,
                'email' => 'dedi.kurniawan@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Eko Prasetyo',
                'alamat' => 'Jl. Gatot Subroto No. 45, Yogyakarta',
                'nohp' => '081234567005',
                'id_jabatan' => $jabatanSopir->id,
                'email' => 'eko.prasetyo@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
        ];

        // Data Kernet (5 orang)
        $kernetData = [
            [
                'nama_karyawan' => 'Fajar Nugroho',
                'alamat' => 'Jl. Pahlawan No. 5, Jakarta',
                'nohp' => '081234567011',
                'id_jabatan' => $jabatanKernet->id,
                'email' => 'fajar.nugroho@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Gilang Ramadhan',
                'alamat' => 'Jl. Veteran No. 12, Bandung',
                'nohp' => '081234567012',
                'id_jabatan' => $jabatanKernet->id,
                'email' => 'gilang.ramadhan@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Hendra Wijaya',
                'alamat' => 'Jl. Pemuda No. 20, Semarang',
                'nohp' => '081234567013',
                'id_jabatan' => $jabatanKernet->id,
                'email' => 'hendra.wijaya@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Irfan Hakim',
                'alamat' => 'Jl. Kartini No. 8, Surabaya',
                'nohp' => '081234567014',
                'id_jabatan' => $jabatanKernet->id,
                'email' => 'irfan.hakim@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'nama_karyawan' => 'Joko Susilo',
                'alamat' => 'Jl. Malioboro No. 50, Yogyakarta',
                'nohp' => '081234567015',
                'id_jabatan' => $jabatanKernet->id,
                'email' => 'joko.susilo@bus.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
            ],
        ];

        // Insert Sopir
        echo "\n=== Menambahkan Sopir ===\n";
        foreach ($sopirData as $sopir) {
            $exists = $db->table('karyawan')->where('email', $sopir['email'])->get()->getRow();
            if (!$exists) {
                $db->table('karyawan')->insert($sopir);
                echo "Sopir '{$sopir['nama_karyawan']}' ditambahkan.\n";
            } else {
                echo "Sopir '{$sopir['nama_karyawan']}' sudah ada.\n";
            }
        }

        // Insert Kernet
        echo "\n=== Menambahkan Kernet ===\n";
        foreach ($kernetData as $kernet) {
            $exists = $db->table('karyawan')->where('email', $kernet['email'])->get()->getRow();
            if (!$exists) {
                $db->table('karyawan')->insert($kernet);
                echo "Kernet '{$kernet['nama_karyawan']}' ditambahkan.\n";
            } else {
                echo "Kernet '{$kernet['nama_karyawan']}' sudah ada.\n";
            }
        }

        echo "\n=== Seeder karyawan selesai! ===\n";

        // Summary
        $totalSopir = $db->table('karyawan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Sopir')
            ->countAllResults();
        $totalKernet = $db->table('karyawan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Kernet')
            ->countAllResults();

        echo "\nRingkasan:\n";
        echo "- Total Sopir: {$totalSopir}\n";
        echo "- Total Kernet: {$totalKernet}\n";
    }
}
