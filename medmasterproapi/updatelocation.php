<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';

	$xml_string = "";
	$xml_string = "<location>";

	$token = $_POST['token'];
	$name = $_POST['name'];
	$locationId = $_POST['id'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	//$name = "Exam 2";
	//$locationId = 10;
	
	if ($userId = validateToken($token)) {
    	$user = getUsername($userId);
		
		$strQuery = 'UPDATE facility SET ';
		$strQuery .= ' name = "'.$name.'"';
		$strQuery .= ' WHERE id = '.$locationId;
    	$result = $db->query($strQuery);

		if ($result) {
			newEvent($event = 'location-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);			
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Location has been updated</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</location>";	
	echo $xml_string;
?>