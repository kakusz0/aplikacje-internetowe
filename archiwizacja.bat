@echo off
REM Podaj swój numer albumu poniżej:
set ALBUM=131358

REM Ustaw nazwę archiwum
set NAZWA=%ALBUM%_AI1_projekt.zip

REM Tworzymy archiwum git (pomija vendor i node_modules automatycznie)
git archive --format=zip -o "%NAZWA%" HEAD

REM Informacja dla użytkownika
echo Gotowe! Archiwum zapisane jako %NAZWA%
pause