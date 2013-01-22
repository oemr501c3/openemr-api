<?php
	header ("Content-Type:text/xml"); 
	require 'includes/class.database.php';
	require 'includes/functions.php';
	require 'includes/class.arraytoxml.php';
	
	$xml_array = array();
	
	$token = $_POST['token'];
	$patientId = $_POST['patientId'];
	$noteId = $_POST['noteId'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$notes = $_POST['notes'];

	
//	$patientId = '1';
//	$noteId = '2';
//	$firstname = 'mas';
//	$lastname = 'an';
//	$phone = '1235412351234';
//	$dob = '01/01/1980';
//	$gender = 'Male';
//	$notes = "update patient notes";
	
	if ($userId = validateToken($token)) {
		$strQuery  = "UPDATE patient_data SET fname = '".$firstname."',
					  lname = '".$lastname."',
					  DOB = '". date('Y-m-d', strtotime($dob)) ."',
					  phone_contact = ".$phone.", 
					  sex = '".$gender."' 
					  WHERE id = ".$patientId;
		$result = $db->query($strQuery);
		
		if ($result) {
			if (isset($noteId)) {
				$username = getUsername($userId);
				$strQuery  = "UPDATE pnotes SET date = '".date('Y-m-d H:i:s')."', body = '".$notes."', user = '".$username."', assigned_to = '".$username."' WHERE id = ".$noteId;
				$db->query($strQuery);
			}
				
			$xml_array['status'] = 0;
			$xml_array['reason'] = 'Patient updated successfully';
		} else {
			$xml_array['status'] = -1;
			$xml_array['reason'] = 'Could not update patient';
		}
	} else {
    	$xml_array['status'] = -2;
    	$xml_array['reason'] = 'Invalid Token';
	}
	
	$xml = ArrayToXML::toXml($xml_array, 'Patient');
	echo $xml;
?>