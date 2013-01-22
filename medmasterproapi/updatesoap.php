<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	//ini_set('display_errors', '1');
	require 'classes.php';
	$xml_string = "";
	$xml_string = "<soap>";
	
	$token = $_POST['token'];
//	$patientId = $_POST['patientId'];
//	$visit_id = $_POST['visit_id'];
	
	$soapId = $_POST['id'];
	$subjective = mysql_real_escape_string($_POST['subjective']);
	$objective = mysql_real_escape_string($_POST['objective']);
	$assessment = $_POST ['assessment'];
	$plan = mysql_real_escape_string($_POST['plan']);
	
	/*	
	$token = 'fe15082d987f3fd5960a712c54494a68';
	$patientId = 1;
	$soapId = 15;
	$subjective = "subject";
	$objective = "jective";
	$assessment = "ssessment";
	$plan = "lan";*/

if ($userId = validateToken($token)) {
    $user = getUsername($userId);

	$strQuery = 'UPDATE form_soap SET ';
			$strQuery .= ' subjective = "'.$subjective.'",';
			$strQuery .= ' objective = "'.$objective.'",';
			$strQuery .= ' assessment = "'.$assessment.'",';
			$strQuery .= ' plan = "'.$plan.'"';
			$strQuery .= ' WHERE id = '.$soapId;

	//echo $strQuery;
   	$result = $db->query($strQuery);

		if ($result) {
			newEvent($event = 'soap-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);	
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Soap has been updated</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    	$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</soap>";	
	echo $xml_string;
?>