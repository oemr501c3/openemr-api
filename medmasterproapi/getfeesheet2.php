<?php 
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';
	
	$xml_string = "";
	$xml_string = "<feesheet>";
	
	$token = $_POST['token'];
	$visit_id = $_POST['visit_id'];
	$discountAmount=$_POST['discountAmount'];
	
	//$token = 'fe15082d987f3fd5960a712c54494a68';
	//$visit_id=15;

	
if ($userId = validateToken($token)) {
 	$user = getUsername($userId);
	$strQuery = "SELECT date, units, fee FROM `billing` WHERE encounter =".$visit_id;
		$result = $db->get_results($strQuery);
	
	if($result) {
        newEvent($event = 'checkout-record-get', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);	
			
		$feeSum = 0;
			for($i=0; $i<count($result); $i++) {
				$xml_string .= "<item>\n";
				
				foreach($result[$i] as $fieldName => $fieldValue) {
					if($fieldName == 'fee')
						$feeSum += $fieldValue;
					$rowValue = xmlsafestring($fieldValue);
					$xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
				}
				$xml_string .= "</item>\n";
				
			}
				
				$xml_string .= "<feeSum>".$feeSum."</feeSum>";
				
		} else {
			$xml_string .= "<status>-1</status>";	
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
		}
		} else {
		$xml_string .= "<status>-2</status>";	
		$xml_string .= "<reason>Invalid Token</reason>";
	}
	
	$xml_string .= "</feesheet>";	
	echo $xml_string;

?>