<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');

$xml_string = "";
$xml_string = "<prescription>";

$token = $_POST['token'];
//	$patientId = $_POST['patientId'];

$id = $_POST['id'];
$startDate = $_POST['startDate'];
$drug = $_POST['drug'];

$dosage = $_POST['dosage'];
$quantity = $_POST['quantity'];

$per_refill = $_POST['refill'];
$medication = $_POST['medication'];
$note = $_POST['note'];
$provider_id = $_POST['provider_id'];

$patientId = $_POST['patientId'];
//  $token = 'f12dab7305cd43b68db8551008f9f9a6';
////  $patientId = 44;
//  $id = 14;
//  $startDate = '2012-08-08';
//  $drug = 'changed';
//  $dosage = '1';
//  $quantity = 3;
//  $per_refill = 2;
//  $medication = 1;
//  $note = 'changed prescription notes by AES...';


if ($userId = validateToken($token)) {
//    $user = getUsername($userId);
//    $provider_id = getUserProviderId($userId);
    $provider_username = getProviderUsername($provider_id);

    $strQuery = "UPDATE `prescriptions` set
                                        provider_id = {$provider_id}, 
                                        start_date = '" . $startDate . "', 
                                        drug = '" . $drug . "', 
                                        dosage = '" . $dosage . "', 
                                        quantity = '" . $quantity . "',  
                                        refills = '" . $per_refill . "', 
                                        medication = '" . $medication . "',
                                        date_modified = '" . date('Y-m-d') . "',
                                        note = '" . $note . "'
                             WHERE id = {$id}";
    $result = $db->query($strQuery);

    $list_result = 1;
    if ($medication) {
        $select_medication = "SELECT * FROM  `lists` 
                                    WHERE  `type` LIKE  'medication'
                                            AND  `title` LIKE  '{$drug}' 
                                            AND  `pid` = {$patientId}";
        $result1 = $db->get_row($select_medication);

        if (!$result1) {
            $list_query = "insert into lists(date,begdate,type,activity,pid,user,groupname,title) 
                            values (now(),cast(now() as date),'medication',1,{$patientId},'{$user}','','{$drug}')";
            $list_result = $db->query($list_query);
        }
    }

    $device_token_badge = getDeviceTokenBadge($provider_username, 'prescription');
    $badge = $device_token_badge ['badge'];
    $deviceToken = $device_token_badge ['device_token'];
    if ($deviceToken) {
        $notification_res = notification($deviceToken, $badge, $msg_count = 0, $apt_count = 0, $message = 'Update Prescription Notification!');
    }
//echo mysql_error();
    if ($result && $list_result) {
        newEvent($event = 'patient-record-update', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);

        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Patient prescription has been updated</reason>";
        if ($notification_res) {
            $xml_array['notification'] = 'Update Appointment Notification(' . $notification_res . ')';
        } else {
            $xml_array['notification'] = 'Notificaiotn Failed.';
        }
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</prescription>";
echo $xml_string;
?>