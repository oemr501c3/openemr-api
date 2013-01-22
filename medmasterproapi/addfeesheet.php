<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	//ini_set('display_errors', '1');
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<feesheet>";
	
	$token = $_POST['token'];
	
	$patientId = $_POST['patientId'];
	$visit_id = $_POST['visit_id'];
	$provider_id = $_POST['provider_id'];
	$supervisor_id = $_POST['supervisor_id'];
	$auth = $_POST['auth'];
	$code_type = $_POST['code_type'];
	$code = $_POST['code'];
	$modifier = $_POST['modifier'];
	$units = max(1, intval(trim($_POST['units'])));
	$price = $_POST['price'];
	$priceLevel=$_POST['priceLevel'];
	$justify   = $_POST['justify'];
	
   	/*$token = 'fe15082d987f3fd5960a712c54494a68';
	
	$justify ='';
	$patientId =1;	
	$visit_id = 47;
	$modifier = 98373;
	$price = 3;
	$units = 6;
	$priceLevel='standard';
	$code_type = "CPT4";
	$supervisor_id = 1;
	$provider_id = 9;
	$auth ="1";*/
	

	$ndc_info = !empty($_POST['ndc_info'])?$_POST['ndc_info']:'';
	$noteCodes = !empty($_POST['noteCodes'])?$_POST['noteCodes']:'';
	$fee   = sprintf('%01.2f',(0 + trim($price)) * $units);
	

if ($userId = validateToken($token)) {
    $user = getUsername($userId);

addBilling($visit_id, $code_type, $code, $code_text, $patientId, $auth, $provider_id, $modifier, $units, $fee, $ndc_info, $justify, 0, $noteCodes);

	$strQuery1 = 'UPDATE `patient_data` SET';
			$strQuery1 .= ' pricelevel  = "'.$priceLevel .'"';
			$strQuery1 .= ' WHERE pid = '.$patientId;
	
	$result1 = $db->query($strQuery1);

	$strQuery2 = 'UPDATE `form_encounter` SET';
			$strQuery2 .= ' provider_id  = "'.$provider_id .'",';
			$strQuery2 .= ' supervisor_id  = "'.$supervisor_id .'"';
			$strQuery2 .= ' WHERE pid = '.$patientId.' AND encounter = '.$visit_id;
	
	$result2 = $db->query($strQuery2);

if ($result1 && $result2) {
    newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery1);
    newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery2);
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>Fee Sheet added successfully</reason>";
		}
	} else {
    		$xml_string .= "<status>-2</status>";	
			$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</feesheet>";	
	echo $xml_string;
?>