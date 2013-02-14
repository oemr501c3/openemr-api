<?php

/**
 * api/updatesoap.php Update SOAP.
 *
 * API is allowed to update patient Subjective, Objective, Assessment and Plan
 * information.
 * 
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
$xml_string = "<soap>";

$token = $_POST['token'];

$soapId = $_POST['id'];
$subjective = $_POST['subjective'];
$objective = $_POST['objective'];
$assessment = $_POST ['assessment'];
$plan = $_POST['plan'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);
    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    if ($acl_allow) {
        $strQuery = 'UPDATE form_soap SET ';
        $strQuery .= ' subjective = "' . add_escape_custom($subjective) . '",';
        $strQuery .= ' objective = "' . add_escape_custom($objective) . '",';
        $strQuery .= ' assessment = "' . add_escape_custom($assessment) . '",';
        $strQuery .= ' plan = "' . add_escape_custom($plan) . '"';
        $strQuery .= ' WHERE id = ?';

        $result = sqlStatement($strQuery, array($soapId));

        if ($result !== FALSE) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Soap has been updated</reason>";
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

$xml_string .= "</soap>";
echo $xml_string;
?>