<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';
	include_once("$srcdir/onotes.inc");
	//ini_set('display_errors', '1');
	
	$xml_string = "";
	$xml_string .= "<officenotes>";
	
	$token = $_POST['token'];
	$body = $_POST['body'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	
	
if ($userId = validateToken($token)) {
 	$user = getUsername($userId);
	
	$result = getOnoteByDate("", 1, "date,body,user","all",0);

		$xml_string .= "<status>0</status>\n";
    	$xml_string .= "<reason>Success processing insurance companies records</reason>\n";					

	foreach ($result as $iter) {
	
		$xml_string .=	"<officenote>\n";
		$xml_string .= 	"<date>$iter[date]</date>\n";
		$xml_string .= 	"<user>$iter[user]</user>\n";
		$xml_string .= 	"<body>$iter[body]</body>\n";
		$xml_string .=	"</officenote>\n";
	}

	} else {
    	$xml_string .= "<status>-2</status>";
    	$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</officenotes>";	
	echo $xml_string;

?>