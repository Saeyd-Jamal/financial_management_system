@echo off
setlocal enabledelayedexpansion

:: الحصول على التاريخ والوقت الحاليين
for /f "tokens=2 delims==" %%i in ('"wmic os get localdatetime /value"') do set datetime=%%i

:: تنسيق التاريخ والوقت
set year=!datetime:~0,4!
set month=!datetime:~4,2!
set day=!datetime:~6,2!
set hour=!datetime:~8,2!
set minute=!datetime:~10,2!
set second=!datetime:~12,2!

set formatted_datetime=!year!-!month!-!day!_!hour!-!minute!-!second!

:: تنفيذ أمر mysqldump مع اسم الملف الذي يحتوي على التاريخ والوقت
mysqldump --user=root --password= --host=localhost financial_management_system > D:\xammp\htdocs\technova\backup_%formatted_datetime%.sql
