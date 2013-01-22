<?php
	header("Content-Type:text/xml");
	$ignoreAuth = true;
	require('classes.php');
	//ini_set('display_errors', '1');
	$xml_string = "";
	$xml_string .= "<PatientVitals>\n";
	
	//$token = 'b799bd48b6bbbb5f1994e814cd6702d5';
	//$visit_id = 13;
	
	$token = $_POST['token'];
	$visit_id = $_POST['visit_id'];
	//$patientId = $_POST['patientId'];
	
	if (validateToken($token)) {

	//    $strQuery = "SELECT * FROM `form_vitals` WHERE pid=" . $patientId." ORDER BY `date` DESC";
    $strQuery = "SELECT fv.* 
                                FROM  `forms` AS f
                                INNER JOIN  `form_vitals` AS fv ON f.form_id = fv.id
                                WHERE  `encounter` = {$visit_id}
                                AND  `form_name` =  'Vitals'
                                ORDER BY f.id DESC";
    $result = $db->get_results($strQuery);

    if ($result) {
        $xml_string .= "<status>0</status>\n";
        $xml_string .= "<reason>Success processing patient vitals records</reason>\n";

        for ($i = 0; $i < count($result); $i++) {
            $xml_string .= "<Vital>\n";

            foreach ($result[$i] as $fieldName => $fieldValue) {
                $rowValue = xmlsafestring($fieldValue);
                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
            }

			$user_query = "SELECT  `firstname` ,  `lastname` 
											FROM  `medmasterusers` 
											WHERE username LIKE  '{$result[$i]->user}'";
			$user_result = $db->get_row($user_query);
			$xml_string .= "<firstname>{$user_result->firstname}</firstname>\n";
			$xml_string .= "<lastname>{$user_result->lastname}</lastname>\n";
            $xml_string .= "</Vital>\n";
        }
    } else {
        $xml_string .= "<status>-1</status>\n";
        $xml_string .= "<reason>Cound not find results</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}
$xml_string .= "</PatientVitals>\n";
echo $xml_string;
?>