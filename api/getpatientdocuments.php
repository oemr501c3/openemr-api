<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<patientdocuments>";

$token = $_POST['token'];
$patient_id = $_POST['patientId'];
$category_id = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
    $acl_allow = acl_check('patients', 'docs', $user);
    if ($acl_allow) {
        if ($category_id) {
          
        $strQuery = "SELECT d.id,d.date,d.size,d.url,d.docdate,d.mimetype,c2d.category_id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE foreign_id = ? AND category_id = ? ORDER BY category_id, d.date DESC";

         $result = sqlStatement($strQuery,array($patient_id, $category_id));   
          if ($result->_numOfRows > 0) {            
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Contact Record has been fetched</reason>";

               while($res = sqlFetchArray($result)){
                $xml_string .= "<document>\n";

                foreach ($res as $fieldName => $fieldValue) {
                    if ($fieldName == 'url') {
                        if (!empty($fieldValue)) {
                            $fieldValue = getUrl($fieldValue);
                        } else {
                            $fieldValue = '';
                        }
                    }
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</document>\n";
            }
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }   
             
        } else {
          
        $strQuery = "SELECT d.id,d.date,d.size,d.url,d.docdate,d.mimetype,c2d.category_id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE foreign_id = ? ORDER BY category_id, d.date DESC";

         $result = sqlStatement($strQuery,array($patient_id));
        
        if ($result->_numOfRows > 0) {            
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Contact Record has been fetched</reason>";

               while($res = sqlFetchArray($result)){
                $xml_string .= "<document>\n";

                foreach ($res as $fieldName => $fieldValue) {
                    if ($fieldName == 'url') {
                        if (!empty($fieldValue)) {
                            $fieldValue = getUrl($fieldValue);
                        } else {
                            $fieldValue = '';
                        }
                    }
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</document>\n";
            }
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }
     }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</patientdocuments>";
echo $xml_string;
?>