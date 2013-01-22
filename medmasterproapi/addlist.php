<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require ("classes.php");

$token = $_POST['token'];
$date = 'NOW()';
$type = $_POST['type']; // medical_problem
$visit_id = $_POST['visit_id'];

$title = isset($_POST['title']) ? $_POST['title'] : '';
$begdate = isset($_POST['begdate']) ? $_POST['begdate'] : '';
$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
$returndate = isset($_POST['returndate']) ? $_POST['returndate'] : '';
$occurrence = isset($_POST['occurrence']) ? $_POST['occurrence'] : '';
$classification = isset($_POST['classification']) ? $_POST['classification'] : '0';
$referredby = isset($_POST['referredby']) ? $_POST['referredby'] : '';
$extrainfo = isset($_POST['extrainfo']) ? $_POST['extrainfo'] : '';
$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
$activity = isset($_POST['activity']) ? $_POST['activity'] : '1';
$comments = isset($_POST['comments']) ? $_POST['comments'] : '';

$pid = $_POST['pid'];
$user = '';
$groupname = isset($_POST['groupname']) ? $_POST['groupname'] : 'Default';

$outcome = $_POST['outcome'];
$destination = $_POST['destination'];

$reinjury_id = isset($_POST['reinjury_id']) ? $_POST['reinjury_id'] : '0';
$injury_part = isset($_POST['injury_part']) ? $_POST['injury_part'] : '';
$injury_type = isset($_POST['injury_type']) ? $_POST['injury_type'] : '';
$injury_grade = isset($_POST['injury_grade']) ? $_POST['injury_grade'] : '';
$reaction = isset($_POST['reaction']) ? $_POST['reaction'] : '';
$external_allergyid = isset($_POST['external_allergyid']) ? $_POST['external_allergyid'] : '';
$erx_source = isset($_POST['erx_source']) ? $_POST['erx_source'] : 0;
$erx_uploaded = isset($_POST['erx_uploaded']) ? $_POST['erx_uploaded'] : 0;

//$token = 'fe15082d987f3fd5960a712c54494a68';
//$date = 'NOW()';
//$type = 'medical_problem';
//$title = 'Medical Problem Add';
//$begdate = '2012-08-25';
//$enddate = '2012-09-10';
//
//$occurrence = '4';
//$referredby = 'Dr.Hanny';
//$extrainfo = isset($_POST['extrainfo']) ? $_POST['extrainfo'] : '';
//$diagnosis = 'ICD9:E002.5';
//$activity = '1';
//
//$pid = 3;
//$user = '';
//$outcome = '3';
//$destination = 'Islamabad';
//
//$reinjury_id = isset($_POST['reinjury_id']) ? $_POST['reinjury_id'] : '0';
//$injury_part = isset($_POST['injury_part']) ? $_POST['injury_part'] : '';
//$injury_type = isset($_POST['injury_type']) ? $_POST['injury_type'] : '';
//$injury_grade = isset($_POST['injury_grade']) ? $_POST['injury_grade'] : '';
//$reaction = isset($_POST['reaction']) ? $_POST['reaction'] : '';
//$external_allergyid = isset($_POST['external_allergyid']) ? $_POST['external_allergyid'] : '';
//$erx_source = isset($_POST['erx_source']) ? $_POST['erx_source'] : 0;
//$erx_uploaded = isset($_POST['erx_uploaded']) ? $_POST['erx_uploaded'] : 0;


$xml_string = "";
$xml_string = "<list>";

if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    setListTouch($pid, $type);

    $strQuery = "INSERT INTO `lists`(`date`, `type`, `title`, `begdate`, `enddate`, `returndate`, `occurrence`, `classification`, `referredby`, `extrainfo`, `diagnosis`, `activity`, `comments`, `pid`, `user`, `groupname`, `outcome`, `destination`, `reinjury_id`, `injury_part`, `injury_type`, `injury_grade`, `reaction`, `external_allergyid`, `erx_source`, `erx_uploaded`) 
                                        VALUES ({$date},'{$type}','{$title}','{$begdate}','{$enddate}','{$returndate}','{$occurrence}','{$classification}','{$referredby}','{$extrainfo}','{$diagnosis}','{$activity}','{$comments}','{$pid}','{$user}','{$groupname}','{$outcome}','{$destination}','{$reinjury_id}','{$injury_part}','{$injury_type}','{$injury_grade}','{$reaction}','{$external_allergyid}','{$erx_source}','{$erx_uploaded}')";
    $result = $db->query($strQuery);

    $last_inseted_id = mysql_insert_id();

    $result1 = 1;
    if ($visit_id) {
        $sql_list_query = "INSERT INTO `issue_encounter`(`pid`, `list_id`, `encounter`, `resolved`) 
                            VALUES ('{$pid}','{$last_inseted_id}','{$visit_id}',0)";
        $result1 = $db->query($sql_list_query);
    }
    if ($result && $result1) {
        newEvent($event = 'list-record-inserted', $user, $groupname = 'Default', $success = '1', $comments = $strQuery1);
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The {$type} has been added</reason>";
        $xml_string .= "<id>{$last_inseted_id}</id>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</list>";
echo $xml_string;
?>