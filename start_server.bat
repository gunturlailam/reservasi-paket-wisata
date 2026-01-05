@echo off
echo Starting CodeIgniter Development Server...
echo.
echo Server akan berjalan di:
echo - Local: http://localhost:8080
echo - Network: http://192.168.43.157:8080
echo.
echo Tekan Ctrl+C untuk menghentikan server
echo.

REM Jalankan server dengan binding ke semua interface
php spark serve --host=0.0.0.0 --port=8080