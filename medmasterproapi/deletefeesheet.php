<?php 
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<feesheet>";
	
	$token = $_POST['token'];
	$id=$_POST['id'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	//$id=80;

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
	
	deleteBilling($id);
		
		$xml_string .= "<status>0</status>";
		$xml_string .= "<reason>The Feesheet Item has been deleted</reason>";
		
		
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</feesheet>";	
	echo $xml_string;
?>