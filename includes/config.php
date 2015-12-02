<?php
/**
 * 
 */
date_default_timezone_set('Europe/Belgrade');
set_time_limit(0);
ini_set("memory_limit","-1");
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/**
 * Database related configuration
 */
define('DB_DRIVER',	'MySQL');
define('DB_HOST',	'localhost');
define('DB_USERNAME',	'masscan');
define('DB_PASSWORD', 	'changem3');
define('DB_DATABASE', 	'masscan');

/*
 * Include the db class
 */
require dirname(__FILE__).'/../lib/class.db.php';

/**
 * Some common functions
 */
function pre_var_dump($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

/*
 * NOTICE : Approximate, assumes months have 30 days.
 */
function seconds2human($ss) 
{
	$s = $ss%60;
	$mins = floor(($ss%3600)/60);
	$hours = floor(($ss%86400)/3600);
	$days = floor(($ss%2592000)/86400);
	$months = floor($ss/2592000);
	$text = '';
	if ($months>0) {
		$text .= $monts." months,";
	}
	if ($days > 0) {
		$text .= $days." days,";
	}
	if ($hours > 0) {
		$text .= $hours." hours,";
	}
	if ($mins > 0) {
		$text .= $mins." minutes,";
	}
	if ($s > 0) {
		$text .= $s." seconds";
	}
	return $text;
}
