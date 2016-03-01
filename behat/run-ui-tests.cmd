
IF [%1]==[] (
    set profile=features
) else (
    set profile=%1
)

echo %profile%

rem start phantom js
start /b phantomjs --webdriver=8643

rem run the tests
../vendor/bin/behat --config=behat.yml --profile=%profile% --format=pretty

rem kill phantomjs
taskkill /im phantomjs.exe /f /t
