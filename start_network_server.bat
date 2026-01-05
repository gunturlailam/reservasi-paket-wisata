@echo off
title G-Tour Network Server
color 0B

echo ========================================
echo      G-TOUR NETWORK SHARING
echo ========================================
echo.

echo [1/4] Getting your IP address...
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
    set "ip=%%a"
    goto :found
)
:found
set ip=%ip: =%
echo ✅ Your IP Address: %ip%

echo.
echo [2/4] Updating .env file for network access...
if exist .env (
    powershell -Command "(gc .env) -replace 'app.baseURL = ''.*''', 'app.baseURL = ''http://%ip%:8080''' | Out-File -encoding ASCII .env"
    echo ✅ .env updated with your IP address
) else (
    echo ❌ .env file not found! Please run setup.bat first.
    pause
    exit /b 1
)

echo.
echo [3/4] Checking firewall...
echo ⚠️  Make sure PHP is allowed through Windows Firewall
echo    If this is first time, Windows may ask for firewall permission
echo    Click "Allow access" when prompted
echo.

echo [4/4] Starting network server...
echo.
echo ========================================
echo       SERVER INFORMATION
echo ========================================
echo.
echo 🌐 Network URL: http://%ip%:8080
echo 📱 Share this URL with your friends!
echo.
echo 📋 Instructions for friends:
echo 1. Make sure you're on the same WiFi network
echo 2. Open browser and go to: http://%ip%:8080
echo 3. Enjoy the G-Tour application!
echo.
echo ⚠️  Keep this window open while sharing
echo    Press Ctrl+C to stop the server
echo.
echo Starting server in 3 seconds...
timeout /t 3 /nobreak >nul

echo 🚀 Server is now running and accessible from network...
echo.
php spark serve --host=0.0.0.0 --port=8080

pause