<?php 
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<payment>";
		

	$token = $_POST['token'];
	
	$payer_id = $_POST['payer_id'];
	$closed=0;
	$modified_time = date('Y-m-d H:i:s');
	$pay_total = $_POST['pay_total'];
	$payment_method = $_POST['payment_method'];
	$check_ref_number = $_POST['check_ref_number'];
	$check_date=$_POST['check_date'];
	$post_to_date= $_POST['post_to_date'];
	$deposit_date= $_POST['deposit_date'];
	$patient_id= $_POST['patient_id'];
	$description = mysql_real_escape_string($_POST['description']);
	$payment_category = $_POST['payment_category']; 
	$payment_type = $_POST['payment_type'];
	$global_amount = $_POST['global_amount'];

	/*$token = 'fe15082d987f3fd5960a712c54494a68';
	$payer_id = '0';  
	$patient_id = '1';  
	$user_id = '1';  
	$closed = '0';  
	$check_ref_number = '2353345';  
	$check_date = '2012-09-24';  
	$deposit_date = '2012-09-24';  
	$pay_total = '100.00';  
	$modified_time = '2012-09-24 09:55:32';  
	$payment_type = 'patient';  
	$description = 'Khan Bilal';  
	$payment_category = 'patient_payment';  
	$post_to_date = '2012-09-24';  
	$payment_method = 'check_payment';
	$global_amount = '0.00';*/

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
	
	$strQuery = "INSERT INTO `ar_session`(`user_id`, `closed`, `reference`, `check_date`, `deposit_date`, `pay_total`, `created_time`, `modified_time`, `global_amount`, `payment_type`, `description`, `adjustment_code`, `post_to_date`, `patient_id`, `payment_method`) VALUES ('".$userId."', '".$closed."', '".$check_ref_number."', '".$check_date."','".$deposit_date."', '".$pay_total."', '".date('Y-m-d H:i:s')."', '".$modified_time."', '".$global_amount."', '".$payment_type."', '".$description."', '".$payment_category."', '".$post_to_date."', '".$patient_id."', '".$payment_method."')";
	
	$result = $db->query($strQuery);
	
	if ($result) {
			newEvent($event = 'other-insert', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);						
			$xml_string .= "<status>0</status>";
			$xml_string .= "<reason>The Payment has been added</reason>";
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
	} else {
    		$xml_string .= "<status>-2</status>";	
			$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</payment>";	
	echo $xml_string;
?>