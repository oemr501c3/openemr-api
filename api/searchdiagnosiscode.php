<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<DiagnosisCodes>";

$token = $_POST['token'];
$search_term = $_POST['search_term'];
$code_type = isset($_POST['code_type']) ? $_POST['code_type'] : '2';

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('admin', 'super', $user);
    if ($acl_allow) {

        if (!empty($search_term)) {

            $strQuery = "SELECT code_text,code_text_short,code,code_type 
                                    FROM  `codes` 
                                    WHERE `code_type` = ?  AND `code_text` LIKE ? ";
            $result = sqlStatement($strQuery, array($code_type, "%" . $search_term . "%"));
        } else {

            $strQuery = "SELECT code_text,code_text_short,code,code_type 
                                    FROM  `codes` 
                                    WHERE `code_type` = ? LIMIT 1000";
            $result = sqlStatement($strQuery, array($code_type));
        }

        if ($result->_numOfRows > 0) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>Facilities Processed successfully</reason>";

            while ($res = sqlFetchArray($result)) {
                $xml_string .= "<DiagnosisCode>\n";

                foreach ($res as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }

                $xml_string .= "</DiagnosisCode>\n";
            }
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>Could find results</reason>";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</DiagnosisCodes>";
echo $xml_string;
?>