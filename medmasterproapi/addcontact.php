<?php
	header ("Content-Type:text/xml");
	$ignoreAuth = true; 
	require ("classes.php");
	
	$xml_string = "";
	$xml_string = "<Contact>";
	
	$token = $_POST['token'];
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

	/*$token = 'a9b450867020dc6bb08f3c94f9f3efe9';
	$title = 'Mr';
	$firstname = 'Masood';
	$lastname = 'Anwer';
	$middlename = 'Ahmed';
	$upin = '11';
	$npi = '22';
	$taxonomy = 'texanomy';
	$specialty = 'se';
	$organization = 'ABC COMPANY';
	$valedictory = 'valedi';
	$assistant = 'ass';
	$email = 'bilal@hotmail.com';
	$url = 'www.abcompany.net';
	$street = 'street1';
	$streetb = 'street2';
	$city = 'New York';
	$state = 'NY';
	$zip = '10292';
	$home_phone = '23234234234';
	$work_phone1 = '2266425';
	$work_phone2 = '2266426';
	$mobile	= '4660895';
	$fax = '4660895';
	$notes = 'contact notes will be here....';*/
	
	
	if ($userId = validateToken($token)) {
            $provider_id = getUserProviderId($userId);
		$strQuery = "INSERT INTO users ( username, password, authorized, info, source, title, fname, lname, mname,  upin, see_auth, active, npi, taxonomy, specialty, organization, valedictory, assistant, email, url, street, streetb, city, state, zip, phone, phonew1, phonew2, phonecell, fax, notes ) 
                    VALUES ( '".$provider_id."', '', 0, '', NULL, '".$title."', '".$firstname."', '".$lastname."', '".$middlename."', '".$upin."', 0, 1, '".$npi."', '".$taxonomy."', '".$specialty."', '".$organization."', '".$valedictory."', '".$assistant."', '".$email."', '".$url."', '".$street."', '".$streetb."', '".$city."', '".$state."', '".$zip."', '".$home_phone."', '".$work_phone1."', '".$work_phone2."', '".$phonecell."', '".$fax."', '".$notes."' )";
		$result = $db->query($strQuery);
		
		if ($result) {			
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Contact has been added</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</Contact>";	
	echo $xml_string;
?>