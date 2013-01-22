<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';

	$xml_string = "";
	$xml_string = "<contact>";


	$token = $_POST['token'];
	$id = $_POST['id'];
	$title = $_POST['title'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$middlename = $_POST['middlename'];
	$upin = $_POST['upin'];
	$npi = $_POST['npi'];
	$taxonomy = $_POST['taxonomy'];
	$specialty = $_POST['specialty'];
	$organization = $_POST['organization'];
	$valedictory = $_POST['valedictory'];
	$assistant = $_POST['assistant'];
	$email = $_POST['email'];
	$url = $_POST['url'];
	$street = $_POST['street'];
	$streetb = $_POST['streetb'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$home_phone = $_POST['home_phone'];
	$work_phone1 = $_POST['work_phone1'];
	$work_phone2 = $_POST['work_phone2'];
	$mobile	= $_POST['mobile'];
	$fax = $_POST['fax'];
	$notes = $_POST['notes'];
	
//	$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
//	$id = 11;
//	$title = 'Mr';
//	$firstname = 'Masood';
//	$lastname = 'Anwer';
//	$middlename = 'Ahmed';
//	$upin = '22';
//	$npi = '11';
//	$taxonomy = 'texanomy';
//	$specialty = 'se';
//	$organization = 'XYZ COMPANY';
//	$valedictory = 'valedi';
//	$assistant = 'ass';
//	$email = 'masood_anwer@hotmail.com';
//	$url = 'www.abcompany.net';
//	$street = 'street1';
//	$streetb = 'street2';
//	$city = 'New York';
//	$state = 'NY';
//	$zip = '10292';
//	$home_phone = '23234234234';
//	$work_phone1 = '2266425';
//	$work_phone2 = '2266426';
//	$mobile	= '4660895';
//	$fax = '4660895';
//	$notes = 'contact notes will be here....';


	if ($userId = validateToken($token)) {
		$strQuery = 'UPDATE users SET ';
		$strQuery .= ' password = "'.$password.'",';
		$strQuery .= ' authorized = "'.$authorized.'",';
		$strQuery .= ' info = "'.$info.'",';
		$strQuery .= ' source = "'.$source.'",';
		$strQuery .= ' title = "'.$title.'",';
		$strQuery .= ' fname = "'.$firstname.'",';
		$strQuery .= ' lname = "'.$lastname.'",';
		$strQuery .= ' mname = "'.$middlename.'",';
		$strQuery .= '  upin = "'.$upin.'",';
		$strQuery .= ' see_auth = "'.$see_auth.'",';
		$strQuery .= ' active = "'.$active.'",';
		$strQuery .= ' npi = "'.$npi.'",';
		$strQuery .= ' taxonomy = "'.$taxonomy.'",';
		$strQuery .= ' specialty = "'.$specialty.'",';
		$strQuery .= ' organization = "'.$organization.'",';
		$strQuery .= ' valedictory = "'.$valedictory.'",';
		$strQuery .= ' assistant = "'.$assistant.'",';
		$strQuery .= ' email = "'.$email.'",';
		$strQuery .= ' url = "'.$url.'",';
		$strQuery .= ' street = "'.$street.'",';
		$strQuery .= ' streetb = "'.$streetb.'",';
		$strQuery .= ' city = "'.$city.'",';
		$strQuery .= ' state = "'.$state.'",';
		$strQuery .= ' zip = "'.$zip.'",';
		$strQuery .= ' phone = "'.$home_phone.'",';
		$strQuery .= ' phonew1 = "'.$work_phone1.'",';
		$strQuery .= ' phonew2 = "'.$work_phone2.'",';
		$strQuery .= ' phonecell = "'.$mobile.'",';
		$strQuery .= ' fax = "'.$fax.'",';
		$strQuery .= ' notes = "'.$notes.'"';
		$strQuery .= ' WHERE id = '.$id;
	
    	$result = $db->query($strQuery);

		if ($result) {			
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Contact has been updated</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</contact>";	
	echo $xml_string;
?>