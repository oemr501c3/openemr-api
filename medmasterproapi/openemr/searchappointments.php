<?php

header("Content-Type:text/xml");
require_once 'includes/class.database.php';
require_once 'includes/functions.php';


$token = $_POST['token'];
$appointmentDate = $_POST['appointmentDate'];

$xml_string = "";
$xml_string .= "<Appointments>\n";


if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('admin', 'super', $user);
    if ($acl_allow) {
        $strQuery = "SELECT pd.id as pid,pd.fname, pd.lname, pd.sex as gender, ope.pc_apptstatus, ope.pc_eid, ope.pc_pid, ope.pc_title, ope.pc_hometext, ope.pc_eventDate, ope.pc_startTime, ope.pc_endTime 
                    FROM openemr_postcalendar_events as ope, patient_data as pd 
                    WHERE pd.pid=ope.pc_pid";

        if (isset($appointmentDate)) {
            $strQuery .= " AND ope.pc_eventDate='" . $appointmentDate . "' ";
        }
        $dbresult = $db->query($strQuery);

        if ($dbresult) {
            $xml_string .= "<status>0</status>\n";
            $xml_string .= "<reason>Success processing patient appointments records</reason>\n";
            $counter = 0;

            while ($row = $db->get_row($query = $strQuery, $output = ARRAY_A, $y = $counter)) {
                $xml_string .= "<Appointment>\n";

                foreach ($row as $fieldname => $fieldvalue) {
                    $rowvalue = xmlsafestring($fieldvalue);
                    $xml_string .= "<$fieldname>$rowvalue</$fieldname>\n";
                }

                $xml_string .= "</Appointment>\n";
                $counter++;
            }
        } else {
            $xml_string .= "<status>-1</status>\n";
            $xml_string .= "<reason>Could not find results</reason>\n";
        }
    } else {
        $xml_string .= "<status>-2</status>";
        $xml_string .= "<reason>Invalid Token</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}


$xml_string .= "</Appointments>\n";
echo $xml_string;
?>