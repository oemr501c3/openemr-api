<?php
	//error_reporting(1);
	set_time_limit(0);

	// define our database connection
//	define('DB_SERVER', '71.95.199.108:3306'); // eg, localhost - should not be empty for productive servers
//	define('DB_USERNAME', 'karl');
//	define('DB_PASSWORD', 'crackers1');
//	define('DB_DATABASE', 'openemr');
//        
//        define('DB_SERVER', '184.72.52.108:3306'); // eg, localhost - should not be empty for productive servers
//	define('DB_USERNAME', 'admin');
//	define('DB_PASSWORD', 'kre52865');
//	define('DB_DATABASE', 'openemr');
	
        extract($GLOBALS['sqlconf']);
        
        define('DB_SERVER', $host); // eg, localhost - should not be empty for productive servers
	define('DB_USERNAME', $login);
	define('DB_PASSWORD', $pass);
	define('DB_DATABASE', $dbase);
        
	// ezSQL Constants
	define("EZSQL_VERSION","1.26");
	define("OBJECT","OBJECT",true);
	define("ARRAY_A","ARRAY_A",true);
	define("ARRAY_N","ARRAY_N",true);
?>