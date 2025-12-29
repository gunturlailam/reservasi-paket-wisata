<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Ambil penyewa yang sudah ada
        $penyewa = $this->db->table('penyewa')->limit(2)->get()->getResultArray();

        if (empty($penyewa)) {
            echo "Tidak ada data penyewa. Silakan buat penyewa terlebih dahulu.";
            return;
        }

        // Ambil paket_bus yang sudah ada
        $paketBus = $this->db->table('paket_bus')->limit(2)->get()->getResultArray();

        if (empty($paketBus)) {
            echo "Tidak ada data paket_bus. Silakan buat paket_bus terlebih dahulu.";
            return;
        }

        // Insert Pemesanan (belum dibayar)
        $pemesananData = [
            [
                'id_penyewa' => $penyewa[0]['id'],
                'id_paketbus' => $paketBus[0]['id'],
                'tanggal_pesan' => date('Y-m-d', strtotime('-5 days')),
                'total_bayar' => 5000000
            ]
        ];

        if (count($penyewa) > 1 && count($paketBus) > 1) {
            $pemesananData[] = [
                'id_penyewa' => $penyewa[1]['id'],
                'id_paketbus' => $paketBus[1]['id'],
                'tanggal_pesan' => date('Y-m-d', strtotime('-3 days')),
                'total_bayar' => 7500000
            ];
        }

        $this->db->table('pemesanan')->insertBatch($pemesananData);

        // Ambil ID pemesanan yang baru dibuat
        $pemesananBaru = $this->db->table('pemesanan')
            ->orderBy('id', 'DESC')
            ->limit(count($pemesananData))
            ->get()
            ->getResultArray();

        // Insert Pemesanan Detail
        $pemesananDetailData = [];
        foreach ($pemesananBaru as $index => $p) {
            $pemesananDetailData[] = [
                'id_pemesanan' => $p['id'],
                'tanggal_berangkat' => date('Y-m-d', strtotime('+' . (5 + $index * 5) . ' days')),
                'tanggal_kembali' => date('Y-m-d', strtotime('+' . (7 + $index * 5) . ' days')),
                'jumlah_penumpang' => 40 - ($index * 5)
            ];
        }

        $this->db->table('pemesanan_detail')->insertBatch($pemesananDetailData);

        echo "✅ Test data pemesanan berhasil dibuat!\n";
        echo "Jumlah pemesanan: " . count($pemesananData) . "\n";
        echo "Silakan refresh halaman pembayaran untuk melihat data.";
    }
}
