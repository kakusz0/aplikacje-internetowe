@echo off
setlocal

REM Krok 1: Composer install
echo [1/4] composer install
start /wait cmd /c "composer install"

REM Krok 2: Migracje + seed
echo [2/4] php migrate:fresh --seed
start /wait cmd /c "php -d memory_limit=4096M artisan migrate:fresh --seed"

REM Krok 3: Generowanie klucza
echo [3/4] php artisan key:generate
start /wait cmd /c "php artisan key:generate"

REM Krok 4: Uruchamianie serwera (bez zamykania)
echo [4/4] php artisan serve
start cmd /k "php artisan serve"

endlocal
