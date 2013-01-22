<?php

include_once(dirname(dirname(__FILE__)) . "/openemr/interface/globals.php");
require_once("$srcdir/pid.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/lists.inc");
require_once("$srcdir/pnotes.inc");
require_once("$srcdir/log.inc");
require_once("$srcdir/appointments.inc.php");
require_once("$srcdir/forms.inc");
require_once("$srcdir/billing.inc");
include("includes/class.database.php");
include("includes/class.arraytoxml.php");
include("includes/class.phpmailer.php");
//include 'includes/aes.class.php';


$site = 'default';
$sitesDir = $_SERVER['DOCUMENT_ROOT'] . "/deployement1/openemr1/sites/";

$url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80") {
    $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
} else {
    $url .= $_SERVER["SERVER_NAME"];
}

$sitesUrl = $url . '/deployement1/openemr1/sites/';
$openemrUrl = $url . '/deployement1/openemr1/';

/**
 * above some variables are used in functions file
 */
include("includes/functions.php");

?>