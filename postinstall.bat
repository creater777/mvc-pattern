@echo off
set dir=web\res
if not exist %dir% (
  mkdir %dir%
)
copy vendor\twitter\bootstrap\dist\css\*.min.css %dir%\
copy vendor\twitter\bootstrap\dist\css\*.min.css.map %dir%\
copy vendor\twitter\bootstrap\dist\js\*.min.js %dir%\
copy vendor\twitter\bootstrap\dist\js\*.min.js.map %dir%\
