chapter-manager
===============

Always Perfecting Organization manager


Setting up your development environment
===============
Installing programs


PHP should be <= 5.3 as the code currently depends on depreciated session functions, which is removed as of 5.4

Windows

Install Wamp or equivalent

Wamp

32 bit
http://sourceforge.net/projects/wampserver/files/WampServer%202/WampServer%202.2/wampserver2.2e/wampserver2.2e-php5.3.13-httpd2.2.22-mysql5.5.24-32b.exe/download

64 bit
http://sourceforge.net/projects/wampserver/files/WampServer%202/WampServer%202.2/wampserver2.2e/wampserver2.2e-php5.3.13-httpd2.2.22-mysql5.5.24-x64.exe/download


Mac

1. Install MAMP or equivalent 
2. MAMP and PHP 5.3 (two seperate links)
http://www.mamp.info/en/downloads/


Linux

Install Apache, MySQL or MariaDB, PHP(<= 5.3), phpMyAdmin (optional, but used in the following instructions) from repositories


==============
Configuring settings


Creating a MySQL user with phpMyAdmin

1. Log in as root
2. Click "Users" in the top menu bar
3. Click "Add user"
4. Under Login Information
5. Set a user name and password. For our example we'll use "apo" and "dbPW" respectively
6. Select host "Local"
7. Under Database for user
8. Click the radio button for "Create database with same name and grant all privileges"
9. Under Global privileges
10. Check box "SELECT" under Data
11. Click lower button "Add user"
12. Sign out of phpMyAdmin

Increasing allowable import size (to allow the import of the database)

1. Edit the php.ini file (usually located in the installation at php5/apache2/php.ini)
2. Set memory_limit = 128M if it is not already
3. Set post_max_size = 100M if it is not already
4. Set upload_max_filesize = 98M if it is not already
5. Restart your Apache installation

Importing the database

1. Log in to phpMyAdmin(http://localhost/phpmyadmin) with the user created earlier (user=apo password=dbPW)
2. Select database with the same name as username from the left panel (in this case apo)
3. Select "Import" from the top menu
4. Click the "Choose File" button and select the file apo.sql from the file select dialog
5. Click the "Go" button at the bottom of the page

Setting up the server

1. Copy the files from Github to Apache's "www" folder
2. Modify mysql_access.php with the username/password set earlier (set to apo/dbPW by default)

=============
Your site should now be configured - Test by going to http://localhost
