# Panduan Deployment Proyek G-Tour

## Cara Menjalankan Proyek di Laptop Lain

### Prasyarat yang Harus Diinstall

#### 1. **PHP (Versi 8.1 atau lebih baru)**

- **Windows**: Download dari [php.net](https://www.php.net/downloads.php)
- **macOS**: `brew install php`
- **Linux**: `sudo apt install php8.1 php8.1-cli php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl`

#### 2. **Composer**

- Download dari [getcomposer.org](https://getcomposer.org/download/)
- Pastikan bisa dijalankan dari command line: `composer --version`

#### 3. **Database MySQL/MariaDB**

- **XAMPP** (Recommended untuk Windows): [xampp.org](https://www.apachefriends.org/)
- **MAMP** (untuk macOS): [mamp.info](https://www.mamp.info/)
- **MySQL Server** standalone

#### 4. **Git** (Opsional, untuk clone repository)

- Download dari [git-scm.com](https://git-scm.com/)

---

## Langkah-langkah Deployment

### Step 1: Copy/Clone Proyek

#### Opsi A: Copy Manual

1. Copy seluruh folder proyek ke laptop teman
2. Pastikan semua file dan folder tercopy lengkap

#### Opsi B: Menggunakan Git (Jika ada repository)

```bash
git clone [URL_REPOSITORY]
cd [NAMA_FOLDER_PROYEK]
```

### Step 2: Install Dependencies

```bash
# Masuk ke folder proyek
cd path/to/project

# Install dependencies PHP
composer install
```

### Step 3: Setup Environment

#### 3.1 Copy File Environment

```bash
# Copy file .env.example menjadi .env
cp .env.example .env
```

#### 3.2 Edit File .env

Buka file `.env` dan sesuaikan konfigurasi:

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080'
app.indexPage = ''

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = g_tour_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

### Step 4: Setup Database

#### 4.1 Buat Database

1. Buka phpMyAdmin (jika pakai XAMPP: http://localhost/phpmyadmin)
2. Buat database baru dengan nama `g_tour_db`
3. Atau via command line:

```sql
CREATE DATABASE g_tour_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 4.2 Jalankan Migration

```bash
# Jalankan migration untuk membuat tabel
php spark migrate

# Jika ada error, coba reset dulu
php spark migrate:reset
php spark migrate
```

#### 4.3 Jalankan Seeder (Data Dummy)

```bash
# Jalankan seeder untuk data master
php spark db:seed MasterDataSeeder

# Atau jalankan seeder bulk untuk banyak data
php spark db:seed BulkPemberangkatanSeeder
```

### Step 5: Set Permissions (Linux/macOS)

```bash
# Set permission untuk folder writable
chmod -R 755 writable/
chmod -R 755 public/
```

### Step 6: Jalankan Server

```bash
# Jalankan development server
php spark serve

# Atau dengan port custom
php spark serve --port=8080 --host=0.0.0.0
```

### Step 7: Akses Aplikasi

Buka browser dan akses: `http://localhost:8080`

---

## Troubleshooting

### Error: "Class not found"

**Solusi:**

```bash
composer dump-autoload
```

### Error: Database connection failed

**Solusi:**

1. Pastikan MySQL/MariaDB sudah running
2. Cek konfigurasi database di file `.env`
3. Pastikan database sudah dibuat
4. Test koneksi:

```bash
php spark db:table users
```

### Error: "Encryption key not set"

**Solusi:**

```bash
# Generate encryption key
php spark key:generate
```

### Error: Permission denied (Linux/macOS)

**Solusi:**

```bash
sudo chmod -R 755 writable/
sudo chown -R www-data:www-data writable/
```

### Error: Port already in use

**Solusi:**

```bash
# Gunakan port lain
php spark serve --port=8081
```

---

## File Penting yang Harus Ada

### ✅ Checklist File Wajib:

- [ ] `composer.json` - Dependencies PHP
- [ ] `.env` - Konfigurasi environment
- [ ] `app/` - Folder aplikasi utama
- [ ] `public/` - Folder public assets
- [ ] `writable/` - Folder untuk cache dan logs
- [ ] `system/` - CodeIgniter 4 core files

### ⚠️ File yang TIDAK perlu dicopy:

- `vendor/` - Akan dibuat ulang dengan `composer install`
- `writable/cache/` - Cache files
- `writable/logs/` - Log files
- `.git/` - Git repository (kecuali perlu)

---

## Konfigurasi Khusus

### Untuk Development

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
```

### Untuk Production

```env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com'
```

### Database Alternatif (SQLite untuk Testing)

```env
database.default.DBDriver = SQLite3
database.default.database = writable/database.db
```

---

## Script Otomatis

### Windows (setup.bat)

```batch
@echo off
echo Setting up G-Tour Project...

echo Installing dependencies...
composer install

echo Copying environment file...
copy .env.example .env

echo Running migrations...
php spark migrate

echo Running seeders...
php spark db:seed MasterDataSeeder

echo Starting server...
php spark serve

pause
```

### Linux/macOS (setup.sh)

```bash
#!/bin/bash
echo "Setting up G-Tour Project..."

echo "Installing dependencies..."
composer install

echo "Copying environment file..."
cp .env.example .env

echo "Setting permissions..."
chmod -R 755 writable/
chmod -R 755 public/

echo "Running migrations..."
php spark migrate

echo "Running seeders..."
php spark db:seed MasterDataSeeder

echo "Starting server..."
php spark serve
```

---

## Sharing via Network

### Untuk Akses dari Laptop Lain di Network yang Sama:

1. **Jalankan server dengan host 0.0.0.0:**

```bash
php spark serve --host=0.0.0.0 --port=8080
```

2. **Cari IP Address komputer:**

```bash
# Windows
ipconfig

# Linux/macOS
ifconfig
```

3. **Akses dari laptop lain:**

```
http://[IP_ADDRESS]:8080
```

Contoh: `http://192.168.1.100:8080`

4. **Update .env untuk network access:**

```env
app.baseURL = 'http://192.168.1.100:8080'
```

---

## Backup dan Restore Database

### Backup Database

```bash
# Via mysqldump
mysqldump -u root -p g_tour_db > backup.sql

# Via phpMyAdmin: Export tab
```

### Restore Database

```bash
# Via mysql command
mysql -u root -p g_tour_db < backup.sql

# Via phpMyAdmin: Import tab
```

---

## Tips Deployment

### 1. **Gunakan XAMPP untuk Kemudahan**

- Download XAMPP
- Start Apache dan MySQL
- Copy proyek ke `htdocs/`
- Akses via `http://localhost/nama-proyek/public`

### 2. **Untuk Sharing Cepat**

- Zip seluruh folder proyek
- Include file `setup.bat` atau `setup.sh`
- Sertakan file `README.md` dengan instruksi

### 3. **Environment Variables Penting**

```env
# Timezone
app.timezone = 'Asia/Jakarta'

# Locale
app.defaultLocale = 'id'

# Session
session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
session.cookieName = 'ci_session'
session.expiration = 7200
```

### 4. **Testing Checklist**

- [ ] Homepage bisa diakses
- [ ] Login system berfungsi
- [ ] Database connection OK
- [ ] File upload berfungsi (jika ada)
- [ ] Laporan bisa diakses
- [ ] Semua menu berfungsi

---

## Kontak dan Support

Jika ada masalah saat deployment:

1. Cek file log di `writable/logs/`
2. Pastikan semua prasyarat sudah terinstall
3. Coba jalankan `php spark list` untuk test CodeIgniter
4. Periksa konfigurasi `.env`

**Happy Coding! 🚀**
