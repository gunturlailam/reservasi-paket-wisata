# Panduan Seeder Keberangkatan

## Deskripsi

Seeder untuk membuat data keberangkatan dalam jumlah banyak untuk testing laporan periode dan tujuan.

## File Seeder yang Dibuat

### 1. PemberangkatanSeeder.php

- Seeder standar yang menggunakan data pemesanan yang sudah ada
- Membuat keberangkatan berdasarkan pemesanan yang sudah lunas
- Memastikan tidak ada konflik jadwal (bus, sopir, kernet pada tanggal yang sama)

### 2. BulkPemberangkatanSeeder.php

- Seeder untuk membuat banyak data sekaligus (target 100 keberangkatan)
- Membuat data lengkap: pemesanan → pembayaran → keberangkatan
- Periode data: 3 bulan lalu sampai 3 bulan ke depan
- Variasi tujuan, harga, dan metode pembayaran

### 3. MasterDataSeeder.php

- Seeder master yang menjalankan semua seeder dalam urutan yang benar
- Memastikan data master tersedia sebelum membuat transaksi

## Cara Menjalankan

### Opsi 1: Seeder Lengkap (Recommended)

```bash
php spark db:seed MasterDataSeeder
```

### Opsi 2: Seeder Keberangkatan Saja

```bash
# Jika data master sudah ada
php spark db:seed PemberangkatanSeeder
```

### Opsi 3: Bulk Data (Banyak Data)

```bash
# Untuk testing dengan banyak data
php spark db:seed BulkPemberangkatanSeeder
```

## Prasyarat

Sebelum menjalankan seeder, pastikan data master sudah tersedia:

1. **Jabatan** (Sopir dan Kernet)
2. **Karyawan** (dengan jabatan Sopir dan Kernet)
3. **Bus**
4. **Penyewa**
5. **Paket Wisata**
6. **Paket Bus**

## Fitur Seeder

### PemberangkatanSeeder

✅ **Validasi Data Master** - Cek ketersediaan data yang diperlukan
✅ **Conflict Prevention** - Hindari duplikasi jadwal
✅ **Smart Combination** - Cari kombinasi bus/sopir/kernet yang tersedia
✅ **Additional Data** - Buat data tambahan jika kurang dari target
✅ **Detailed Logging** - Log proses pembuatan data

### BulkPemberangkatanSeeder

✅ **Bulk Generation** - Buat 100+ data keberangkatan
✅ **Date Range** - 6 bulan data (3 bulan lalu - 3 bulan depan)
✅ **Realistic Data** - Variasi harga, penumpang, metode bayar
✅ **Payment Status** - 80% lunas, 20% belum lunas
✅ **Weekend Skip** - Skip hari weekend (opsional)
✅ **Statistics** - Tampilkan statistik per tujuan dan bulan

## Output yang Dihasilkan

### Data Pemesanan

- Tanggal pesan random (1-30 hari sebelum keberangkatan)
- Penyewa random dari data master
- Paket bus random dari data master
- Total bayar dengan variasi realistis

### Data Pembayaran

- 80% pemesanan lunas, 20% belum lunas
- Metode bayar: Transfer, Cash, Credit Card, Debit Card
- Tanggal bayar 1-10 hari setelah pesan

### Data Keberangkatan

- Hanya dibuat untuk pemesanan yang sudah lunas
- Bus, sopir, kernet tidak konflik pada tanggal yang sama
- Tanggal keberangkatan tersebar dalam 6 bulan
- Skip hari weekend (Sabtu-Minggu)

## Statistik yang Ditampilkan

1. **Total Data**

   - Jumlah pemesanan
   - Jumlah pembayaran
   - Jumlah keberangkatan

2. **Per Tujuan**

   - Jumlah keberangkatan per destinasi
   - Diurutkan dari yang terbanyak

3. **Per Bulan**
   - Jumlah keberangkatan per bulan
   - Diurutkan chronologis

## Testing Laporan

Setelah menjalankan seeder, Anda dapat menguji:

### Laporan Periode

- URL: `/laporan/periode`
- Filter berdasarkan tanggal mulai dan selesai
- Filter berdasarkan tujuan (opsional)

### Laporan Tujuan

- URL: `/laporan/tujuan`
- Filter berdasarkan tujuan tertentu
- Tampilkan semua tujuan jika tidak difilter

## Troubleshooting

### Error: Data master tidak lengkap

**Solusi:** Jalankan seeder master data terlebih dahulu

```bash
php spark db:seed KaryawanSeeder
php spark db:seed BusSeeder
php spark db:seed PaketWisataSeeder
php spark db:seed PaketBusSeeder
```

### Error: Tidak ada kombinasi tersedia

**Solusi:**

- Tambah data bus, sopir, atau kernet
- Kurangi target jumlah data
- Perluas rentang tanggal

### Data keberangkatan sedikit

**Solusi:**

- Pastikan ada cukup data sopir dan kernet
- Pastikan ada cukup data bus
- Jalankan `BulkPemberangkatanSeeder` untuk data lebih banyak

## Customization

### Mengubah Target Jumlah Data

Edit file `BulkPemberangkatanSeeder.php`:

```php
$targetCount = 200; // Ubah dari 100 ke 200
```

### Mengubah Rentang Tanggal

Edit file `BulkPemberangkatanSeeder.php`:

```php
$startDate = date('Y-m-d', strtotime('-6 months')); // 6 bulan lalu
$endDate = date('Y-m-d', strtotime('+6 months'));   // 6 bulan depan
```

### Mengizinkan Weekend

Hapus atau comment bagian ini di `BulkPemberangkatanSeeder.php`:

```php
// Skip weekend (opsional, bisa dihapus jika ingin termasuk weekend)
$dayOfWeek = date('N', strtotime($tanggalBerangkat));
if ($dayOfWeek >= 6) {
    continue; // Skip weekend
}
```

## Catatan Penting

1. **Urutan Seeder**: Selalu jalankan seeder master data sebelum seeder transaksi
2. **Foreign Key**: Seeder memperhatikan constraint foreign key
3. **Data Realistis**: Data yang dihasilkan realistis untuk testing
4. **Performance**: Bulk seeder menggunakan batch insert untuk performa optimal
5. **Logging**: Semua proses di-log untuk debugging
