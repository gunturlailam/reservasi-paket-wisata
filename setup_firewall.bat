@echo off
echo Membuka port 8080 untuk CodeIgniter...
echo.

REM Tambah rule untuk port 8080 inbound
netsh advfirewall firewall add rule name="CodeIgniter Port 8080 Inbound" dir=in action=allow protocol=TCP localport=8080

REM Tambah rule untuk port 8080 outbound  
netsh advfirewall firewall add rule name="CodeIgniter Port 8080 Outbound" dir=out action=allow protocol=TCP localport=8080

REM Tambah rule untuk port 80 jika diperlukan
netsh advfirewall firewall add rule name="HTTP Port 80 Inbound" dir=in action=allow protocol=TCP localport=80

echo.
echo Firewall rules berhasil ditambahkan!
echo Port 8080 dan 80 sekarang terbuka untuk akses jaringan lokal.
echo.
pause