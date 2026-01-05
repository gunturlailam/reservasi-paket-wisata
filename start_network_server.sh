#!/bin/bash

echo "========================================"
echo "      G-TOUR NETWORK SHARING"
echo "========================================"
echo

echo "[1/4] Getting your IP address..."
# Get IP address (works in Git Bash on Windows)
IP=$(ipconfig | grep "IPv4 Address" | head -1 | cut -d: -f2 | tr -d ' ')
echo "✅ Your IP Address: $IP"

echo
echo "[2/4] Updating .env file for network access..."
if [ -f .env ]; then
    # Update baseURL in .env file
    sed -i "s|app.baseURL = '.*'|app.baseURL = 'http://$IP:8080'|g" .env
    echo "✅ .env updated with your IP address"
else
    echo "❌ .env file not found! Please run setup first."
    exit 1
fi

echo
echo "[3/4] Checking firewall..."
echo "⚠️  Make sure PHP is allowed through Windows Firewall"
echo "   If this is first time, Windows may ask for firewall permission"
echo "   Click 'Allow access' when prompted"
echo

echo "[4/4] Starting network server..."
echo
echo "========================================"
echo "       SERVER INFORMATION"
echo "========================================"
echo
echo "🌐 Network URL: http://$IP:8080"
echo "📱 Share this URL with your friends!"
echo
echo "📋 Instructions for friends:"
echo "1. Make sure you're on the same WiFi network"
echo "2. Open browser and go to: http://$IP:8080"
echo "3. Enjoy the G-Tour application!"
echo
echo "⚠️  Keep this window open while sharing"
echo "   Press Ctrl+C to stop the server"
echo
echo "Starting server in 3 seconds..."
sleep 3

echo "🚀 Server is now running and accessible from network..."
echo
php spark serve --host=0.0.0.0 --port=8080