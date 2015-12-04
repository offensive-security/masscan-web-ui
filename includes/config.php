<?php
/**
 * Some general settings
 */
date_default_timezone_set('Europe/Belgrade');
set_time_limit(0);
ini_set("memory_limit","-1");
/**
 * Error reporting settings
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/**
 * Database related configuration
 */
define('DB_DRIVER',		'MySQL');
define('DB_HOST',		'127.0.0.1');
define('DB_USERNAME',	'root');
define('DB_PASSWORD', 	'admin123');
define('DB_DATABASE', 	'masscan');
/**
 * Include the db class
 */
require dirname(__FILE__).'/../lib/class.db.php';
