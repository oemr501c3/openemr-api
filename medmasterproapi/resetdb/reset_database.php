<?php

$ignoreAuth = true;
require 'classes.php';

$username = $_REQUEST['username'];
$pasword = $_REQUEST['password'];

if (empty($username) || empty($pasword)) {
    die("Empty Username/Password");
} elseif ($username != 'medmasterproadmin' || $pasword != '2e66eb2bb1004abed1b741cf3c7eba0f35c45e50') {
    die("Invalid Username/Password");
}

//die("Executed");

//define('DB_SERVER', '184.72.52.108:3306');
//define('DB_USERNAME', 'admin');
//define('DB_PASSWORD', 'kre52865');
//define('DB_DATABASE', 'openemr1');

extract($GLOBALS['sqlconf']);

define('DB_SERVER', $host); // eg, localhost - should not be empty for productive servers
define('DB_USERNAME', $login);
define('DB_PASSWORD', $pass);
define('DB_DATABASE', $dbase);


mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$dbName = DB_DATABASE;
mysql_select_db($dbName);

$result_t = mysql_query("SHOW TABLES");
while ($row = mysql_fetch_assoc($result_t)) {

    if ($row['Tables_in_' . $dbName] == 'codes' || $row['Tables_in_' . $dbName] == 'lang_constants' || $row['Tables_in_' . $dbName] == 'lang_definitions')
        continue;

    $res = mysql_query("TRUNCATE " . $row['Tables_in_' . $dbName]);
    if ($res)
        echo $row['Tables_in_' . $dbName] . " Truncated <br />";
    else
        echo $row['Tables_in_' . $dbName] . " Failed to Truncated";
}


$dbms_schema = 'openemrrefresh.sql';

SplitSQL($dbms_schema);

function SplitSQL($file, $delimiter = ';') {
    set_time_limit(0);

    if (is_file($file) === true) {
        $file = fopen($file, 'r');

        if (is_resource($file) === true) {
            $query = array();

            while (feof($file) === false) {
                $query[] = fgets($file);

                if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                    $query = trim(implode('', $query));

                    if (mysql_query($query) === false) {
                        echo '<h3>ERROR: </h3>' . "\n";
                    } else {
                        echo '<h3>SUCCESS: </h3>' . "\n";
                    }

                    while (ob_get_level() > 0) {
                        ob_end_flush();
                    }

                    flush();
                }

                if (is_string($query) === true) {
                    $query = array();
                }
            }

            return fclose($file);
        }
    }

    return false;
}

?>