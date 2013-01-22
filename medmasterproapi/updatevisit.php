<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');

$xml_string = "";
$xml_string .= "<PatientVisit>";

$token = $_POST['token'];
$patientId = $_POST['patientId'];
//$id = $_POST['id'];
$reason = $_POST['reason'];
$facility = $_POST['facility'];
$facility_id = $_POST['facility_id'];
$encounter = $_POST['encounter'];
$dateService = $_POST['dateService'];
$sensitivity = $_POST['sensitivity'];
$pc_catid = $_POST['pc_catid'];
$billing_facility = $_POST['billing_facility'];
$list = $_POST['list'];



//$token = 'fe15082d987f3fd5960a712c54494a68';
//$id = 16;
//$patientId = 9;
//$reason = 'stomach';
//$facility = 'branch clinic';
//$facility_id = 3;
//$encounter = 7;
//$dateService = '2012-08-25 10:12:30';
//$sensitivity = 'normal';
//$pc_catid = 9;
//$billing_facility = 3;
//$list = '7,6';

if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery = "UPDATE form_encounter 
                    SET date = '" . date('Y-m-d H:i:s') . "', 
                        reason = '" . $reason . "', 
                        facility = '" . $facility . "', 
                        facility_id = " . $facility_id . ", 
                        onset_date = '" . $dateService . "', 
                        sensitivity = '" . $sensitivity . "', 
                        billing_facility  = " . $billing_facility . ",
                        pc_catid = '" . $pc_catid . "'    
                    WHERE pid = ".$patientId." AND encounter=" . $encounter;
    $result = $db->query($strQuery);

    $list_res = 1;
    if (!empty($list)) {

        $del_list_query = "DELETE FROM `issue_encounter` WHERE `pid` = {$patientId} AND `encounter` = " . $encounter;
        $list_res = $db->query($del_list_query);
        $list_array = explode(',', $list);


        foreach ($list_array as $list_item) {
            $sql_list_query = "INSERT INTO `issue_encounter`(`pid`, `list_id`, `encounter`, `resolved`) 
                            VALUES ({$patientId},{$list_item},{$encounter},0)";
            $result1 = $db->query($sql_list_query);
            if (!$list_res)
                $list_res = 0;
        }
    }
    if ($result || $list_res) {

        newEvent($event = 'patient-record-add', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>Patient visit updated successfully</reason>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>Couldn't update record</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</PatientVisit>";
echo $xml_string;
?>
