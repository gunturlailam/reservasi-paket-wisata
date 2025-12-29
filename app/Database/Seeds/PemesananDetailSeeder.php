<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemesananDetailSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ambil semua pemesanan yang belum memiliki detail
        $pemesanan = $db->table('pemesanan')
            ->select('pemesanan.id')
            ->where('pemesanan.id NOT IN (SELECT id_pemesanan FROM pemesanan_detail)', null, false)
            ->get()
            ->getResultArray();

        if (!empty($pemesanan)) {
            foreach ($pemesanan as $pesan) {
                $data = [
                    'id_pemesanan' => $pesan['id'],
                    'tanggal_berangkat' => date('Y-m-d', strtotime('+1 day')),
                    'tanggal_kembali' => date('Y-m-d', strtotime('+3 day')),
                    'jumlah_penumpang' => 1,
                ];
                $db->table('pemesanan_detail')->insert($data);
            }
        }
    }
}
