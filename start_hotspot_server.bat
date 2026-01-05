@echo off
title G-Tour Hotspot Server
color 0C

echo ========================================
echo      G-TOUR HOTSPOT SHARING
echo ========================================
echo.

echo [1/3] Mobile Hotspot Instructions...
echo.
echo 📱 STEP 1: Enable Mobile Hotspot on your laptop
echo    - Press Windows + I
echo    - Go to Network & Internet → Mobile hotspot
echo    - Turn ON Mobile hotspot
echo    - Note the WiFi name and password
echo.
echo 📱 STEP 2: Ask friends to connect to your hotspot
echo.

pause

echo [2/3] Updating .env for hotspot...
if exist .env (
    powershell -Command "(gc .env) -replace 'app.baseURL = ''.*''', 'app.baseURL = ''http://192.168.137.1:8080''' | Out-File -encoding ASCII .env"
    echo ✅ .env updated for hotspot IP
) else (
    echo ❌ .env file not found!
    pause
    exit /b 1
)

echo.
echo [3/3] Starting server for hotspot sharing...
echo.
echo ========================================
echo       HOTSPOT SERVER INFO
echo ========================================
echo.
echo 🌐 Hotspot URL: http://192.168.137.1:8080
echo 📱 Share this URL with friends connected to your hotspot
echo.
echo 📋 Instructions for friends:
echo 1. Connect to your Mobile Hotspot WiFi
echo 2. Open browser and go to: http://192.168.137.1:8080
echo 3. Enjoy the G-Tour application!
echo.
echo ⚠️  Keep this window open while sharing
echo    Press Ctrl+C to stop the server
echo.
echo Starting server in 3 seconds...
timeout /t 3 /nobreak >nul

echo 🚀 Hotspot server is now running...
echo.
php spark serve --host=0.0.0.0 --port=8080

pause