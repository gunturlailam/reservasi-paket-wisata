<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BulkPemberangkatanSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        echo "=== BULK PEMBERANGKATAN SEEDER ===\n";
        echo "Membuat banyak data keberangkatan untuk testing laporan...\n\n";

        // Hapus data lama
        echo "Menghapus data lama...\n";
        $db->table('pemberangkatan')->truncate();
        $db->table('pembayaran')->truncate();
        $db->table('pemesanan_detail')->truncate();
        $db->table('pemesanan')->truncate();

        // Ambil data master
        $penyewa = $db->table('penyewa')->get()->getResultArray();
        $paketBus = $db->table('paket_bus')
            ->select('paket_bus.*, paket_wisata.nama_paket, paket_wisata.harga, paket_wisata.tujuan')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->get()->getResultArray();
        $buses = $db->table('bus')->get()->getResultArray();
        $sopir = $this->getSopir($db);
        $kernet = $this->getKernet($db);

        if (empty($penyewa) || empty($paketBus) || empty($buses) || empty($sopir) || empty($kernet)) {
            echo "❌ Data master tidak lengkap! Jalankan seeder master data terlebih dahulu.\n";
            return;
        }

        echo "✅ Data master tersedia:\n";
        echo "  - Penyewa: " . count($penyewa) . "\n";
        echo "  - Paket Bus: " . count($paketBus) . "\n";
        echo "  - Bus: " . count($buses) . "\n";
        echo "  - Sopir: " . count($sopir) . "\n";
        echo "  - Kernet: " . count($kernet) . "\n\n";

        // Generate data untuk 6 bulan (3 bulan lalu sampai 3 bulan ke depan)
        $startDate = date('Y-m-d', strtotime('-3 months'));
        $endDate = date('Y-m-d', strtotime('+3 months'));

        $targetCount = 100; // Target 100 keberangkatan
        $createdCount = 0;
        $usedCombinations = [];

        // Daftar tujuan populer untuk variasi
        $tujuanPopuler = [
            'Bali',
            'Yogyakarta',
            'Bandung',
            'Malang',
            'Surabaya',
            'Semarang',
            'Solo',
            'Cirebon',
            'Bogor',
            'Sukabumi',
            'Garut',
            'Tasikmalaya',
            'Purwokerto',
            'Tegal',
            'Pekalongan'
        ];

        echo "Membuat {$targetCount} data keberangkatan...\n\n";

        for ($i = 0; $i < $targetCount; $i++) {
            // Generate tanggal random
            $randomTimestamp = strtotime($startDate) + rand(0, strtotime($endDate) - strtotime($startDate));
            $tanggalBerangkat = date('Y-m-d', $randomTimestamp);

            // Skip weekend (opsional, bisa dihapus jika ingin termasuk weekend)
            $dayOfWeek = date('N', strtotime($tanggalBerangkat));
            if ($dayOfWeek >= 6) {
                continue; // Skip weekend
            }

            // Pilih data random
            $randomPenyewa = $penyewa[array_rand($penyewa)];
            $randomPaket = $paketBus[array_rand($paketBus)];

            // Cari kombinasi bus, sopir, kernet yang tersedia
            $combination = $this->findAvailableCombination(
                $buses,
                $sopir,
                $kernet,
                $tanggalBerangkat,
                $usedCombinations
            );

            if (!$combination) {
                continue; // Skip jika tidak ada kombinasi yang tersedia
            }

            // Buat pemesanan
            $tanggalPesan = date('Y-m-d', strtotime($tanggalBerangkat . ' - ' . rand(1, 30) . ' days'));
            $totalBayar = $randomPaket['harga'] + rand(-500000, 1000000); // Variasi harga
            $totalBayar = max($totalBayar, 1000000); // Minimal 1 juta

            $pemesananData = [
                'tanggal_pesan' => $tanggalPesan,
                'id_penyewa' => $randomPenyewa['id'],
                'id_paketbus' => $randomPaket['id'],
                'total_bayar' => $totalBayar,
            ];

            $db->table('pemesanan')->insert($pemesananData);
            $idPemesanan = $db->insertID();

            // Buat detail pemesanan
            $jumlahPenumpang = rand(10, 50);
            $tanggalKembali = date('Y-m-d', strtotime($tanggalBerangkat . ' + ' . rand(1, 7) . ' days'));

            $db->table('pemesanan_detail')->insert([
                'id_pemesanan' => $idPemesanan,
                'tanggal_berangkat' => $tanggalBerangkat,
                'tanggal_kembali' => $tanggalKembali,
                'jumlah_penumpang' => $jumlahPenumpang,
            ]);

            // Buat pembayaran (80% lunas, 20% belum lunas)
            $isLunas = rand(1, 100) <= 80;
            $jumlahBayar = $isLunas ? $totalBayar : rand(500000, $totalBayar - 100000);

            $metodeBayar = ['Transfer', 'Cash', 'Credit Card', 'Debit Card'][rand(0, 3)];
            $tanggalBayar = date('Y-m-d', strtotime($tanggalPesan . ' + ' . rand(1, 10) . ' days'));

            $db->table('pembayaran')->insert([
                'id_pemesanan' => $idPemesanan,
                'tanggal_bayar' => $tanggalBayar,
                'jumlah_bayar' => $jumlahBayar,
                'metode_bayar' => $metodeBayar,
            ]);

            // Buat keberangkatan hanya jika sudah lunas
            if ($isLunas) {
                $db->table('pemberangkatan')->insert([
                    'id_pemesanan' => $idPemesanan,
                    'id_bus' => $combination['bus']['id'],
                    'id_sopir' => $combination['sopir']['id'],
                    'id_kernet' => $combination['kernet']['id'],
                    'tanggal_berangkat' => $tanggalBerangkat,
                ]);

                // Tandai kombinasi sudah dipakai
                $key = $tanggalBerangkat . '_' . $combination['bus']['id'] . '_' . $combination['sopir']['id'] . '_' . $combination['kernet']['id'];
                $usedCombinations[$key] = true;

                $createdCount++;

                if ($createdCount % 10 == 0) {
                    echo "✅ Progress: {$createdCount} keberangkatan dibuat...\n";
                }
            }
        }

        // Statistik akhir
        $totalPemesanan = $db->table('pemesanan')->countAllResults();
        $totalPembayaran = $db->table('pembayaran')->countAllResults();
        $totalPemberangkatan = $db->table('pemberangkatan')->countAllResults();

        echo "\n=== STATISTIK AKHIR ===\n";
        echo "✅ Total Pemesanan: {$totalPemesanan}\n";
        echo "✅ Total Pembayaran: {$totalPembayaran}\n";
        echo "✅ Total Keberangkatan: {$totalPemberangkatan}\n";

        // Statistik per tujuan
        echo "\n=== STATISTIK PER TUJUAN ===\n";
        $statistikTujuan = $db->table('pemberangkatan')
            ->select('paket_wisata.tujuan, COUNT(*) as jumlah')
            ->join('pemesanan', 'pemesanan.id = pemberangkatan.id_pemesanan')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->groupBy('paket_wisata.tujuan')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($statistikTujuan as $stat) {
            echo "  - {$stat['tujuan']}: {$stat['jumlah']} keberangkatan\n";
        }

        // Statistik per bulan
        echo "\n=== STATISTIK PER BULAN ===\n";
        $statistikBulan = $db->table('pemberangkatan')
            ->select('DATE_FORMAT(tanggal_berangkat, "%Y-%m") as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($statistikBulan as $stat) {
            echo "  - {$stat['bulan']}: {$stat['jumlah']} keberangkatan\n";
        }

        echo "\n🎉 BULK SEEDER SELESAI!\n";
        echo "Silakan cek laporan periode dan tujuan di aplikasi.\n";
    }

    /**
     * Ambil data sopir
     */
    private function getSopir($db)
    {
        return $db->table('karyawan')
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Sopir')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil data kernet
     */
    private function getKernet($db)
    {
        return $db->table('karyawan')
            ->select('karyawan.*')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->where('jabatan.nama_jabatan', 'Kernet')
            ->get()
            ->getResultArray();
    }

    /**
     * Cari kombinasi bus, sopir, kernet yang tersedia pada tanggal tertentu
     */
    private function findAvailableCombination($buses, $sopir, $kernet, $tanggal, $usedCombinations)
    {
        // Shuffle untuk randomisasi
        $shuffledBuses = $buses;
        $shuffledSopir = $sopir;
        $shuffledKernet = $kernet;

        shuffle($shuffledBuses);
        shuffle($shuffledSopir);
        shuffle($shuffledKernet);

        foreach ($shuffledBuses as $bus) {
            foreach ($shuffledSopir as $s) {
                foreach ($shuffledKernet as $k) {
                    $key = $tanggal . '_' . $bus['id'] . '_' . $s['id'] . '_' . $k['id'];

                    // Cek apakah kombinasi ini sudah dipakai
                    if (!isset($usedCombinations[$key])) {
                        return [
                            'bus' => $bus,
                            'sopir' => $s,
                            'kernet' => $k
                        ];
                    }
                }
            }
        }

        return null; // Tidak ada kombinasi yang tersedia
    }
}
