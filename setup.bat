@echo off
title G-Tour Project Setup
color 0A

echo ========================================
echo       G-TOUR PROJECT SETUP
echo ========================================
echo.

echo [1/7] Checking PHP installation...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP not found! Please install PHP first.
    echo Download from: https://www.php.net/downloads.php
    pause
    exit /b 1
)
echo ✅ PHP found

echo.
echo [2/7] Checking Composer installation...
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer not found! Please install Composer first.
    echo Download from: https://getcomposer.org/download/
    pause
    exit /b 1
)
echo ✅ Composer found

echo.
echo [3/7] Installing PHP dependencies...
composer install
if %errorlevel% neq 0 (
    echo ❌ Failed to install dependencies
    pause
    exit /b 1
)
echo ✅ Dependencies installed

echo.
echo [4/7] Setting up environment file...
if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
        echo ✅ Environment file created from .env.example
    ) else (
        echo Creating default .env file...
        (
            echo #--------------------------------------------------------------------
            echo # ENVIRONMENT
            echo #--------------------------------------------------------------------
            echo CI_ENVIRONMENT = development
            echo.
            echo #--------------------------------------------------------------------
            echo # APP
            echo #--------------------------------------------------------------------
            echo app.baseURL = 'http://localhost:8080'
            echo app.indexPage = ''
            echo app.timezone = 'Asia/Jakarta'
            echo.
            echo #--------------------------------------------------------------------
            echo # DATABASE
            echo #--------------------------------------------------------------------
            echo database.default.hostname = localhost
            echo database.default.database = g_tour_db
            echo database.default.username = root
            echo database.default.password = 
            echo database.default.DBDriver = MySQLi
            echo database.default.DBPrefix = 
            echo database.default.port = 3306
        ) > .env
        echo ✅ Default environment file created
    )
) else (
    echo ✅ Environment file already exists
)

echo.
echo [5/7] Generating encryption key...
php spark key:generate
echo ✅ Encryption key generated

echo.
echo [6/7] Database setup...
echo ⚠️  Make sure MySQL is running and database 'g_tour_db' exists
echo.
set /p continue="Continue with database migration? (y/n): "
if /i "%continue%"=="y" (
    echo Running database migrations...
    php spark migrate
    if %errorlevel% neq 0 (
        echo ❌ Migration failed. Please check database connection.
        echo Edit .env file and make sure database exists.
        pause
        exit /b 1
    )
    echo ✅ Database migrated successfully
    
    echo.
    set /p seed="Run seeders to create sample data? (y/n): "
    if /i "%seed%"=="y" (
        echo Running seeders...
        php spark db:seed BulkPemberangkatanSeeder
        echo ✅ Sample data created
    )
) else (
    echo ⚠️  Skipping database setup
    echo Remember to run: php spark migrate
)

echo.
echo [7/7] Starting development server...
echo.
echo ========================================
echo        SETUP COMPLETED! 🎉
echo ========================================
echo.
echo Your G-Tour application is ready!
echo.
echo 📝 Next steps:
echo 1. Make sure MySQL is running
echo 2. Create database 'g_tour_db' if not exists
echo 3. Edit .env file if needed
echo 4. Access: http://localhost:8080
echo.
echo Starting server in 3 seconds...
timeout /t 3 /nobreak >nul

echo.
echo 🚀 Starting development server...
echo Press Ctrl+C to stop the server
echo.
php spark serve

pause