<?php
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';;
	
	$token = $_POST['token'];

	//$token = 'f12dab7305cd43b68db8551008f9f9a6';
	
	$xml_string = "";
	$xml_string .= "<users>\n";


	if (validateToken($token)) {
		$strQuery = "SELECT id,fname,lname,mname, username
                                FROM `users`
                                WHERE username != '' AND password != '' AND active = 1";
		
               
		$dbresult = $db->query($strQuery);
		
		if ($dbresult) {	
			$xml_string .= "<status>0</status>\n";
			$xml_string .= "<reason>The User list Record has been fetched</reason>\n";
			$counter = 0;

			while($row = $db->get_row($query=$strQuery,$output=ARRAY_A,$y=$counter)) {
				$xml_string .= "<user>\n";

				foreach ($row as $fieldname => $fieldvalue) {	  						 		
					$rowvalue = xmlsafestring($fieldvalue);
					$xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
				} 
				
				$xml_string .= "</user>\n";
				$counter++;
			}
		} else {
			$xml_string .= "<status>-1</status>\n";
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>\n";
		}
	} else {
    	$xml_string .= "<status>-2</status>\n";
		$xml_string .= "<reason>Invalid Token</reason>\n";
	}
	
	
	$xml_string .= "</users>\n";
	echo $xml_string;
?>