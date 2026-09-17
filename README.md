RD-10 CI4 PHP 8.1 CRM

This build is pinned to CodeIgniter 4.6.5 for PHP 8.1 compatibility.

XAMPP project path:
C:\xamp8 version\htdocs\CamllonCRM

Setup:
1. Import database.sql in phpMyAdmin.
2. Open CMD in project folder.
3. Use the XAMPP PHP explicitly:
   "C:\xamp8 version\php\php.exe" "C:\ProgramData\ComposerSetup\bin\composer.phar" install
4. Open:
   http://localhost/CamllonCRM/public/

Demo:
admin@rd10.local / Admin@123
user@rd10.local / User@123

The project uses normalized Materials, Monthly Stock and Daily Entry entities rather than copying the 206-column spreadsheet. Decimal quantities are supported.
"# RDCRM" 
