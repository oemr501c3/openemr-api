<?php 
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<contacts>";
	
	$token = $_POST['token'];
        $user_id = $_POST['userId'];
//	$token = 'b799bd48b6bbbb5f1994e814cd6702d5';
//        $user_id = 2;
        
	if ($userId = validateToken($token)) {		
		$strQuery = "DELETE FROM `users` WHERE id = ".$user_id;
//		echo $strQuery;
                $result = $db->query($strQuery);
	
		if($result) {
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Contact has been deleted</reason>";
		
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}	
	} else {
		$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</contacts>";	
	echo $xml_string;

?>