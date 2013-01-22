<?php
	header ("Content-Type:text/xml"); 
	$ignoreAuth = true;
	require 'classes.php';;
	
//	$token = $_POST['token'];
//	$catType = isset($_POST['catType'])?$_POST['catType']:"0"; 

$token = '8c8ac0c8581785e6f3faf24485a63efa';
	
	$xml_string = "";
	$xml_string .= "<Appointmentscategories>\n";


	if ($userId = validateToken($token)) {    
            $user_data = getUserData($userId);
            $user = $user_data['user'];
            $emr = $user_data['emr'];
            $username = $user_data['username'];
            $password = $user_data['password'];
            switch ($emr) {
            case 'openemr':
		$strQuery = "SELECT pc_catid,pc_catname
                                FROM `openemr_postcalendar_categories`
                                WHERE pc_cattype = ".$catType;
		
               
		$dbresult = $db->query($strQuery);
		
		if ($dbresult) {	
			$xml_string .= "<status>0</status>\n";
			$xml_string .= "<reason>The Appointment categories records has been fetched</reason>\n";
			$counter = 0;

			while($row = $db->get_row($query=$strQuery,$output=ARRAY_A,$y=$counter)) {
				$xml_string .= "<Appointmentcategory>\n";

				foreach ($row as $fieldname => $fieldvalue) {	  						 		
					$rowvalue = xmlsafestring($fieldvalue);
					$xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
				} 
				
				$xml_string .= "</Appointmentcategory>\n";
				$counter++;
			}
		} else {
			$xml_string .= "<status>-1</status>\n";
			$xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>\n";
		}
                 break;
        case 'greenway';
            include 'greenway/ScheduleAppointmentTypesGet.php';
            break;
    }//sWITCH eND hERE
	} else {
    	$xml_string .= "<status>-2</status>\n";
		$xml_string .= "<reason>Invalid Token</reason>\n";
	}
	
	
	$xml_string .= "</Appointmentscategories>\n";
	echo $xml_string;
?>