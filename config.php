<?php
// set debug
$debug = false;

// set error reporting
if($debug){
	error_reporting(E_ALL);
} else {
	error_reporting(E_ALL & ~ (E_NOTICE | E_WARNING | E_DEPRECATED));
}

// require database.class.php
require_once('database.class.php');

// require misc.php
require_once("misc.php");

// define languages
$languages = ['en', 'es', 'ru', 'de', 'fr'];

// define $language
$language = $language[[0]];

// require english language defaults
require_once("lang/$language.php");

// asternic storage / database configuration
[$dbhost, $dbname, $dbuser, $dbpass] = ['127.0.0.1', 'qstats', 'asterisk', 'password'];

// asterisk /etc/asterisk/manager.conf AMI credentials
[$manager_host, $manager_user, $manager_secret] = ['127.0.0.1', 'admin', 'password'];

// define $datbase
$database = new AsternicDB([$dbhost, $dbname, $dbuser, $dbpass]);

try {
	// connect to database
	if(!$database->connect()){
		// unsuccessful connection
	}
} catch(\Exception $e){
	echo 'Exception Occurred: ' . $e->getMessage() . "\n";
}

// define $midb
$midb = $database;

// define $self
$self = $_SERVER['PHP_SELF'];

// initialize session data
session_start();

//session_register("QSTATS");

// send content-type header
header('content-type: text/html; charset: utf-8'); 
?>
