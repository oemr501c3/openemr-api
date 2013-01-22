<?php
	header ("Content-Type:text/xml"); 
	require 'includes/class.database.php';
	require 'includes/functions.php';
	require 'includes/class.arraytoxml.php';
	
	$xml_array = array();
	
	$token = $_POST['token'];
	$noteId = $_POST['noteId'];
	$patientId = $_POST['patientId'];
	$notes = $_POST['notes'];
	$title = $_POST['title'];
	
	/*$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
	$noteId = '2';
	$patientId = '1';
	$notes = 'update notes will be here';
	$title = 'update title here';*/
	
	if ($userId = validateToken($token)) {
		$username = getUsername($userId);
		$strQuery  = "UPDATE pnotes SET date = '".date('Y-m-d H:i:s')."', body = '".$notes."', user = '".$username."', title = '".$title."', assigned_to = '".$username."' WHERE id = ".$noteId;
		$result = $db->query($strQuery);
		
		if ($result) {	
			$xml_array['status'] = 0;
			$xml_array['reason'] = 'The Patient notes has been updated';
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