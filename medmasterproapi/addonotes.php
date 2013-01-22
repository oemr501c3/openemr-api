<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';
	include_once("$srcdir/onotes.inc");
	//ini_set('display_errors', '1');
	
	$xml_string = "";
	$xml_string .= "<officenote>";
	
	$token = $_POST['token'];
	$body = $_POST['body'];
	
//	$token = 'fe15082d987f3fd5960a712c54494a68';
//	$body = "hello Haroon";
	
if ($userId = validateToken($token)) {
 	$user = getUsername($userId);
	
		addOnote($body);

	$xml_string .= "<status>0</status>\n";
   	$xml_string .= "<reason>Office Note Added Successfully</reason>\n";
					
	} else {
    		$xml_string .= "<status>-2</status>";
    		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</officenote>";	
	echo $xml_string;

?>