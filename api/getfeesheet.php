<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

function supervisorName($supervisor_id){
    $strQuery = "SELECT fname, lname FROM users WHERE id =?";
    $result = sqlQuery($strQuery,array($supervisor_id));
    return $result['fname'] . " " . $result['lname'];
}

$xml_string = "";
$xml_string = "<feesheet>";

$token = $_POST['token'];
$visit_id = $_POST['visit_id'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
    $acl_allow = acl_check('acct', 'bill', $user);
    if ($acl_allow) {
        $strQuery = "SELECT b.id, b.authorized, b.fee, b.code_type, b.code, b.modifier, b.units, b.justify, b.provider_id, 
				fe.supervisor_id, u.fname, u.lname, pd.pricelevel, c.code_text
          		FROM billing AS b
				LEFT JOIN users AS u ON u.id = b.provider_id
          		LEFT JOIN form_encounter AS fe ON fe.pid = b.pid AND fe.encounter = b.encounter
				LEFT JOIN codes AS c ON c.code = b.code
          		LEFT JOIN patient_data AS pd ON pd.pid = b.pid WHERE b.activity = 1 AND b.encounter = ?";

        $result = sqlStatement($strQuery,array($visit_id));
        
        if ($result->_numOfRows > 0) {            
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Feesheet records has been fetched.</reason>";
            $count=0;
            while($res = sqlFetchArray($result)){
                $xml_string .= "<item>\n";

                foreach ($res as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    if ($fieldName == 'fname' || $fieldName == 'lname') {
                        
                    } else {
                        $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                    }
                }
                $supervisor_id = $res['supervisor_id'];
                $fname = $res['fname'];
                $lname = $res['lname'];
                $xml_string .= "<provider>" . $fname . " " . $lname . "</provider>\n";
                $xml_string .= "<supervisor>\n" . supervisorName($supervisor_id) . "</supervisor>\n";
                $xml_string .= "</item>\n";
                $count++;
            }
        } else {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>No records found.</reason>";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</feesheet>";
echo $xml_string;
?>