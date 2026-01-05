@echo off
echo ========================================
echo      FIREWALL FIX FOR NETWORK SHARING
echo ========================================
echo.

echo [1/4] Removing old rules...
netsh advfirewall firewall delete rule name="CodeIgniter Port 8080 Inbound" >nul 2>&1
netsh advfirewall firewall delete rule name="CodeIgniter Port 8080 Outbound" >nul 2>&1
netsh advfirewall firewall delete rule name="PHP Server" >nul 2>&1

echo [2/4] Adding new firewall rules...
netsh advfirewall firewall add rule name="PHP Server Port 8080" dir=in action=allow protocol=TCP localport=8080
netsh advfirewall firewall add rule name="PHP Server Port 3000" dir=in action=allow protocol=TCP localport=3000
netsh advfirewall firewall add rule name="PHP Server All Ports" dir=in action=allow program="php.exe"

echo [3/4] Testing firewall rules...
netsh advfirewall firewall show rule name="PHP Server Port 8080"

echo [4/4] Network information...
echo.
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
    set "ip=%%a"
    goto :found
)
:found
set ip=%ip: =%

echo ✅ Firewall rules added successfully!
echo 🌐 Your network URL: http://%ip%:8080
echo 📱 Alternative URL: http://%ip%:3000
echo.
echo Now ask your friend to try accessing the URL again.
echo.
pause