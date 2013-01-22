<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
//ini_set('display_errors', '1');
require 'classes.php';
$xml_array = array();

$token = $_POST['token'];
$pc_catid = $_POST['pc_catid'];
$patientId = $_POST['patientId'];
//$reason = $_POST['reason'];
$pc_title = $_POST['pc_title'];
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = date("H:i:s", strtotime($_POST['appointmentTime']));
//$location = $_POST['location'];
//$examtype = $_POST['examtype'];
$app_status = $_POST['pc_apptstatus'];
$admin_id = $_POST['uprovider_id'];
$facility = $_POST['pc_facility'];
$pc_billing_location = $_POST['pc_billing_location'];
$comments = $_POST['pc_hometext'];
$pc_duration = $_POST['pc_duration'];

//  $token = '8c8ac0c8581785e6f3faf24485a784fa';
//  $pc_catid = 10;
//  $patientId = '27033';
//  $pc_title = 'Temprature 10';
//  $appointmentDate = '2013-01-04';
//  $appointmentTime = '09:00';
//  $location = 'Main Office';
//  $app_status = '-';
//  $admin_id = 1;
//  $facility = 1;
//  $pc_billing_location = 1;
//  $comments = 'Appointment by Haroon';
//  $examType = 'exam1'; 
//if ($examType == 'exam1') {
$endTime = date('H:i:s', strtotime($_POST['appointmentTime']) + $pc_duration);
//}

$recurrspecs = array("event_repeat_freq" => "",
    "event_repeat_freq_type" => "",
    "event_repeat_on_num" => "1",
    "event_repeat_on_day" => "0",
    "event_repeat_on_freq" => "0",
    "exdate" => ""
);
$recurrspec = serialize($recurrspecs);

$locationspecs = array("event_location" => "",
    "event_street1" => "",
    "event_street2" => "",
    "event_city" => "",
    "event_state" => "",
    "event_postal" => ""
);
$locationspec = serialize($locationspecs);

if ($userId = validateToken($token)) {
    $user_data = getUserData($userId);

    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];

    $provider_username = getProviderUsername($admin_id);

    switch ($emr) {
        case 'openemr':

            $strQuery = "INSERT INTO openemr_postcalendar_events (pc_pid, pc_title, pc_hometext , pc_time, pc_eventDate, pc_startTime, pc_endTime, pc_apptstatus, pc_catid, pc_aid, pc_facility, pc_billing_location, pc_duration , pc_informant, pc_eventstatus, pc_sharing, pc_recurrspec, pc_location) 
                            VALUES (" . $patientId . ",  '" . $pc_title . "' , '" . $comments . "' , '" . date('Y-m-d H:i:s') . "', '" . $appointmentDate . "', '" . $appointmentTime . "', '" . $endTime . "','" . $app_status . "','" . $pc_catid . "','" . $admin_id . "','" . $facility . "','" . $pc_billing_location . "','" . $pc_duration . "',1,1,1,'{$recurrspec}','{$locationspec}')";
            $result = $db->query($strQuery);

            $device_token_badge = getDeviceTokenBadge($provider_username, 'appointment');
            $badge = $device_token_badge ['badge'];
            $deviceToken = $device_token_badge ['device_token'];
            if ($deviceToken) {
                $notification_res = notification($deviceToken, $badge, $msg_count = 0, $apt_count = 0, $message = 'New Appointment Notification!');
//                $notification_res = sendAllNotifications($device_token, $assignee, $provider_id, 'Appointment/Message Notification');
            }

            if ($result) {
                newEvent('appointment-insert', $user, 'default', '1', $strQuery);
                $xml_array['status'] = 0;
                $xml_array['reason'] = 'The Appointment has been added.';
                if ($notification_res) {
                    $xml_array['notification'] = 'Add Appointment Notification(' . $notification_res . ')';
                } else {
                    $xml_array['notification'] = 'Notificaiotn Failed.';
                }
            } else {
                $xml_array['status'] = -1;
                $xml_array['reason'] = 'ERROR: Sorry, there was an error processing your request. Please re-submit the information again.';
            }

            break;
        case 'greenway':
            include 'greenway/ScheduleAppointmentAttempt.php';
            break;
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'Appointment');
echo $xml;
?>