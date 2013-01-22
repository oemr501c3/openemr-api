<?php

header("Content-Type:text/xml");
$ignoreAuth = true;

require('classes.php');

//ini_set('display_errors', '1');

$xml_string = "";
$xml_string .= "<PatientVisit>";

$token = $_POST['token'];
$patientId = $_POST['patientId'];
$reason = $_POST['reason'];
$facility = $_POST['facility'];
$facility_id = $_POST['facility_id'];
$dateService = $_POST['dateService'];
$onset_date = $_POST['onset_date'];
$sensitivity = $_POST['sensitivity'];
$pc_catid = $_POST['pc_catid'];
$billing_facility = $_POST['billing_facility'];
$list = $_POST['list'];

//$token = 'fe15082d987f3fd5960a712c54494a68';
//$patientId = 9;
//$reason = 'feeling extreme headache';
//$facility = 'main clinic';
//$facility_id = 3;
//$dateService = '2012-08-25';
//$onset_date = '2012-09-30';
//$sensitivity = 'normal';
//$pc_catid = 9;
//$billing_facility = 3;
//$list = '';

if ($userId = validateToken($token)) {
    $user = getUsername($userId);


// MIQBAL
// PLEASE CHECK : @ Haroon, @ Masood, @ Bilal,
// Have you people not found out the piece of code given below?
// 
//
// if ($mode == 'new')
// {
//   $provider_id = $userauthorized ? $_SESSION['authUserID'] : 0;
//   $encounter = $conn->GenID("sequences");
//   addForm($encounter, "New Patient Encounter",
//     sqlInsert("INSERT INTO form_encounter SET " .
//       "date = '$date', " .
//       "onset_date = '$onset_date', " .
//       "reason = '$reason', " .
//       "facility = '$facility', " .
//       "pc_catid = '$pc_catid', " .
//       "facility_id = '$facility_id', " .
//       "billing_facility = '$billing_facility', " .
//       "sensitivity = '$sensitivity', " .
//       "referral_source = '$referral_source', " .
//       "pid = '$pid', " .
//       "encounter = '$encounter', " .
//       "provider_id = '$provider_id'"),
//     "newpatient", $pid, $userauthorized, $date);
// }

// Added by IQBAL 
// These two lines are use to get the next Visit / Encounter ID from the sequence indexer of the table, why are you people doing it hard way, have you not studied the open emr at all?
$conn = $GLOBALS['adodb']['db'];
$encounter = $conn->GenID("sequences");


    sqlStatement("lock tables form_encounter read");

    $result_encounter_id = sqlQuery("select max(encounter)+1 as encounter_id from form_encounter");

    sqlStatement("unlock tables");

    if ($result_encounter_id['encounter_id'] > 1) {
        $encounter_id = $result_encounter_id['encounter_id'];
    }elseif(empty ($result_encounter_id['encounter_id'])){
        $encounter_id = 1;
    }



//    var_dump($list_array);exit;
    $strQuery = "INSERT INTO form_encounter (date, reason, facility, facility_id, pid, encounter, onset_date, sensitivity, pc_catid, billing_facility) 
        VALUES ('" . $dateService . "', '" . $reason . "', '" . $facility . "', " . $facility_id . ", " . $patientId . ", " . $encounter . ", '" . $onset_date . "', '" . $sensitivity . "', " . $pc_catid . ", " . $billing_facility . ")";
	//$strQuery = "INSERT INTO form_encounter (date, reason, facility, facility_id, pid, onset_date, sensitivity, pc_catid, billing_facility) 
    //    VALUES ('" . $dateService . "', '" . $reason . "', '" . $facility . "', " . $facility_id . ", " . $patientId . ", '" . $onset_date . "', '" . $sensitivity . "', " . $pc_catid . ", " . $billing_facility . ")";

    //echo $strQuery;
    $result = $db->query($strQuery);

    if ($result) {
        if (!empty($list)) {
            $list_array = explode(',', $list);
            foreach ($list_array as $list_item) {
                $sql_list_query = "INSERT INTO `issue_encounter`(`pid`, `list_id`, `encounter`, `resolved`) 
                            VALUES ('{$patientId}','{$list_item}','{$encounter_id}',0)";
                $db->query($sql_list_query);
            }
        }
        newEvent($event = 'patient-record-add', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Patient visit has been added</reason>";
        $xml_string .= "<visit_id>{$encounter_id}</visit_id>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</PatientVisit>";
echo $xml_string;
?>