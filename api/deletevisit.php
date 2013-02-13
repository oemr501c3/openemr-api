<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<visit>";

$token = $_POST['token'];
$visit_id = $_POST['visit_id'];


if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
    $acl_allow = acl_check('admin', 'super', $user);
    if ($acl_allow) {
        $strQuery2 = "SELECT * FROM forms WHERE encounter = {$visit_id}";
        $forms = $db->get_results($strQuery2);

        $ros_ids = '';
        $rosc_ids = '';
        $soap_ids = '';
        $vitals_ids = '';

        foreach ($forms as $form) {
            switch ($form->form_name) {
                case 'Review Of Systems':
                    $ros_ids .= "{$form->form_id},";
                    break;
                case 'Review of Systems Checks':
                    $rosc_ids .= "{$form->form_id},";
                    break;
                case 'SOAP':
                    $soap_ids .= "{$form->form_id},";
                    break;
                case 'Vitals':
                    $vitals_ids .= "{$form->form_id},";
                    break;
            }
        }
        $ros_ids = rtrim($ros_ids, ",");
        $rosc_ids = rtrim($rosc_ids, ",");
        $soap_ids = rtrim($soap_ids, ",");
        $vitals_ids = rtrim($vitals_ids, ",");

        $strQuery = "DELETE FROM form_encounter WHERE encounter = ?";
	$result = sqlStatement($strQuery, array($visit_id));

        $strQuery = "DELETE FROM issue_encounter WHERE encounter = ?";
	$result = sqlStatement($strQuery, array($visit_id));

        $strQuery = "DELETE FROM form_ros WHERE id IN(?)";
	$result = sqlStatement($strQuery, array($ros_ids));

        $strQuery = "DELETE FROM form_reviewofs WHERE id IN(?)";
	$result = sqlStatement($strQuery, array($rosc_ids));

        $strQuery = "DELETE FROM form_soap WHERE id IN(?)";
	$result = sqlStatement($strQuery, array($soap_ids));

        $strQuery = "DELETE FROM form_vitals WHERE id IN(?)";
	$result = sqlStatement($strQuery, array($vitals_ids));

        $strQuery = "DELETE FROM forms WHERE encounter = ?";
	$result = sqlStatement($strQuery, array($visit_id));


        if ($result) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Visit has been deleted</reason>";
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</visit>";
echo $xml_string;
?>