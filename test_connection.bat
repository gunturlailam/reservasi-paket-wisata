@echo off
title Connection Test
color 0A

echo ========================================
echo      CONNECTION TROUBLESHOOTER
echo ========================================
echo.

set IP=192.168.43.157
set PORT=8080

echo [1/5] Testing basic connectivity...
ping -n 2 %IP%
if %errorlevel% neq 0 (
    echo ❌ Cannot ping your own IP. Network issue detected.
    goto :end
) else (
    echo ✅ Basic connectivity OK
)

echo.
echo [2/5] Testing if port %PORT% is open...
netstat -an | findstr ":%PORT%" | findstr "LISTENING"
if %errorlevel% neq 0 (
    echo ❌ Port %PORT% is not listening
    echo Please make sure server is running with: php spark serve --host=0.0.0.0 --port=%PORT%
    goto :end
) else (
    echo ✅ Port %PORT% is listening
)

echo.
echo [3/5] Testing firewall rules...
netsh advfirewall firewall show rule name="CodeIgniter Port 8080 Inbound" >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Firewall rule not found
    echo Please run setup_firewall.bat as Administrator
) else (
    echo ✅ Firewall rule exists
)

echo.
echo [4/5] Testing HTTP connection locally...
curl -s -o nul -w "HTTP Status: %%{http_code}" http://%IP%:%PORT% 2>nul
if %errorlevel% neq 0 (
    echo ❌ Cannot connect via HTTP
    echo This might be a firewall or antivirus issue
) else (
    echo ✅ HTTP connection successful
)

echo.
echo [5/5] Network information...
echo Your network URL: http://%IP%:%PORT%
echo.
echo 📋 Share this with friends:
echo "Open browser and go to: http://%IP%:%PORT%"
echo.

:end
echo ========================================
echo      TROUBLESHOOTING TIPS
echo ========================================
echo.
echo If friends still cannot access:
echo 1. Make sure they're on same WiFi
echo 2. Try disabling Windows Firewall temporarily
echo 3. Check antivirus settings
echo 4. Try different port: php spark serve --host=0.0.0.0 --port=3000
echo 5. Use mobile hotspot as alternative
echo.
pause