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
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
/**
 * Database related configuration
 */
define('DB_DRIVER',	    'mysql');
define('DB_HOST',	    'localhost');
define('DB_USERNAME',	'masscan');
define('DB_PASSWORD', 	'changem3');
define('DB_DATABASE', 	'masscan');
define('DB_DEBUG', 1);
