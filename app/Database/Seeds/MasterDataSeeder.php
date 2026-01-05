    <?php

    namespace App\Database\Seeds;

    use CodeIgniter\Database\Seeder;

    class MasterDataSeeder extends Seeder
    {
        public function run()
        {
            echo "=== MASTER DATA SEEDER ===\n";
            echo "Menjalankan semua seeder dalam urutan yang benar...\n\n";

            // 1. Seeder data master dasar
            echo "1. Menjalankan seeder data master...\n";
            $this->call('KaryawanSeeder');
            $this->call('BusSeeder');
            $this->call('PaketWisataSeeder');
            $this->call('PaketBusSeeder');

            // 2. Seeder transaksi
            echo "\n2. Menjalankan seeder transaksi...\n";
            $this->call('TestDataSeeder'); // Buat pemesanan
            $this->call('PembayaranSeeder'); // Buat pembayaran

            // 3. Seeder keberangkatan (harus terakhir)
            echo "\n3. Menjalankan seeder keberangkatan...\n";
            $this->call('PemberangkatanSeeder');

            echo "\n=== SEEDER SELESAI ===\n";
            echo "✅ Semua data berhasil dibuat!\n";
            echo "Silakan cek aplikasi untuk melihat laporan periode dan tujuan.\n";
        }
    }
