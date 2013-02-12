<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<list>";

$token = $_POST['token'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('lists', 'default', $user);
    if ($acl_allow) {

        $strQuery = "SELECT option_id, title FROM list_options WHERE list_id  = 'language'";

        $result = sqlStatement($strQuery, array());

        $strQuery1 = "SELECT option_id, title FROM list_options WHERE list_id  = 'race'";

        $result1 = sqlStatement($strQuery1, array());

        $strQuery2 = "SELECT option_id, title FROM list_options WHERE list_id  = 'ethnicity'";

        $result2 = sqlStatement($strQuery2, array());
        
        if ($result->_numOfRows > 0 || $result1->_numOfRows > 0 || $result2->_numOfRows > 0) {
            
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Options has been fetched</reason>";

            $xml_string .= "<language>\n";
            $xml_string .= "<unassigned>Unassigned</unassigned>\n";
            while ($res = sqlFetchArray($result)) {

                foreach ($res as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    if ($fieldName == 'fs_category') {
                        
                    } else {
                        $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                    }
                }
            }
            $xml_string .= "</language>";

            $xml_string .= "<race>\n";
            $xml_string .= "<unassigned>Unassigned</unassigned>\n";
            while ($res1 = sqlFetchArray($result1)) {

                foreach ($res1 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);

                    if ($fieldName == 'fs_category') {
                        
                    } else {
                        $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                    }
                }
            }
            $xml_string .= "</race>";

            $xml_string .= "<ethnicity>\n";
            $xml_string .= "<unassigned>Unassigned</unassigned>\n";
            while ($res2 = sqlFetchArray($result2)) {

                foreach ($res2 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);

                    if ($fieldName == 'fs_category') {
                        
                    } else {
                        $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                    }
                }
            }
            $xml_string .= "</ethnicity>";
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</list>";
echo $xml_string;
?>