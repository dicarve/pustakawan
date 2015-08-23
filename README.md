# Pustakawan

PUSTAKAWAN ("Librarian" in english) is a web-based tool to enable any Librarian, mostly Reference Librarian or other Information
Professional to create a web-based Pathfinder or Subject Guide. PUSTAKAWAN is released as a free open source software
under GNU GPL version 3. Pustakawan use CodeIgniter 3 framework.
Original Author: Arie Nugraha - dicarve@gmail.com / arie@ui.ac.id.

Installation Requirements
======
1. PHP > 5.3 (5.5 or above is recommended)
2. Web Server with PHP enabled
3. MariaDB/MySQL > 5 database server
4. PHP-PDO MySQL library

Installation
======
1. Extract source code to your web directory (example: /var/www/html or /var/www/htdocs or /xampp/htdocs).
2. Create new database on MariaDB/MySQL server (example: pustakawan).
3. Go to **install** folder and import/dump **install.sql** file to newly created database.
4. Go to **application/config/** folder and open **database.php** file.
5. Search for below lines and change it according to your database connection configuration :

	'dsn'	=> 'mysql:host=localhost;dbname=pustakawan',
	'hostname' => 'localhost',
	'username' => 'pustakawan',
	'password' => 'pathfinder',
	'database' => 'pustakawan'

6. You may have to set *$config['sess_save_path']* variable in **application/config/config.php** file if CodeIgniter show session related error
7. Open browser and navigate to your installation URL (example: http://localhost/pustakawan)
8. The default account for administrator/librarian:

	username : librarian
	password : pathfinder
	
