<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once('classes.php');
ini_set('display_errors', '1');

$xml_string = "";
$xml_string .= "<PatientVisit>";

$token = $_POST['token'];
$patientId = $_POST['patientId'];

if ($userId = validateToken($token)) {
    $user_data = getUserData($userId);
    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];

    $acl_allow = acl_check('encounters', 'auth_a', $user);
    if ($acl_allow) {

        $strQuery = "SELECT fe.*,opc.pc_catname,fb.name AS billing_facility_name FROM form_encounter as fe
                                LEFT JOIN `openemr_postcalendar_categories` as opc ON opc.pc_catid = fe.pc_catid
                                LEFT JOIN `facility` as fb ON fb.id = fe.billing_facility
                                WHERE pid= {$patientId} ORDER BY id DESC";

        $result = $db->get_results($strQuery);

        if ($result) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Patient visit Record has been fetched</reason>";

            for ($i = 0; $i < count($result); $i++) {
                $xml_string .= "<Visit>\n";

                foreach ($result[$i] as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }

                $sql_visits = "SELECT type,title,begdate,diagnosis
                           FROM `issue_encounter` AS ie
                           INNER JOIN `lists` AS l ON ie.list_id = l.id
                           WHERE ie.encounter =" . $result[$i]->encounter;

                $list_result = $db->get_results($sql_visits);

                $xml_string .= "<Issues>";
                if ($list_result) {
                    for ($j = 0; $j < count($list_result); $j++) {
                        $xml_string .= "<Issue>\n";
                        foreach ($list_result[$j] as $fieldName => $fieldValue) {
                            $rowValue = xmlsafestring($fieldValue);
                            $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                        }
                        $xml_string .= "</Issue>\n";
                    }
                }
                $xml_string .= "</Issues>";

                $sql_soap = "SELECT fs.subjective,fs.objective,fs.assessment,fs.plan 
                                    FROM `forms` AS f
                                    INNER JOIN `form_soap` as fs ON fs.`id` = f.`form_id`
                                    WHERE f.encounter = {$result[$i]->encounter}
                                    AND f.form_name = 'SOAP'
                                    AND NOT EXISTS (select 1 from `forms` where `form_name` = f.`form_name` and `date` > f.`date` and encounter = {$result[$i]->encounter})";

                $list_result = $db->get_results($sql_soap);

                if ($list_result) {
                    foreach ($list_result[0] as $fieldName => $fieldValue) {
                        $rowValue = xmlsafestring($fieldValue);
                        $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                    }
                } else {
                    $xml_string .= "<subjective></subjective>\n
                                <objective></objective>\n
                                <assessment></assessment>\n
                                <plan></plan>\n";
                }

                $xml_string .= "</Visit>\n";
            }
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

$xml_string .= "</PatientVisit>";
echo $xml_string;
?>
