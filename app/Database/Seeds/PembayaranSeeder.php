<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ambil semua pemesanan yang belum memiliki pembayaran
        $pemesanan = $db->table('pemesanan')
            ->select('pemesanan.id, pemesanan.total_bayar')
            ->where('pemesanan.id NOT IN (SELECT id_pemesanan FROM pembayaran)', null, false)
            ->get()
            ->getResultArray();

        if (!empty($pemesanan)) {
            foreach ($pemesanan as $pesan) {
                $data = [
                    'id_pemesanan' => $pesan['id'],
                    'tanggal_bayar' => null,
                    'jumlah_bayar' => $pesan['total_bayar'],
                    'metode_bayar' => 'Transfer',
                ];
                $db->table('pembayaran')->insert($data);
            }
        }
    }
}
