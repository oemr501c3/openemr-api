<?php

header("Content-Type:text/xml");
$ignoreAuth = true;

require 'classes.php';
$xml_array = array();
ini_set('display_errors', '1');
$token = $_POST['token'];
$appointmentId = $_POST['appointmentId'];
$pc_catid = $_POST['pc_catid'];
$pc_hometext = $_POST['pc_hometext'];
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = date("H:i:s", strtotime($_POST['appointmentTime']));
//$location = $_POST['location'];
$app_status = $_POST['pc_apptstatus'];
$pc_title = $_POST['pc_title'];
$patientId = $_POST['patientId'];
$admin_id = $_POST['uprovider_id'];
$facility = $_POST['pc_facility'];
$pc_billing_location = $_POST['pc_billing_location'];
$pc_duration = $_POST['pc_duration'];

//  $token = '8c8ac0c8581785e6f3faf24485a63efa';
//  $appointmentId = 35934; 
//  $pc_catid = "1003-1013";
//  $patientId = '18075';
//  $pc_title = 'Temprature 10';
//  $appointmentDate = '2013-01-04';
//  $appointmentTime = '09:00';
//  $location = 'Main Office';
//  $app_status = '-';
//  $admin_id = 1;
//  $facility = 1;
//  $pc_billing_location = 1;
//  $comments = 'Appointment by Haroon';


$app_status = $app_status == 'p' ? '+' : $app_status;

$endTime = date('H:i:s', strtotime($_POST['appointmentTime']) + $pc_duration);

if ($userId = validateToken($token)) {
    $user_data = getUserData($userId);

    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];

    $provider_username = getProviderUsername($admin_id);

    switch ($emr) {
        case 'openemr':

            $strQuery = "UPDATE openemr_postcalendar_events SET 
                        pc_title = '" . $pc_title . "', 
                        pc_hometext = '" . $pc_hometext . "' , 
                        pc_catid = '" . $pc_catid . "' , 
                        pc_eventDate = '" . $appointmentDate . "', 
                        pc_startTime = '" . $appointmentTime . "', 
                        pc_endTime = '" . $endTime . "', 
                        pc_aid = '" . $admin_id . "', 
                        pc_facility = '" . $facility . "',
                        pc_billing_location = '" . $pc_billing_location . "',
                        pc_duration = '" . $pc_duration . "',
                        pc_pid = '" . $patientId . "',
                        pc_apptstatus = '" . mysql_real_escape_string($app_status) . "' 
                    WHERE pc_eid=" . $appointmentId;


            $result = $db->query($strQuery);

            $device_token_badge = getDeviceTokenBadge($provider_username, 'appointment');
            $badge = $device_token_badge ['badge'];
            $deviceToken = $device_token_badge ['device_token'];
            if ($deviceToken) {
                $notification_res = notification($deviceToken, $badge, $msg_count = 0, $apt_count = 0, $message = 'Appointment Updated!');
//                $notification_res = sendAllNotifications($device_token, $assignee, $provider_id, 'Appointment/Message Notification');
            }

            if ($result) {
                newEvent('appointment-update', $user, 'default', '1', $strQuery);
                $xml_array['status'] = 0;
                $xml_array['reason'] = 'The Appointment has been updated.';
                if ($notification_res) {
                    $xml_array['notification'] = 'Update Appointment Notification(' . $notification_res . ')';
                } else {
                    $xml_array['notification'] = 'Notificaiotn Failed.';
                }
            } else {
                $xml_array['status'] = -1;
                $xml_array['reason'] = 'ERROR: Sorry, there was an error processing your request. Please re-submit the information again.';
            }
            break;
        case 'greenway':
            include 'greenway/ScheduleAppointmentReschedule.php';
            break;
    }//end of switch
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'Appointment');
echo $xml;
?>