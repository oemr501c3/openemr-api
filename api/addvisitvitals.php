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

require_once'classes.php';
$xml_array = array();

$token = $_POST['token'];
$patientId = add_escape_custom($_POST['patientId']);
$visit_id = add_escape_custom($_POST['visit_id']);

$date = date('Y-m-d H:i:s');
$groupname = isset($_POST['groupname']) ? add_escape_custom($_POST['groupname']) : 'default';
$authorized = isset($_POST['authorized']) ? add_escape_custom($_POST['authorized']) : 1;
$activity = add_escape_custom($_POST['activity']);
$bps = add_escape_custom($_POST['bps']);
$bpd = add_escape_custom($_POST['bpd']);
$weight = add_escape_custom($_POST['weight']);
$height = add_escape_custom($_POST['height']);
$temperature = add_escape_custom($_POST['temperature']);
$temp_method = add_escape_custom($_POST['temp_method']);
$pulse = add_escape_custom($_POST['pulse']);
$respiration = add_escape_custom($_POST['respiration']);
$note = add_escape_custom($_POST['note']);
$BMI = add_escape_custom($_POST['BMI']);
$BMI_status = add_escape_custom($_POST['BMI_status']);
$waist_circ = add_escape_custom($_POST['waist_circ']);
$head_circ = add_escape_custom($_POST['head_circ']);
$oxygen_saturation = add_escape_custom($_POST['oxygen_saturation']);

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);

    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patientId;

    if ($acl_allow) {
        $strQuery = "INSERT INTO `form_vitals`(`date`, `pid`, `user`, `groupname`, `authorized`, `activity`, `bps`, `bpd`, `weight`, `height`, `temperature`, `temp_method`, `pulse`, `respiration`, `note`, `BMI`, `BMI_status`, `waist_circ`, `head_circ`, `oxygen_saturation`) 
                    VALUES ('{$date}','{$patientId}','{$user}','{$groupname}','{$authorized}','{$activity}','{$bps}','{$bpd}','{$weight}','{$height}','{$temperature}','{$temp_method}','{$pulse}','{$respiration}','{$note}','{$BMI}','{$BMI_status}','{$waist_circ}','{$head_circ}','{$oxygen_saturation}')";

        $result = sqlInsert($strQuery);
        $last_inserted_id = $result;

        if ($result) {
            addForm($visit_id, $form_name = 'Vitals', $last_inserted_id, $formdir = 'vitals', $patientId, $authorized = "1", $date = "NOW()", $user, $group = "Default");
            $xml_array['status'] = 0;
            $xml_array['reason'] = 'The Visit vital has been added';
        } else {
            $xml_array['status'] = -1;
            $xml_array['reason'] = 'ERROR: Sorry, there was an error processing your data. Please re-submit the information again.';
        }
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'You are not Authorized to perform this action';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'visitvitals');
echo $xml;
?>