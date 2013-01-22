<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
//ini_set('display_errors', '1');
require 'classes.php';
$xml_array = array();


$token = $_POST['token'];
$patientId = $_POST['patientId'];
$vital_id = $_POST['vital_id'];


$date = date('Y-m-d H:i:s');
$groupname = $_POST['groupname'];
$authorized = $_POST['authorized'];
$activity = $_POST['activity'];
$bps = $_POST['bps'];
$bpd = $_POST['bpd'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$temperature = $_POST['temperature'];
$temp_method = $_POST['temp_method'];
$pulse = $_POST['pulse'];
$respiration = $_POST['respiration'];
$note = $_POST['note'];
$BMI = $_POST['BMI'];
$BMI_status = $_POST['BMI_status'];
$waist_circ = $_POST['waist_circ'];
$head_circ = $_POST['head_circ'];
$oxygen_saturation = $_POST['oxygen_saturation'];


//$token = 'fe15082d987f3fd5960a712c54494a68';
//$patientId = '1';
//$vital_id = 17;
//
//$date = date('Y-m-d H:i:s');
//$groupname = 'default';
//$authorized = 0;
//$activity = 1;
//$bps = 233;
//$bpd = 422;
//$weight = 213;
//$height = 69;
//$temperature = 104;
//$temp_method = 'Tympanic Membrane updated';
//$pulse = 74;
//$respiration = 20;
//$note = 'This is note updated';
//$BMI = 82;
//$BMI_status = 'Underweight updated';
//$waist_circ = 38;
//$head_circ = 18;
//$oxygen_saturation = 100;


if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery = "UPDATE `form_vitals` SET 
                                        `date`='{$date}',
                                        `pid`='{$patientId}',
                                        `user`='{$user}',
                                        `groupname`='{$groupname}',
                                        `authorized`='{$authorized}',
                                        `activity`='{$activity}',
                                        `bps`='{$bps}',
                                        `bpd`='{$bpd}',
                                        `weight`='{$weight}',
                                        `height`='{$height}',
                                        `temperature`='{$temperature}',
                                        `temp_method`='{$temp_method}',
                                        `pulse`='{$pulse}',
                                        `respiration`='{$respiration}',
                                        `note`='{$note}',
                                        `BMI`='{$BMI}',
                                        `BMI_status`='{$BMI_status}',
                                        `waist_circ`='{$waist_circ}',
                                        `head_circ`='{$head_circ}',
                                        `oxygen_saturation`='{$oxygen_saturation}' 
        WHERE id = {$vital_id}";

    $result = $db->query($strQuery);

    if ($result) {
        newEvent('visit-vital-update', $user, 'default', '1', $strQuery);
//        addForm($visit_id, $form_name = 'Vitals', $result, $formdir = 'vitals', $patientId, $authorized = "1", $date = "NOW()", $user, $group = "Default");
        $xml_array['status'] = 0;
        $xml_array['reason'] = 'Visit vital update successfully';
    } else {
        $xml_array['status'] = -1;
        $xml_array['reason'] = 'Could not update isit vital';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'visitvitals');
echo $xml;
?>