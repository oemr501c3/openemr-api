<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');

$xml_string = "";
$xml_string = "<appointment>";

$token = $_POST['token'];
//	$patientId = $_POST['patientId'];

$id = $_POST['id'];

//$token = '8c8ac0c8581785e6f3faf24485a784fa';
//$id = 35933;

if ($userId = validateToken($token)) {
    $user_data = getUserData($userId);

    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];

    switch ($emr) {
        case 'openemr':
            $strQuery = "DELETE FROM `openemr_postcalendar_events` WHERE pc_eid = {$id}";
            $result = $db->query($strQuery);

            if ($result) {
                newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);

                $xml_string .= "<status>0</status>";
                $xml_string .= "<reason>The Appointment has been deleted/removed.</reason>";
            } else {
                $xml_string .= "<status>-1</status>";
                $xml_string .= "<reason>ERROR: Sorry, there was an error processing your request. Please re-submit the information again.</reason>";
            }
            break;
        case 'greenway':
            include 'greenway/ScheduleAppointmentCancel.php';
            break;
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</appointment>";
echo $xml_string;
?>