<?php
//  $link = mysqli_connect("powersoap-prod.chg50kkzcly2.ap-south-1.rds.amazonaws.com", "admin", 's0jqfpTt4IRUWdMslPys', "powersoapp_live");
 
// Centralized Database Credentials
define('DB_HOST', 'localhost');//13.233.168.165'
define('DB_USER', 'powersdev');//dev_usr
define('DB_PASS', 'o6fvaVZo4le9');//6ih48VMG88Ir
define('DB_NAME', 'powersoapdev');

// Centralized URL Configuration
define('APP_ROOT_URL', 'http://3.6.232.118/');
define('BASE_URL', APP_ROOT_URL . 'stage/');

// Environment Specific Folder Configuration
// Change this to the sub-folder path of the server, typically '/stage/'
define('APP_FOLDER_PATH', '/stage/');

// PDF Generation Absolute Path 
// (For local, use $_SERVER['DOCUMENT_ROOT'] . '/powersoap_live-main/stage/invoice_pdf/')
// (For server, use '/home/powersoapstage/public_html/stage/invoice_pdf/')
define('PDF_GENERATOR_PATH', '/var/www/powersoapdev/stage/invoice_pdf/');

// Employee Asset URL (Used by Mobile/API Apps)
// Local: 'http://3.6.232.118/powersoap_live-main/stage/assets/' 
// Server: 'https://powersoaps.online/stage/assets/' or 'https://powersoapapp.in/development/assets/' depending on environment
define('EMPLOYEE_ASSET_URL', APP_ROOT_URL . 'stage/assets/');
?>
