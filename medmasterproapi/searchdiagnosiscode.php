<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require 'classes.php';

$xml_string = "";
$xml_string = "<DiagnosisCodes>";

$token = $_POST['token'];
$search_term = $_POST['search_term'];
$code_type = isset($_POST['code_type']) ? $_POST['code_type'] : '2';

//$token = 'fe15082d987f3fd5960a712c54494a68';
//$search_term = 'aa';

if ($userId = validateToken($token)) {
    $strQuery = "SELECT code_text,code_text_short,code,code_type 
                                    FROM  `codes` 
                                    WHERE `code_type` = {$code_type}";
    if (!empty($search_term)) {
        $strQuery .= " AND `code_text` LIKE '%{$search_term}%'";
    }else{
        $strQuery .= " LIMIT 1000";
    }

    
    $result = $db->get_results($strQuery);

    if ($result) {
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>Facilities Processed successfully</reason>";

        for ($i = 0; $i < count($result); $i++) {
            $xml_string .= "<DiagnosisCode>\n";

            foreach ($result[$i] as $fieldName => $fieldValue) {
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
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</DiagnosisCodes>";
echo $xml_string;
?>