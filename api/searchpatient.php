<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$token = $_POST['token'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$xml_string = "";
$xml_string .= "<PatientList>\n";


if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('patients', 'demo', $user);
    
    if ($acl_allow) {
        $strQuery = "SELECT id, pid, fname as firstname, lname as lastname, phone_contact as phone, dob, sex as gender FROM patient_data WHERE fname LIKE ? OR lname LIKE ? ";

        $result = sqlStatement($strQuery, array("%".$firstname."%", "%".$lastname."%"));
        if ($result->_numOfRows > 0) {
            $xml_string .= "<status>0</status>\n";
            $xml_string .= "<reason>Success processing patients records</reason>\n";
            $counter = 0;

            while ($res = sqlFetchArray($result)) {
                $xml_string .= "<Patient>\n";

                foreach ($res as $fieldname => $fieldvalue) {
                    $rowvalue = xmlsafestring($fieldvalue);
                    $xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
                }

                $xml_string .= "</Patient>\n";
                $counter++;
            }
        } else {
            $xml_string .= "<status>-1</status>\n";
            $xml_string .= "<reason>Could not find results</reason>\n";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}


$xml_string .= "</PatientList>\n";
echo $xml_string;
?>