<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoTransaksiSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Hapus data lama (urutan penting karena foreign key)
        echo "=== Menghapus data lama ===\n";
        $db->table('pemberangkatan')->truncate();
        echo "Tabel pemberangkatan dikosongkan.\n";
        $db->table('pembayaran')->truncate();
        echo "Tabel pembayaran dikosongkan.\n";
        $db->table('pemesanan_detail')->truncate();
        echo "Tabel pemesanan_detail dikosongkan.\n";
        $db->table('pemesanan')->truncate();
        echo "Tabel pemesanan dikosongkan.\n";

        // Ambil data master
        $penyewa = $db->table('penyewa')->get()->getResultArray();
        $paketBus = $db->table('paket_bus')
            ->select('paket_bus.*, paket_wisata.nama_paket, paket_wisata.harga')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->get()->getResultArray();
        $buses = $db->table('bus')->get()->getResultArray();
        $sopir = $db->table('karyawan')
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Sopir')
            ->get()->getResultArray();
        $kernet = $db->table('karyawan')
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Kernet')
            ->get()->getResultArray();

        if (empty($penyewa) || empty($paketBus) || empty($sopir) || empty($kernet)) {
            echo "Data master tidak lengkap!\n";
            echo "Penyewa: " . count($penyewa) . "\n";
            echo "Paket Bus: " . count($paketBus) . "\n";
            echo "Sopir: " . count($sopir) . "\n";
            echo "Kernet: " . count($kernet) . "\n";
            return;
        }

        // Debug: tampilkan ID sopir dan kernet
        echo "Sopir tersedia:\n";
        foreach ($sopir as $s) {
            echo "  - ID: {$s['id']}, Nama: {$s['nama_karyawan']}\n";
        }
        echo "Kernet tersedia:\n";
        foreach ($kernet as $k) {
            echo "  - ID: {$k['id']}, Nama: {$k['nama_karyawan']}\n";
        }

        echo "\n=== Membuat data demo ===\n";

        // Tanggal berangkat yang sama: 15 Januari 2025
        $tanggalBerangkatSama = '2025-01-15';
        $tanggalKembali = '2025-01-17';

        // ============================================
        // PEMESANAN 1 - Tanggal 15 Jan (LUNAS + SUDAH ATUR KEBERANGKATAN)
        // ============================================
        $pemesanan1 = [
            'tanggal_pesan' => '2025-01-05',
            'id_penyewa' => $penyewa[0]['id'],
            'id_paketbus' => $paketBus[0]['id'],
            'total_bayar' => 3000000,
        ];
        $db->table('pemesanan')->insert($pemesanan1);
        $idPemesanan1 = $db->insertID();

        $db->table('pemesanan_detail')->insert([
            'id_pemesanan' => $idPemesanan1,
            'tanggal_berangkat' => $tanggalBerangkatSama,
            'tanggal_kembali' => $tanggalKembali,
            'jumlah_penumpang' => 20,
        ]);

        // Pembayaran lunas
        $db->table('pembayaran')->insert([
            'id_pemesanan' => $idPemesanan1,
            'tanggal_bayar' => '2025-01-06',
            'jumlah_bayar' => 3000000,
            'metode_bayar' => 'Transfer',
        ]);

        // Keberangkatan sudah diatur (Sopir: index 0, Kernet: index 0)
        $db->table('pemberangkatan')->insert([
            'id_pemesanan' => $idPemesanan1,
            'id_bus' => $buses[0]['id'],
            'id_sopir' => $sopir[0]['id'],
            'id_kernet' => $kernet[0]['id'],
            'tanggal_berangkat' => $tanggalBerangkatSama,
        ]);

        echo "Pemesanan #1: {$paketBus[0]['nama_paket']} - LUNAS - Keberangkatan SUDAH DIATUR\n";
        echo "  Sopir: {$sopir[0]['nama_karyawan']}, Kernet: {$kernet[0]['nama_karyawan']}\n";

        // ============================================
        // PEMESANAN 2 - Tanggal 15 Jan (LUNAS + BELUM ATUR KEBERANGKATAN)
        // Ini untuk test: sopir & kernet dari pemesanan 1 tidak bisa dipilih
        // ============================================
        $pemesanan2 = [
            'tanggal_pesan' => '2025-01-06',
            'id_penyewa' => $penyewa[0]['id'],
            'id_paketbus' => $paketBus[1]['id'] ?? $paketBus[0]['id'],
            'total_bayar' => 2500000,
        ];
        $db->table('pemesanan')->insert($pemesanan2);
        $idPemesanan2 = $db->insertID();

        $db->table('pemesanan_detail')->insert([
            'id_pemesanan' => $idPemesanan2,
            'tanggal_berangkat' => $tanggalBerangkatSama, // TANGGAL SAMA!
            'tanggal_kembali' => $tanggalKembali,
            'jumlah_penumpang' => 15,
        ]);

        // Pembayaran lunas
        $db->table('pembayaran')->insert([
            'id_pemesanan' => $idPemesanan2,
            'tanggal_bayar' => '2025-01-07',
            'jumlah_bayar' => 2500000,
            'metode_bayar' => 'Cash',
        ]);

        // TIDAK ADA keberangkatan - untuk test atur keberangkatan
        $paketNama2 = $paketBus[1]['nama_paket'] ?? $paketBus[0]['nama_paket'];
        echo "Pemesanan #2: {$paketNama2} - LUNAS - Keberangkatan BELUM DIATUR\n";
        echo "  -> Saat atur keberangkatan, sopir '{$sopir[0]['nama_karyawan']}' & kernet '{$kernet[0]['nama_karyawan']}' TIDAK BISA dipilih\n";

        // ============================================
        // PEMESANAN 3 - Tanggal 15 Jan (BELUM BAYAR)
        // ============================================
        $pemesanan3 = [
            'tanggal_pesan' => '2025-01-07',
            'id_penyewa' => $penyewa[0]['id'],
            'id_paketbus' => $paketBus[2]['id'] ?? $paketBus[0]['id'],
            'total_bayar' => 2000000,
        ];
        $db->table('pemesanan')->insert($pemesanan3);
        $idPemesanan3 = $db->insertID();

        $db->table('pemesanan_detail')->insert([
            'id_pemesanan' => $idPemesanan3,
            'tanggal_berangkat' => $tanggalBerangkatSama, // TANGGAL SAMA!
            'tanggal_kembali' => $tanggalKembali,
            'jumlah_penumpang' => 10,
        ]);

        // TIDAK ADA pembayaran
        $paketNama3 = $paketBus[2]['nama_paket'] ?? $paketBus[0]['nama_paket'];
        echo "Pemesanan #3: {$paketNama3} - BELUM BAYAR\n";

        // ============================================
        // PEMESANAN 4 - Tanggal BERBEDA (20 Jan) - LUNAS
        // ============================================
        $pemesanan4 = [
            'tanggal_pesan' => '2025-01-08',
            'id_penyewa' => $penyewa[0]['id'],
            'id_paketbus' => $paketBus[3]['id'] ?? $paketBus[0]['id'],
            'total_bayar' => 3500000,
        ];
        $db->table('pemesanan')->insert($pemesanan4);
        $idPemesanan4 = $db->insertID();

        $db->table('pemesanan_detail')->insert([
            'id_pemesanan' => $idPemesanan4,
            'tanggal_berangkat' => '2025-01-20', // TANGGAL BERBEDA
            'tanggal_kembali' => '2025-01-22',
            'jumlah_penumpang' => 25,
        ]);

        // Pembayaran lunas
        $db->table('pembayaran')->insert([
            'id_pemesanan' => $idPemesanan4,
            'tanggal_bayar' => '2025-01-09',
            'jumlah_bayar' => 3500000,
            'metode_bayar' => 'Transfer',
        ]);

        $paketNama4 = $paketBus[3]['nama_paket'] ?? $paketBus[0]['nama_paket'];
        echo "Pemesanan #4: {$paketNama4} - LUNAS - Tanggal 20 Jan (BERBEDA)\n";
        echo "  -> Semua sopir & kernet BISA dipilih karena tanggal berbeda\n";

        echo "\n=== Seeder selesai! ===\n";
        echo "\nSkenario Test:\n";
        echo "1. Pemesanan #2 (tgl 15 Jan): Saat atur keberangkatan, sopir & kernet dari pemesanan #1 tidak bisa dipilih\n";
        echo "2. Pemesanan #4 (tgl 20 Jan): Semua sopir & kernet bisa dipilih karena tanggal berbeda\n";
    }
}
