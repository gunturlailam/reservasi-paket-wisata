<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemberangkatanSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        echo "=== Membuat Data Keberangkatan ===\n";

        // Hapus data lama
        $db->table('pemberangkatan')->truncate();
        echo "Tabel pemberangkatan dikosongkan.\n";

        // Ambil data master yang diperlukan
        $pemesananLunas = $this->getPemesananLunas($db);
        $buses = $db->table('bus')->get()->getResultArray();
        $sopir = $this->getSopir($db);
        $kernet = $this->getKernet($db);

        if (empty($pemesananLunas)) {
            echo "❌ Tidak ada pemesanan yang sudah lunas. Jalankan seeder pemesanan dan pembayaran terlebih dahulu.\n";
            return;
        }

        if (empty($buses) || empty($sopir) || empty($kernet)) {
            echo "❌ Data master tidak lengkap!\n";
            echo "Bus: " . count($buses) . "\n";
            echo "Sopir: " . count($sopir) . "\n";
            echo "Kernet: " . count($kernet) . "\n";
            return;
        }

        echo "✅ Data master tersedia:\n";
        echo "  - Pemesanan lunas: " . count($pemesananLunas) . "\n";
        echo "  - Bus: " . count($buses) . "\n";
        echo "  - Sopir: " . count($sopir) . "\n";
        echo "  - Kernet: " . count($kernet) . "\n\n";

        // Buat data keberangkatan untuk setiap pemesanan yang sudah lunas
        $pemberangkatanData = [];
        $usedCombinations = []; // Track kombinasi tanggal + sopir/kernet/bus yang sudah dipakai

        foreach ($pemesananLunas as $index => $pemesanan) {
            $tanggalBerangkat = $pemesanan['tanggal_berangkat'];

            // Cari kombinasi bus, sopir, kernet yang belum dipakai pada tanggal tersebut
            $combination = $this->findAvailableCombination(
                $buses,
                $sopir,
                $kernet,
                $tanggalBerangkat,
                $usedCombinations
            );

            if ($combination) {
                $pemberangkatanData[] = [
                    'id_pemesanan' => $pemesanan['id_pemesanan'],
                    'id_bus' => $combination['bus']['id'],
                    'id_sopir' => $combination['sopir']['id'],
                    'id_kernet' => $combination['kernet']['id'],
                    'tanggal_berangkat' => $tanggalBerangkat,
                ];

                // Tandai kombinasi ini sudah dipakai
                $key = $tanggalBerangkat . '_' . $combination['bus']['id'] . '_' . $combination['sopir']['id'] . '_' . $combination['kernet']['id'];
                $usedCombinations[$key] = true;

                echo "✅ Keberangkatan #" . ($index + 1) . ": {$pemesanan['nama_paket']} - {$tanggalBerangkat}\n";
                echo "   Bus: {$combination['bus']['nomor_polisi']} ({$combination['bus']['merek']})\n";
                echo "   Sopir: {$combination['sopir']['nama_karyawan']}\n";
                echo "   Kernet: {$combination['kernet']['nama_karyawan']}\n\n";
            } else {
                echo "⚠️  Tidak bisa membuat keberangkatan untuk pemesanan #{$pemesanan['id_pemesanan']} - {$tanggalBerangkat}\n";
                echo "   Semua kombinasi bus/sopir/kernet sudah terpakai pada tanggal tersebut.\n\n";
            }
        }

        // Insert data keberangkatan
        if (!empty($pemberangkatanData)) {
            $db->table('pemberangkatan')->insertBatch($pemberangkatanData);
            echo "🎉 Berhasil membuat " . count($pemberangkatanData) . " data keberangkatan!\n";
        } else {
            echo "❌ Tidak ada data keberangkatan yang bisa dibuat.\n";
        }

        // Buat data tambahan jika diperlukan
        $this->createAdditionalData($db, $buses, $sopir, $kernet);

        echo "\n=== Seeder Keberangkatan Selesai ===\n";
    }

    /**
     * Ambil pemesanan yang sudah lunas dan memiliki detail
     */
    private function getPemesananLunas($db)
    {
        return $db->table('pemesanan')
            ->select('
                pemesanan.id as id_pemesanan,
                pemesanan.tanggal_pesan,
                pemesanan.total_bayar,
                pemesanan_detail.tanggal_berangkat,
                pemesanan_detail.tanggal_kembali,
                pemesanan_detail.jumlah_penumpang,
                paket_wisata.nama_paket,
                paket_wisata.tujuan,
                penyewa.nama_penyewa,
                COALESCE(SUM(pembayaran.jumlah_bayar), 0) as total_dibayar
            ')
            ->join('pemesanan_detail', 'pemesanan_detail.id_pemesanan = pemesanan.id', 'left')
            ->join('paket_bus', 'paket_bus.id = pemesanan.id_paketbus', 'left')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata', 'left')
            ->join('penyewa', 'penyewa.id = pemesanan.id_penyewa', 'left')
            ->join('pembayaran', 'pembayaran.id_pemesanan = pemesanan.id', 'left')
            ->groupBy('pemesanan.id')
            ->having('total_dibayar >= pemesanan.total_bayar') // Sudah lunas
            ->where('pemesanan_detail.tanggal_berangkat IS NOT NULL')
            ->orderBy('pemesanan_detail.tanggal_berangkat', 'ASC')
            ->get()
            ->getResultArray();
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
        shuffle($buses);
        shuffle($sopir);
        shuffle($kernet);

        foreach ($buses as $bus) {
            foreach ($sopir as $s) {
                foreach ($kernet as $k) {
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

    /**
     * Buat data tambahan jika masih sedikit
     */
    private function createAdditionalData($db, $buses, $sopir, $kernet)
    {
        $currentCount = $db->table('pemberangkatan')->countAllResults();

        if ($currentCount < 20) {
            echo "\n=== Membuat Data Tambahan ===\n";
            echo "Data keberangkatan saat ini: {$currentCount}, target minimal: 20\n";

            // Buat pemesanan dan keberangkatan tambahan
            $this->createAdditionalBookingsAndDepartures($db, $buses, $sopir, $kernet, 20 - $currentCount);
        }
    }

    /**
     * Buat pemesanan dan keberangkatan tambahan
     */
    private function createAdditionalBookingsAndDepartures($db, $buses, $sopir, $kernet, $targetCount)
    {
        // Ambil data master
        $penyewa = $db->table('penyewa')->get()->getResultArray();
        $paketBus = $db->table('paket_bus')
            ->select('paket_bus.*, paket_wisata.nama_paket, paket_wisata.harga, paket_wisata.tujuan')
            ->join('paket_wisata', 'paket_wisata.id = paket_bus.id_paketwisata')
            ->get()->getResultArray();

        if (empty($penyewa) || empty($paketBus)) {
            echo "❌ Tidak bisa membuat data tambahan: data penyewa atau paket tidak tersedia.\n";
            return;
        }

        $additionalData = [];
        $usedCombinations = $this->getExistingCombinations($db);

        // Generate tanggal dari 1 bulan lalu sampai 2 bulan ke depan
        $startDate = date('Y-m-d', strtotime('-1 month'));
        $endDate = date('Y-m-d', strtotime('+2 months'));

        for ($i = 0; $i < $targetCount; $i++) {
            // Random tanggal
            $randomDate = date('Y-m-d', strtotime($startDate . ' + ' . rand(0, 90) . ' days'));

            // Pastikan tidak weekend (opsional)
            while (date('N', strtotime($randomDate)) >= 6) {
                $randomDate = date('Y-m-d', strtotime($randomDate . ' + 1 day'));
            }

            // Cari kombinasi yang tersedia
            $combination = $this->findAvailableCombination(
                $buses,
                $sopir,
                $kernet,
                $randomDate,
                $usedCombinations
            );

            if ($combination) {
                // Buat pemesanan baru
                $randomPenyewa = $penyewa[array_rand($penyewa)];
                $randomPaket = $paketBus[array_rand($paketBus)];

                $pemesananData = [
                    'tanggal_pesan' => date('Y-m-d', strtotime($randomDate . ' - ' . rand(1, 30) . ' days')),
                    'id_penyewa' => $randomPenyewa['id'],
                    'id_paketbus' => $randomPaket['id'],
                    'total_bayar' => $randomPaket['harga'],
                ];

                $db->table('pemesanan')->insert($pemesananData);
                $idPemesanan = $db->insertID();

                // Buat detail pemesanan
                $db->table('pemesanan_detail')->insert([
                    'id_pemesanan' => $idPemesanan,
                    'tanggal_berangkat' => $randomDate,
                    'tanggal_kembali' => date('Y-m-d', strtotime($randomDate . ' + ' . rand(1, 7) . ' days')),
                    'jumlah_penumpang' => rand(10, 50),
                ]);

                // Buat pembayaran (lunas)
                $db->table('pembayaran')->insert([
                    'id_pemesanan' => $idPemesanan,
                    'tanggal_bayar' => date('Y-m-d', strtotime($pemesananData['tanggal_pesan'] . ' + ' . rand(1, 5) . ' days')),
                    'jumlah_bayar' => $randomPaket['harga'],
                    'metode_bayar' => ['Transfer', 'Cash', 'Credit Card'][rand(0, 2)],
                ]);

                // Buat keberangkatan
                $additionalData[] = [
                    'id_pemesanan' => $idPemesanan,
                    'id_bus' => $combination['bus']['id'],
                    'id_sopir' => $combination['sopir']['id'],
                    'id_kernet' => $combination['kernet']['id'],
                    'tanggal_berangkat' => $randomDate,
                ];

                // Tandai kombinasi sudah dipakai
                $key = $randomDate . '_' . $combination['bus']['id'] . '_' . $combination['sopir']['id'] . '_' . $combination['kernet']['id'];
                $usedCombinations[$key] = true;

                echo "✅ Data tambahan #" . ($i + 1) . ": {$randomPaket['nama_paket']} - {$randomDate}\n";
                echo "   Tujuan: {$randomPaket['tujuan']}\n";
                echo "   Bus: {$combination['bus']['nomor_polisi']}\n";
                echo "   Sopir: {$combination['sopir']['nama_karyawan']}\n";
                echo "   Kernet: {$combination['kernet']['nama_karyawan']}\n\n";
            } else {
                echo "⚠️  Tidak bisa membuat data tambahan #" . ($i + 1) . " untuk tanggal {$randomDate}\n";
            }
        }

        // Insert keberangkatan tambahan
        if (!empty($additionalData)) {
            $db->table('pemberangkatan')->insertBatch($additionalData);
            echo "🎉 Berhasil membuat " . count($additionalData) . " data keberangkatan tambahan!\n";
        }
    }

    /**
     * Ambil kombinasi yang sudah ada di database
     */
    private function getExistingCombinations($db)
    {
        $existing = $db->table('pemberangkatan')
            ->select('tanggal_berangkat, id_bus, id_sopir, id_kernet')
            ->get()
            ->getResultArray();

        $combinations = [];
        foreach ($existing as $item) {
            $key = $item['tanggal_berangkat'] . '_' . $item['id_bus'] . '_' . $item['id_sopir'] . '_' . $item['id_kernet'];
            $combinations[$key] = true;
        }

        return $combinations;
    }
}
