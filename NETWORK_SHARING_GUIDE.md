# Panduan Sharing Aplikasi Melalui Jaringan WiFi

## Cara Agar Teman Bisa Akses Aplikasi dari Laptop Mereka

### Konsep Dasar

Dengan network sharing, teman Anda bisa mengakses aplikasi G-Tour yang berjalan di laptop Anda melalui browser mereka, tanpa perlu install atau copy apapun.

---

## Cara Termudah (Recommended):

### 1. **Double-click `start_network_server.bat`**

### 2. **Script akan otomatis:**

- Deteksi IP address Anda
- Update file .env
- Start server untuk network access
- Tampilkan URL yang bisa dibagikan

### 3. **Share URL ke teman**

Contoh: `http://192.168.1.100:8080`

---

## Langkah Manual (Jika Diperlukan)

### Step 1: Pastikan Dalam WiFi yang Sama

- Laptop Anda dan teman harus di WiFi yang sama

### Step 2: Cari IP Address

```cmd
ipconfig
```

Cari "IPv4 Address", contoh: `192.168.1.100`

### Step 3: Jalankan Server Network

```bash
php spark serve --host=0.0.0.0 --port=8080
```

### Step 4: Update .env

```env
app.baseURL = 'http://192.168.1.100:8080'
```

### Step 5: Share URL ke Teman

```
http://192.168.1.100:8080
```

---

## Troubleshooting

### Teman Tidak Bisa Akses:

#### 1. Cek WiFi yang Sama

- Pastikan terhubung WiFi yang sama

#### 2. Cek Firewall

- Windows mungkin block koneksi
- Allow PHP through firewall

#### 3. Cek IP Address

- IP bisa berubah setelah restart
- Jalankan ulang script

#### 4. Test Koneksi

```cmd
ping 192.168.1.100
```

---

## Keamanan

### ⚠️ Peringatan:

- Hanya gunakan di WiFi yang dipercaya
- Jangan di WiFi publik
- Matikan server setelah demo

---

## Alternatif: Hotspot

1. Aktifkan Mobile Hotspot di laptop Anda
2. Teman connect ke hotspot
3. Jalankan `start_network_server.bat`
4. Share IP hotspot (biasanya `192.168.137.1`)

---

## FAQ

**Q: Teman perlu install apa?**
A: Tidak perlu install apapun! Cukup browser.

**Q: Berapa orang bisa akses?**
A: 5-10 orang bersamaan.

**Q: Bisa dari HP?**
A: Ya! Buka browser HP dan akses URL yang sama.

**Q: Data tersimpan dimana?**
A: Semua di laptop Anda, teman hanya lihat tampilan.

---

**Happy Sharing! 🚀📱**
