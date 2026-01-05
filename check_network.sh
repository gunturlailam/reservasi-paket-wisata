#!/bin/bash

echo "========================================"
echo "      NETWORK CONNECTION CHECKER"
echo "========================================"
echo

echo "[1/3] Getting your IP address..."
IP=$(ipconfig | grep "IPv4 Address" | head -1 | cut -d: -f2 | tr -d ' ')
echo "✅ Your IP Address: $IP"

echo
echo "[2/3] Checking if server is running..."
if netstat -an | grep -q ":8080"; then
    echo "✅ Server is running on port 8080"
else
    echo "❌ Server is NOT running on port 8080"
    echo "   Please run ./start_network_server.sh first"
fi

echo
echo "[3/3] Network connectivity test..."
echo "Testing if your IP is reachable..."
if ping -n 1 $IP > /dev/null 2>&1; then
    echo "✅ Your IP is reachable"
else
    echo "❌ Your IP is not reachable"
    echo "   Check your network connection"
fi

echo
echo "========================================"
echo "         NETWORK INFORMATION"
echo "========================================"
echo
echo "🌐 Your Network URL: http://$IP:8080"
echo "📋 Share this URL with friends on same WiFi"
echo
echo "💡 Troubleshooting tips:"
echo "1. Make sure friends are on same WiFi"
echo "2. Check Windows Firewall settings"
echo "3. Try disabling antivirus temporarily"
echo "4. Restart router if needed"
echo

read -p "Press Enter to continue..."