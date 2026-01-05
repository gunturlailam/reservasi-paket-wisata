@echo off
title G-Tour ngrok Server
color 0D

echo ========================================
echo      G-TOUR INTERNET SHARING (ngrok)
echo ========================================
echo.

echo [1/4] Checking if ngrok is available...
where ngrok >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ ngrok not found!
    echo.
    echo 📥 Please download ngrok:
    echo 1. Go to: https://ngrok.com/download
    echo 2. Download ngrok for Windows
    echo 3. Extract ngrok.exe to this folder
    echo 4. Run this script again
    echo.
    pause
    exit /b 1
) else (
    echo ✅ ngrok found
)

echo.
echo [2/4] Starting local server...
start "Local Server" cmd /k "php spark serve"
timeout /t 3 /nobreak >nul

echo [3/4] Starting ngrok tunnel...
echo.
echo ⚠️  ngrok will create a public URL that anyone can access
echo    Only share with trusted friends!
echo.
echo Starting ngrok in 3 seconds...
timeout /t 3 /nobreak >nul

echo [4/4] Creating public tunnel...
echo.
echo ========================================
echo       NGROK TUNNEL ACTIVE
echo ========================================
echo.
echo 🌐 Your application is now accessible from ANYWHERE!
echo 📱 Share the HTTPS URL that appears below with friends
echo 🔒 This is a secure HTTPS connection
echo.
echo ⚠️  Keep both windows open while sharing
echo    Close this window to stop public access
echo.

ngrok http 8080

pause