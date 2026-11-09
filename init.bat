@echo off
setlocal
cd /d "%~dp0"
if errorlevel 1 exit /b 1

where php >nul 2>nul
if errorlevel 1 (
    echo PHP was not found. Install PHP 8.2 or newer and add it to PATH.
    exit /b 1
)
where composer >nul 2>nul
if errorlevel 1 (
    echo Composer was not found. Install Composer and add it to PATH.
    exit /b 1
)
where npm >nul 2>nul
if errorlevel 1 (
    echo npm was not found. Install Node.js and add it to PATH.
    exit /b 1
)

if not exist .env copy .env.example .env
if errorlevel 1 goto :error

set "DB_CONNECTION=sqlite"
set "DB_DATABASE=%CD%\database\database.sqlite"

if not exist database\database.sqlite (
    type nul > database\database.sqlite
    if errorlevel 1 goto :error
    set "NEW_DATABASE=1"
)

call composer install --no-interaction
if errorlevel 1 goto :error

findstr /r /c:"^APP_KEY=$" .env >nul
if not errorlevel 1 (
    call php artisan key:generate
    if errorlevel 1 goto :error
)

call npm install
if errorlevel 1 goto :error

call npm run build
if errorlevel 1 goto :error

if defined NEW_DATABASE (
    call php artisan migrate --seed --force
) else (
    call php artisan migrate --force
)
if errorlevel 1 goto :error

if not exist public\storage (
    call php artisan storage:link
    if errorlevel 1 goto :error
)

echo Starting the app at http://127.0.0.1:8000
call php artisan serve --host=127.0.0.1
exit /b %errorlevel%

:error
echo Startup failed. Check the error above and try again.
exit /b 1
