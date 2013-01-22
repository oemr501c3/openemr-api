<?php
	header ("Content-Type:text/xml");
	$ignoreAuth = true;
	require('classes.php');
	require_once("$srcdir/classes/RXList.class.php");

	$xml_string = "";
	$xml_string = "<list>";
	
	$token = $_POST['token'];
	$query= $_POST['name'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	//$query= 'h';
	
	$drugList = new RxList();
	$result= $drugList->get_list($query);
	
	if ($userId = validateToken($token)) {
 		$user = getUsername($userId);
		if (!empty($result)) {
			
		newEvent($event = 'view-drug-list', $user, $groupname = 'Default', $success = '1', $comments = '');
		$xml_string .= "<status>0</status>\n";
    	$xml_string .= "<reason>Success processing drugs list records</reason>\n";
		
		foreach($result as $rows){
				
				$xml_string .= "<drug>".$rows."</drug>";

		}
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>Could not find results</reason>";
			}
	} else {
		$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
			
	$xml_string .= "</list>";	
	echo $xml_string;
?>