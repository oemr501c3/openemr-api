<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
//ini_set('display_errors', '1');
//ini_set('display_errors', '1');
require 'classes.php';
$xml_array = array();


$token = $_POST['token'];
$patientId = $_POST['patientId'];
$visit_id = $_POST['visit_id'];


$date = date('Y-m-d H:i:s');
$groupname = isset($_POST['groupname'])?$_POST['groupname']:'default';
$authorized = isset($_POST['authorized'])?$_POST['authorized']:1;
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
//$visit_id = 5;
//
//$date = date('Y-m-d H:i:s');
//$groupname = '';
//$authorized = 0;
//$activity = 1;
//$bps = 233;
//$bpd = 422;
//$weight = 213;
//$height = 69;
//$temperature = 104;
//$temp_method = 'Tympanic Membrane';
//$pulse = 74;
//$respiration = 20;
//$note = 'This is note';
//$BMI = 82;
//$BMI_status = 'Underweight';
//$waist_circ = 38;
//$head_circ = 18;
//$oxygen_saturation = 100;


if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery = "INSERT INTO `form_vitals`(`date`, `pid`, `user`, `groupname`, `authorized`, `activity`, `bps`, `bpd`, `weight`, `height`, `temperature`, `temp_method`, `pulse`, `respiration`, `note`, `BMI`, `BMI_status`, `waist_circ`, `head_circ`, `oxygen_saturation`) 
                    VALUES ('{$date}','{$patientId}','{$user}','{$groupname}','{$authorized}','{$activity}','{$bps}','{$bpd}','{$weight}','{$height}','{$temperature}','{$temp_method}','{$pulse}','{$respiration}','{$note}','{$BMI}','{$BMI_status}','{$waist_circ}','{$head_circ}','{$oxygen_saturation}')";

    $result = $db->query($strQuery);
    
    $last_inserted_id = mysql_insert_id();
    
    if ($result) {
        newEvent('visit-vital-insert', $user, 'default', '1', $strQuery);
        addForm($visit_id, $form_name = 'Vitals', $last_inserted_id, $formdir = 'vitals', $patientId, $authorized = "1", $date = "NOW()", $user, $group = "Default");
        $xml_array['status'] = 0;
        $xml_array['reason'] = 'The Visit vital has been added';
    } else {
        $xml_array['status'] = -1;
        $xml_array['reason'] = 'ERROR: Sorry, there was an error processing your data. Please re-submit the information again.';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'visitvitals');
echo $xml;
?>