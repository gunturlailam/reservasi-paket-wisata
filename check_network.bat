@echo off
title Network Connection Checker
color 0E

echo ========================================
echo      NETWORK CONNECTION CHECKER
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
echo [2/3] Checking if server is running...
netstat -an | findstr ":8080" >nul
if %errorlevel% equ 0 (
    echo ✅ Server is running on port 8080
) else (
    echo ❌ Server is NOT running on port 8080
    echo    Please run start_network_server.bat first
)

echo.
echo [3/3] Network connectivity test...
echo Testing if your IP is reachable...
ping -n 1 %ip% >nul
if %errorlevel% equ 0 (
    echo ✅ Your IP is reachable
) else (
    echo ❌ Your IP is not reachable
    echo    Check your network connection
)

echo.
echo ========================================
echo         NETWORK INFORMATION
echo ========================================
echo.
echo 🌐 Your Network URL: http://%ip%:8080
echo 📋 Share this URL with friends on same WiFi
echo.
echo 💡 Troubleshooting tips:
echo 1. Make sure friends are on same WiFi
echo 2. Check Windows Firewall settings
echo 3. Try disabling antivirus temporarily
echo 4. Restart router if needed
echo.

pause