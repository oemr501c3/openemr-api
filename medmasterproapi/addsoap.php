<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<soap>";
	
	$token = $_POST['token'];
	$patientId = $_POST['patientId'];
	$visit_id = $_POST['visit_id'];
	
	$groupname = isset($_POST['groupname'])?$_POST['groupname']:NULL;
	$subjective = $_POST['subjective'];
	$objective = $_POST['objective'];
	$assessment = $_POST ['assessment'];
	$plan = $_POST['plan'];
	$authorized = isset($_POST['authorized'])?$_POST['authorized']:0;
	$activity = isset($_POST['activity'])?$_POST['activity']:1;
	/*
	$token = 'fe15082d987f3fd5960a712c54494a68';
	$patientId = 1;
	$groupname = 3;
	$subjective = "subject";
	$objective = "objective";
	$assessment = "assessment";
	$plan = "plan";
	$authorized = 0;
	$activity = 1;
	$visit_id=3;*/

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
	$strQuery = "INSERT INTO form_soap 
            (pid, user, date, groupname, authorized, activity, subjective, objective, assessment,  plan) 
            VALUES (" . $patientId . ", '" . $user . "', '" . date('Y-m-d H:i:s') . "','" . $groupname . "', '" . $authorized . "','" . $activity . "',  '" . $subjective . "' , '" . $objective . "' , '" . $assessment . "', '" . $plan . "')";
			
    $result = $db->query($strQuery);
	$last_inserted_id = mysql_insert_id();
    
	if ($result) {
        newEvent($event = 'soap-record-add', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);	
		addForm($visit_id, $form_name = 'SOAP', $last_inserted_id, $formdir = 'soap', $patientId, $authorized = "1", $date = "NOW()", $user, $group = "Default");

        	$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Soap has been added</reason>";
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