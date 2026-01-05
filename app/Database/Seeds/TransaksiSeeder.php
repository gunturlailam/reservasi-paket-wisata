<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

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

        if (empty($penyewa)) {
            echo "Tidak ada data penyewa. Tambahkan penyewa terlebih dahulu.\n";
            return;
        }

        if (empty($paketBus)) {
            echo "Tidak ada data paket bus. Jalankan PaketBusSeeder terlebih dahulu.\n";
            return;
        }

        if (empty($sopir) || empty($kernet)) {
            echo "Tidak ada data sopir/kernet. Tambahkan karyawan dengan jabatan Sopir dan Kernet.\n";
            return;
        }

        $metodeBayar = ['Transfer', 'Cash', 'QRIS'];
        $baseDate = strtotime('2025-01-01');

        // Buat 15 pemesanan
        for ($i = 1; $i <= 15; $i++) {
            // Random data
            $randomPenyewa = $penyewa[array_rand($penyewa)];
            $randomPaketBus = $paketBus[array_rand($paketBus)];
            $randomBus = $buses[array_rand($buses)];
            $randomSopir = $sopir[array_rand($sopir)];
            $randomKernet = $kernet[array_rand($kernet)];

            // Pastikan sopir dan kernet berbeda
            while ($randomSopir['id'] == $randomKernet['id'] && count($kernet) > 1) {
                $randomKernet = $kernet[array_rand($kernet)];
            }

            // Tanggal pesan (random dalam 30 hari terakhir dari sekarang)
            $tanggalPesan = date('Y-m-d', strtotime("-" . rand(1, 30) . " days"));

            // Tanggal berangkat (setelah tanggal pesan, dalam 1-60 hari ke depan)
            $tanggalBerangkat = date('Y-m-d', strtotime($tanggalPesan . " +" . rand(5, 30) . " days"));

            // Durasi perjalanan 1-5 hari
            $durasi = rand(1, 5);
            $tanggalKembali = date('Y-m-d', strtotime($tanggalBerangkat . " +{$durasi} days"));

            // Jumlah penumpang
            $jumlahPenumpang = rand(10, 45);

            // Hitung total bayar
            $hargaPerOrang = (float) $randomPaketBus['harga'];
            $totalBayar = $hargaPerOrang * $jumlahPenumpang * $durasi;

            // Cek apakah tanggal berangkat sudah digunakan
            $existingDetail = $db->table('pemesanan_detail')
                ->where('tanggal_berangkat', $tanggalBerangkat)
                ->get()->getRow();

            if ($existingDetail) {
                // Skip jika tanggal sudah ada
                echo "Tanggal berangkat {$tanggalBerangkat} sudah digunakan, skip...\n";
                continue;
            }

            // Insert pemesanan
            $db->table('pemesanan')->insert([
                'tanggal_pesan' => $tanggalPesan,
                'id_penyewa' => $randomPenyewa['id'],
                'id_paketbus' => $randomPaketBus['id'],
                'total_bayar' => $totalBayar,
            ]);
            $pemesananId = $db->insertID();

            // Insert pemesanan_detail
            $db->table('pemesanan_detail')->insert([
                'id_pemesanan' => $pemesananId,
                'tanggal_berangkat' => $tanggalBerangkat,
                'tanggal_kembali' => $tanggalKembali,
                'jumlah_penumpang' => $jumlahPenumpang,
            ]);

            echo "Pemesanan #{$pemesananId} ditambahkan (Penyewa: {$randomPenyewa['nama_penyewa']}, Paket: {$randomPaketBus['nama_paket']})\n";

            // Random: 70% sudah bayar, 30% belum
            $sudahBayar = rand(1, 100) <= 70;

            // Tanggal bayar (setelah tanggal pesan, sebelum tanggal berangkat)
            $daysDiff = (strtotime($tanggalBerangkat) - strtotime($tanggalPesan)) / 86400;
            $daysAfterPesan = rand(1, max(1, (int)$daysDiff - 1));
            $tanggalBayar = date('Y-m-d', strtotime($tanggalPesan . " +{$daysAfterPesan} days"));

            // Tentukan jumlah bayar (lunas atau sebagian/DP)
            if ($sudahBayar) {
                // Lunas - bayar penuh
                $jumlahBayar = $totalBayar;
                $statusBayar = 'Lunas';
            } else {
                // Belum lunas - bayar DP (30-50% dari total)
                $persenDP = rand(30, 50);
                $jumlahBayar = round($totalBayar * $persenDP / 100);
                $statusBayar = "DP {$persenDP}%";
            }

            // Insert pembayaran (semua pemesanan punya data pembayaran)
            $db->table('pembayaran')->insert([
                'id_pemesanan' => $pemesananId,
                'tanggal_bayar' => $tanggalBayar,
                'jumlah_bayar' => $jumlahBayar,
                'metode_bayar' => $metodeBayar[array_rand($metodeBayar)],
            ]);

            echo "  -> Pembayaran: {$statusBayar} (Rp " . number_format($jumlahBayar, 0, ',', '.') . " dari Rp " . number_format($totalBayar, 0, ',', '.') . ")\n";

            // Random: 80% yang sudah bayar (lunas), sudah atur keberangkatan
            $sudahAturKeberangkatan = $sudahBayar && rand(1, 100) <= 80;

                if ($sudahAturKeberangkatan) {
                    // Cek ketersediaan bus, sopir, kernet pada tanggal tersebut
                    $busUsed = $db->table('pemberangkatan')
                        ->where('id_bus', $randomBus['id'])
                        ->where('tanggal_berangkat', $tanggalBerangkat)
                        ->get()->getRow();

                    $sopirUsed = $db->table('pemberangkatan')
                        ->where('id_sopir', $randomSopir['id'])
                        ->where('tanggal_berangkat', $tanggalBerangkat)
                        ->get()->getRow();

                    $kernetUsed = $db->table('pemberangkatan')
                        ->where('id_kernet', $randomKernet['id'])
                        ->where('tanggal_berangkat', $tanggalBerangkat)
                        ->get()->getRow();

                    if (!$busUsed && !$sopirUsed && !$kernetUsed) {
                        // Insert pemberangkatan
                        $db->table('pemberangkatan')->insert([
                            'id_pemesanan' => $pemesananId,
                            'id_bus' => $randomBus['id'],
                            'id_sopir' => $randomSopir['id'],
                            'id_kernet' => $randomKernet['id'],
                            'tanggal_berangkat' => $tanggalBerangkat,
                        ]);

                        echo "  -> Keberangkatan diatur (Bus: {$randomBus['nomor_polisi']}, Sopir: {$randomSopir['nama_karyawan']})\n";
                    } else {
                        echo "  -> Keberangkatan tidak bisa diatur (resource tidak tersedia)\n";
                    }
                } else {
                    echo "  -> Keberangkatan belum diatur\n";
                }
            } else {
                echo "  -> Menunggu pembayaran\n";
            }

            echo "\n";
        }

        echo "=== Seeder transaksi selesai! ===\n";

        // Summary
        $totalPemesanan = $db->table('pemesanan')->countAllResults();
        $totalPembayaran = $db->table('pembayaran')->countAllResults();
        $totalPemberangkatan = $db->table('pemberangkatan')->countAllResults();

        echo "\nRingkasan:\n";
        echo "- Total Pemesanan: {$totalPemesanan}\n";
        echo "- Total Pembayaran (Lunas): {$totalPembayaran}\n";
        echo "- Total Pemberangkatan: {$totalPemberangkatan}\n";
    }
}
