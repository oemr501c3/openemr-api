<?php
/**
 * Copyright (C) 2012 Karl Englund <karl@mastermobileproducts.com>
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-3.0.html>;.
 *
 * @package OpenEMR
 * @author  Karl Englund <karl@mastermobileproducts.com>
 * @link    http://www.open-emr.org
 */
header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';

$xml_string = "";
$xml_string = "<payment>";

$token = $_POST['token'];

$payer_id = add_escape_custom($_POST['payer_id']);
$closed = 0;
$modified_time = add_escape_custom(date('Y-m-d H:i:s'));
$pay_total = add_escape_custom($_POST['pay_total']);
$payment_method = add_escape_custom($_POST['payment_method']);
$check_ref_number = add_escape_custom($_POST['check_ref_number']);
$check_date = $_POST['check_date'];
$post_to_date = $_POST['post_to_date'];
$deposit_date = $_POST['deposit_date'];
$patient_id = add_escape_custom($_POST['patient_id']);
$description = mysql_real_escape_string(add_escape_custom($_POST['description']));
$payment_category = add_escape_custom($_POST['payment_category']);
$payment_type = add_escape_custom($_POST['payment_type']);
$global_amount = add_escape_custom($_POST['global_amount']);

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('acct', 'bill', $user);

    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patient_id;

    if ($acl_allow) {

        $strQuery = "INSERT INTO `ar_session`(`user_id`, `closed`, `reference`, `check_date`, `deposit_date`, `pay_total`, `created_time`, `modified_time`, `global_amount`, `payment_type`, `description`, `adjustment_code`, `post_to_date`, `patient_id`, `payment_method`) VALUES ('" . $userId . "', '" . $closed . "', '" . $check_ref_number . "', '" . $check_date . "','" . $deposit_date . "', '" . $pay_total . "', '" . date('Y-m-d H:i:s') . "', '" . $modified_time . "', '" . $global_amount . "', '" . $payment_type . "', '" . $description . "', '" . $payment_category . "', '" . $post_to_date . "', '" . $patient_id . "', '" . $payment_method . "')";

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