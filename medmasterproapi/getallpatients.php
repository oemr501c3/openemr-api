<?php

header("Content-Type:text/xml");
//require 'includes/class.database.php';
//require 'includes/functions.php';

$ignoreAuth = true;
require 'classes.php';
$token = $_POST['token'];

//$token = 'd4324ca3654d5ba0ae8a537ec7daf968';
//$token = '18a3357736cf0e409f99cc8ce8854603';

$xml_string = "";
$xml_string .= "<PatientList>\n";

if ($userId = validateToken($token)) {
    $emr = getEmr($userId);
//    echo $userId."/".$emr;
    switch ($emr) {
        case 'openemr':
            $strQuery = "SELECT id, pid, fname as firstname, lname as lastname,mname as middlename, phone_contact as phone, dob, sex as gender FROM patient_data";
            $dbresult = $db->query($strQuery);

            if ($dbresult) {
                $xml_string .= "<status>0</status>\n";
                $xml_string .= "<reason>The Patient Records has been fetched</reason>\n";
                $counter = 0;

                while ($row = $db->get_row($query = $strQuery, $output = ARRAY_A, $y = $counter)) {
                    $xml_string .= "<Patient>\n";

                    $p_id = 0;
                    foreach ($row as $fieldname => $fieldvalue) {
                        $rowvalue = xmlsafestring($fieldvalue);
                        if ($fieldname == "pid")
                            $p_id = $fieldvalue;
                        $xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
                    }

                    $strQuery1 = "SELECT d.date,d.size,d.url,d.docdate,d.mimetype,c2d.category_id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE foreign_id = {$p_id}
                                AND category_id = 13
                                ORDER BY category_id, d.date DESC 
                                LIMIT 1";

                    $result1 = $db->get_row($strQuery1);

                    if ($result1) {
                        $xml_string .= "<profileimage>" . getUrl($result1->url) . "</profileimage>\n";
                    } else {
                        $xml_string .= "<profileimage></profileimage>\n";
                    }

                    $xml_string .= "</Patient>\n";
                    $counter++;
                }
            } else {
                $xml_string .= "<status>-1</status>\n";
                $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>\n";
            }
            break;
        case 'greenway':
            include 'greenway/patientsearch.php';
            break;
    }
} else {
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}


$xml_string .= "</PatientList>\n";
echo $xml_string;
?>