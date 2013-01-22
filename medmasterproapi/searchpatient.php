<?php
	header ("Content-Type:text/xml"); 
	require 'includes/class.database.php';
	require 'includes/functions.php';
	
	$token = $_POST['token'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	
	/*$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
	$firstname = 'mas';
	$lastname = 'an';*/
 	
	$xml_string = "";
	$xml_string .= "<PatientList>\n";


	if (validateToken($token)) {
		$strQuery = "SELECT id, pid, fname as firstname, lname as lastname, phone_contact as phone, dob, sex as gender FROM patient_data WHERE fname Like '".$firstname."' OR lname Like '".$lastname."'";
		$result = $db->query($strQuery);
		
		if ($result) {	
			$xml_string .= "<status>0</status>\n";
			$xml_string .= "<reason>Success processing patients records</reason>\n";
			$counter = 0;

			while($row = $db->get_row($query=$strQuery,$output=ARRAY_A,$y=$counter)) {
				$xml_string .= "<Patient>\n";

				foreach ($row as $fieldname => $fieldvalue) {	  						 		
					$rowvalue = xmlsafestring($fieldvalue);
					$xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
				} 
				
				$xml_string .= "</Patient>\n";
				$counter++;
			}
		} else {
			$xml_string .= "<status>-1</status>\n";
			$xml_string .= "<reason>Could not find results</reason>\n";
		}
	} else {
    	$xml_string .= "<status>-2</status>\n";
		$xml_string .= "<reason>Invalid Token</reason>\n";
	}
	
	
	$xml_string .= "</PatientList>\n";
	echo $xml_string;
?>