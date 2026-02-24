<?php
session_start();

$getFiles = require_once __DIR__."../../../../vendor/autoload.php";

// For safe extraction
Core::safe_extract($_REQUEST);
// Get configuration options
$config = parse_ini_file(__DIR__."../../../../configuration/configuration.ini",true);

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

define('SC_IV_KEY',$config["secdetails"]["ivKey"]);

foreach($getFiles->getClassMap() as $key => $value) {
	if (preg_match('/models/',$value)) {
		$keyName   = strtolower($key);
		$$keyName  = new $key();
	}
}

$requestParam = "";
foreach ($_POST as $key => $value) {
    $requestParam .= $value;
}
//$_GET['t0k3n1z3d'] = "";
if(isset($_REQUEST['t0k3n1z3d']))
    $getMobileToken    = trim($_REQUEST['t0k3n1z3d']);
$genMobileToken    = trim(md5(hash('sha512',$config['secdetails']['apiKey'])));
//print_r($genMobileToken);
switch ($config["secdetails"]["tokenKey"]) {
    
    case 0: 
        $v     =  $_GET["url"];
        $bcparking =  new BCParking();
        $bcparking->$v($_REQUEST);
    break;
    
    case 1:
        if("$getMobileToken" == "$genMobileToken") {
			//print_r($_GET["url"]);
            $v     =  $_GET["url"];
            $bcparking =  new BCParking();
            $bcparking->$v($_REQUEST);
        } else {
            echo json_encode(array('status' => '3', 'message' => 'Unauthorized access.'));
        }
    break;
        
}
?>
