<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<payment>";

$token = $_POST['token'];

$payer_id = $_POST['payer_id'];
$closed = 0;
$modified_time = date('Y-m-d H:i:s');
$pay_total = $_POST['pay_total'];
$payment_method = $_POST['payment_method'];
$check_ref_number = $_POST['check_ref_number'];
$check_date = $_POST['check_date'];
$post_to_date = $_POST['post_to_date'];
$deposit_date = $_POST['deposit_date'];
$patient_id = $_POST['patient_id'];
$description = mysql_real_escape_string($_POST['description']);
$payment_category = $_POST['payment_category'];
$payment_type = $_POST['payment_type'];
$global_amount = $_POST['global_amount'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('acct', 'bill', $user);

    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patient_id;

    if ($acl_allow) {

        $strQuery = "INSERT INTO `ar_session`(`user_id`, `closed`, `reference`, `check_date`, `deposit_date`, `pay_total`, `created_time`, `modified_time`, `global_amount`, `payment_type`, `description`, `adjustment_code`, `post_to_date`, `patient_id`, `payment_method`) 
                                            VALUES ('
                                                    " . add_escape_custom($userId) . "',
                                                    '" . add_escape_custom($closed) . "',
                                                    '" . add_escape_custom($check_ref_number) . "',
                                                    '" . add_escape_custom($check_date) . "',
                                                    '" . add_escape_custom($deposit_date) . "',
                                                    '" . add_escape_custom($pay_total) . "',
                                                    '" . date('Y-m-d H:i:s') . "',
                                                    '" . add_escape_custom($modified_time) . "',
                                                    '" . add_escape_custom($global_amount) . "',
                                                    '" . add_escape_custom($payment_type) . "',
                                                    '" . add_escape_custom($description) . "',
                                                    '" . add_escape_custom($payment_category) . "',
                                                    '" . add_escape_custom($post_to_date) . "',
                                                    '" . add_escape_custom($patient_id) . "',
                                                    '" . add_escape_custom($payment_method) . "')";

        $result = sqlStatement($strQuery);

        if ($result) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Payment has been added</reason>";
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
        }
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'You are not Authorized to perform this action';
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</payment>";
echo $xml_string;
?>