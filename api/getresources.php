<?php

//header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';
ini_set('display_errors', '1');
$xml_string = "";
$xml_string = "<resources>";

$token = $_POST['token'];
$check_user = !empty($_POST['check_user']) ? add_escape_custom($_POST['check_user']) : '';

$list_id = 'ExternalResources';

if ($userId = validateToken($token)) {

    $user = getUsername($userId);
    $acl_allow = acl_check('admin', 'super', $user);
    if ($acl_allow) {
 

        if (!empty($check_user)) {
            $strQuery1 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND `option_value` = ? AND  
                                `notes` NOT LIKE '%/sites/default/documents/userdata/%'";

            $result1 = sqlStatement($strQuery1, array($list_id, $userId));
        } else {
            $strQuery1 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND  
                                `notes` NOT LIKE '%/sites/default/documents/userdata/%'";

            $result1 = sqlStatement($strQuery1, array($list_id));
        }

        if (!empty($check_user)) {
            $strQuery2 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND option_value = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/images/%'";

            $result2 = sqlStatement($strQuery2, array($list_id, $userId));
        } else {
            $strQuery2 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/images/%'";

            $result2 = sqlStatement($strQuery2, array($list_id));
        }

        if (!empty($check_user)) {

            $strQuery3 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND `option_value` = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/pdf/%'";

            $result3 = sqlStatement($strQuery3, array($list_id, $userId));
        } else {
            $strQuery3 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/pdf/%'";

            $result3 = sqlStatement($strQuery3, array($list_id));
        }
        

        if (!empty($check_user)) {

            $strQuery4 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND `option_value` = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/videos/%'";

            $result4 = sqlStatement($strQuery4, array($list_id, $userId));
        } else {
            
            $strQuery4 = "SELECT *
                                FROM `list_options`
                                WHERE `list_id` = ? AND  
                                `notes` LIKE '%/sites/default/documents/userdata/videos/%'";

            $result4 = sqlStatement($strQuery4, array($list_id));
        }
        

        if ($result1->_numOfRows > 0 || $result2->_numOfRows > 0 || $result3->_numOfRows > 0 || $result4->_numOfRows > 0) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Resources Record has been fetched</reason>";
           
            while ($res1 = sqlFetchArray($result1)) {
                $xml_string .= "<resource>\n";
                $xml_string .= "<type>link</type>\n";
                foreach ($res1 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</resource>\n";
            }

            while ($res2 = sqlFetchArray($result2)) {
                $xml_string .= "<resource>\n";
                $xml_string .= "<type>image</type>\n";
                foreach ($res2 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</resource>\n";
            }

            while ($res3 = sqlFetchArray($result3)) {
                $xml_string .= "<resource>\n";
                $xml_string .= "<type>pdf</type>\n";
                foreach ($res3 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</resource>\n";
            }
            while ($res4 = sqlFetchArray($result4)) {
                $xml_string .= "<resource>\n";
                $xml_string .= "<type>video</type>\n";
                foreach ($res4 as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</resource>\n";
            }
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'You are not Authorized to perform this action';
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</resources>";
echo $xml_string;
?>