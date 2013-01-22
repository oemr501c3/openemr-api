<?php

header("Content-Type:text/xml");
require 'includes/class.database.php';
require 'includes/functions.php';


$token = $_POST['token'];
$appointmentDate = $_POST['appointmentDate'];

/* $token = 'a9b450867020dc6bb08f3c94f9f3efe9';
  $appointmentDate = '2012-07-16'; */


$xml_string = "";
$xml_string .= "<Appointments>\n";


if (validateToken($token)) {
//$strQuery = "SELECT pc_eid as appointmentId, pc_pid as patientId, pc_title as location, pc_hometext as reason, pc_time as time, pc_eventDate as appointmentDate, pc_startTime as startTime, pc_endTime as endTime FROM openemr_postcalendar_events WHERE pc_eventDate='".$appointmentDate."' ";
    $strQuery = "SELECT pd.id as pid,pd.fname, pd.lname, pd.sex as gender, ope.pc_apptstatus, ope.pc_eid, ope.pc_pid, ope.pc_title, ope.pc_hometext, ope.pc_eventDate, ope.pc_startTime, ope.pc_endTime 
                    FROM openemr_postcalendar_events as ope, patient_data as pd 
                    WHERE pd.pid=ope.pc_pid";

//    $strQuery = "SELECT pd.id as p_id,pd.fname as firstname, pd.lname as lastname, ope.pc_eid as appointmentId, ope.pc_pid as patientId, ope.pc_title as location, ope.pc_hometext as reason, ope.pc_eventDate as appointmentDate, ope.pc_startTime as startTime, ope.pc_endTime as endTime 
//                    FROM openemr_postcalendar_events as ope, patient_data as pd 
//                    WHERE pd.id=ope.pc_pid";


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
    $xml_string .= "<status>-2</status>\n";
    $xml_string .= "<reason>Invalid Token</reason>\n";
}


$xml_string .= "</Appointments>\n";
echo $xml_string;
?>