<?php
	header ("Content-Type:text/xml"); 
	require 'includes/class.database.php';
	require 'includes/functions.php';
	require 'includes/class.arraytoxml.php';
	
	$xml_array = array();
	
	/*$token = $_POST['token'];
	$patientId = $_POST['patientId'];
	$notes = $_POST['notes'];
	$title = $_POST['title'];*/
	
//	$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
//	$patientId = '1';
//	$notes = 'notes will be here';
//	$title = 'title here';
	
	if ($userId = validateToken($token)) {
		$username = getUsername($userId);
		$strQuery = "INSERT INTO pnotes (date, body, pid, user, title, assigned_to, deleted, message_status) 
					 VALUES ('".date('Y-m-d H:i:s')."', '".$notes."', ".$patientId.", '".$username."', '".$title."', '".$username."', 0, 'New')";
		$result = $db->query($strQuery);
		
		if ($result) {	
			$xml_array['status'] = 0;
			$xml_array['reason'] = 'The Patient notes has been added successfully';
		} else {
			$xml_array['status'] = -1;
			$xml_array['reason'] = 'ERROR: Sorry, there was an error processing your data. Please re-submit the information again.';
		}
	} else {
    	$xml_array['status'] = -2;
    	$xml_array['reason'] = 'Invalid Token';
	}
	
	
	$xml = ArrayToXML::toXml($xml_array, 'PatientNotes');
	echo $xml;
?>