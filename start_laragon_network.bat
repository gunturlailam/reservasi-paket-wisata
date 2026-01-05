@echo off
title G-Tour Laragon Network
color 0F

echo ========================================
echo      G-TOUR LARAGON NETWORK SHARING
echo ========================================
echo.

echo [1/3] Getting your IP address...
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
    set "ip=%%a"
    goto :found
)
:found
set ip=%ip: =%
echo ✅ Your IP Address: %ip%

echo.
echo [2/3] Laragon network setup...
echo.
echo 📋 Instructions:
echo 1. Open Laragon
echo 2. Right-click Laragon tray icon
echo 3. Go to Apache → httpd.conf
echo 4. Find line: Listen 80
echo 5. Add below it: Listen %ip%:80
echo 6. Save and restart Apache in Laragon
echo.
echo 💡 Alternative: Use Laragon's "Share" feature
echo 1. Right-click Laragon tray icon
echo 2. Click "Share" 
echo 3. It will give you a public URL
echo.

pause

echo [3/3] Network information...
echo.
echo ========================================
echo       LARAGON NETWORK URLS
echo ========================================
echo.
echo 🌐 Local Network URL: http://%ip%/reservasi-wisata/public
echo 🌐 Alternative: Use Laragon Share feature for public URL
echo.
echo 📋 Share with friends on same WiFi:
echo "Open browser and go to: http://%ip%/reservasi-wisata/public"
echo.
echo 💡 If still not working:
echo 1. Use Laragon's built-in Share feature
echo 2. Or copy project to friend's laptop with XAMPP
echo.

pause