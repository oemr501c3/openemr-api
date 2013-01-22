<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require 'classes.php';

$xml_string = "";
$xml_string = "<PatientImage>";

$token = $_POST['token'];
$document_id = $_POST['documentId'];

//$token = 'fe15082d987f3fd5960a712c54494a68';
//$document_id = 38;


if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery1 = "SELECT `url`
                    FROM `documents`
                    WHERE `id` = " . $document_id;
//    echo $strQuery1;
    $result1 = $db->get_results($strQuery1);

    $file_path = $result1[0]->url;
    unlink($file_path);

    $strQuery = "DELETE FROM `documents` WHERE id =" . $document_id;
    $result = $db->query($strQuery);

    $strQuery2 = "DELETE FROM `categories_to_documents` WHERE document_id =" . $document_id;
    $result2 = $db->query($strQuery2);

    if ($result) {
        newEvent($event = 'document-record-select', $user, $groupname = 'Default', $success = '1', $comments = $strQuery1);
        newEvent($event = 'document-record-delete', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
        newEvent($event = 'document-record-delete', $user, $groupname = 'Default', $success = '1', $comments = $strQuery2);
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Pateient document has been deleted</reason>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</PatientImage>";
echo $xml_string;
?>