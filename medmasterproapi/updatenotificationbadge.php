<?php

//header("Content-Type:text/xml");
$ignoreAuth = true;

require 'classes.php';
$xml_string = "";
$xml_string = "<badge>";

//ini_set('display_errors', '1');

$token = $_POST['token'];


$message_badge = $_POST['message_badge'];
$appointment_badge = $_POST['appointment_badge'];
$labreports_badge = $_POST['labreports_badge'];
$prescription_badge = $_POST['prescription_badge'];

//$token = '8c8ac0c8581785e6f3faf24485a784fa';
//$message_badge = 5;
//$appointment_badge = '';
//$labreports_badge = '';
//$prescription_badge = 1;

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
    $badges = getAllBadges($token);

   
    $message_badge = $message_badge >= 0 ? $message_badge : $badges->message_badge;
    $appointment_badge = $appointment_badge>= 0 ? $appointment_badge : $badges->appointment_badge;
    $labreports_badge = $labreports_badge>= 0 ? $labreports_badge : $badges->labreports_badge;
    $prescription_badge = $prescription_badge>= 0 ? $prescription_badge : $badges->prescription_badge;

    $strQuery = "UPDATE `tokens` SET 
        `message_badge`= {$message_badge},`appointment_badge`= {$appointment_badge},
        `labreports_badge`= {$labreports_badge},`prescription_badge`= {$prescription_badge} WHERE token='{$token}'";

        
    $result = $db->query($strQuery);

    if ($result) {
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>Badges has been updated</reason>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</badge>";
echo $xml_string;
?>