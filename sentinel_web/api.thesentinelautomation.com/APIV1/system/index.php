<?php
session_start();

$getFiles = require_once __DIR__."../../vendor/autoload.php";

// For safe extraction
Core::safe_extract($_REQUEST);

// Get configuration options
$config = parse_ini_file(__DIR__."../../configuration/configuration.ini",true);

// Load php configuration
foreach($config["phpconfig"] as $phpconfig=>$phpval) {
    ini_set($phpconfig,$phpval);
}
global $dbh;

// Define database configurations
define('DB_USERNAME',$config["database"]["user"]);
define('DB_PASSWORD',$config["database"]["pass"]);
define('DB_HOSTNAME',$config["database"]["host"]);
define('DB_NAME',$config["database"]["prefix"].$config["database"]["name"]);
define('DB_TYPE',$config["database"]["type"]);

define('PREFIX',$config["table"]["prefix"]);



foreach($getFiles->getClassMap() as $key => $value) {
	if (preg_match('/models/',$value)) {
		$keyName   = strtolower($key);
		$$keyName  = new $key();
	}
}
?>


