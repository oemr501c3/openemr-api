<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';
		
	$xml_string = "";
	$xml_string = "<facility>";

	$token = $_POST['token'];
	
	$facilityId = $_POST['id'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$fax = $_POST['fax'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$postal_code = $_POST['postal_code'];
	$country_code = $_POST['country_code'];
	$federal_ein = $_POST['federal_ein'];
	$service_location = $_POST['service_location'];
	$billing_location = $_POST['billing_location'];
	$accepts_assignment = $_POST['accepts_assignment'];
	$pos_code = $_POST['pos_code'];
	$x12_sender_id = $_POST['x12_sender_id'];
	$attn = $_POST['attn'];
	$domain_identifier = $_POST['domain_identifier'];
	$facility_npi = $_POST['facility_npi'];
	$tax_id_type = $_POST['tax_id_type'];
	$color = $_POST['color'];
	
	/*
	$token = 'fe15082d987f3fd5960a712c54494a68';
	$facilityId=8;
	$name = "haro";
	$phone = "73388";
	$fax ="8373939";
	$street = "33 st 33";
	$city = "isbdd";
	$state = "kkp";
	$postal_code = "77333";
	$country_code = "ma";
	$federal_ein = "938666";
	$service_location = "11";
	$billing_location = "4";
	$accepts_assignment = "5";
	$pos_code = "3";
	$x12_sender_id = "ah";
	$attn = "33";
	$domain_identifier = "3";
	$facility_npi = "83";
	$tax_id_type = "63333";
	$color = "#99dffd";
	$primary_business_entity =0;*/

	if ($userId = validateToken($token)) {
    	$user = getUsername($userId);
		
		$strQuery = 'UPDATE facility SET ';
		$strQuery .= 'name  = "'.$name.'",';
		$strQuery .= 'phone = "'.$phone.'",';
		$strQuery .= 'fax = "'.$fax.'",';
		$strQuery .= 'street = "'.$street.'",';
		$strQuery .= 'city = "'.$city.'",';
		$strQuery .= 'state = "'.$state.'",';
		$strQuery .= 'postal_code = "'.$postal_code.'",';
		$strQuery .= 'country_code = "'.$country_code.'",';
		$strQuery .= 'federal_ein = "'.$federal_ein.'",';
		$strQuery .= 'service_location = "'.$service_location.'",';
		$strQuery .= 'billing_location = "'.$billing_location.'",';
		$strQuery .= 'accepts_assignment = "'.$accepts_assignment.'",';
		$strQuery .= 'pos_code = "'.$pos_code.'",';
		$strQuery .= 'x12_sender_id = "'.$x12_sender_id.'",';
		$strQuery .= 'attn = "'.$attn.'",';
		$strQuery .= 'domain_identifier = "'.$domain_identifier.'",';
		$strQuery .= 'facility_npi = "'.$facility_npi.'",';
		$strQuery .= 'tax_id_type = "'.$tax_id_type.'",';
		$strQuery .= 'color = "'.$color.'",';
		$strQuery .= ' WHERE id = '.$facilityId;
		
		$result = $db->query($strQuery);

		if ($result) {
			newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);			
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Facility has been updated</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</facility>";	
	echo $xml_string;
?>