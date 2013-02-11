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
require_once ("classes.php");

$token = $_POST['token'];
$date = 'NOW()';
$type = add_escape_custom($_POST['type']); // medical_problem
$visit_id =add_escape_custom($_POST['visit_id']);

$title = isset($_POST['title']) ? add_escape_custom($_POST['title']) : '';
$begdate = isset($_POST['begdate']) ? $_POST['begdate'] : '';
$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
$returndate = isset($_POST['returndate']) ? $_POST['returndate'] : '';
$occurrence = isset($_POST['occurrence']) ? add_escape_custom($_POST['occurrence']) : '';
$classification = isset($_POST['classification']) ? add_escape_custom($_POST['classification']) : '0';
$referredby = isset($_POST['referredby']) ? add_escape_custom($_POST['referredby']) : '';
$extrainfo = isset($_POST['extrainfo']) ? add_escape_custom($_POST['extrainfo']) : '';
$diagnosis = isset($_POST['diagnosis']) ? add_escape_custom($_POST['diagnosis']) : '';
$activity = isset($_POST['activity']) ? add_escape_custom($_POST['activity']) : '1';
$comments = isset($_POST['comments']) ? add_escape_custom($_POST['comments']) : '';

$pid = add_escape_custom($_POST['pid']);
$user = '';
$groupname = isset($_POST['groupname']) ? add_escape_custom($_POST['groupname']) : 'Default';

$outcome = add_escape_custom($_POST['outcome']);
$destination = add_escape_custom($_POST['destination']);

$reinjury_id = isset($_POST['reinjury_id']) ? add_escape_custom($_POST['reinjury_id']) : '0';
$injury_part = isset($_POST['injury_part']) ? add_escape_custom($_POST['injury_part']) : '';
$injury_type = isset($_POST['injury_type']) ? add_escape_custom($_POST['injury_type']) : '';
$injury_grade = isset($_POST['injury_grade']) ? add_escape_custom($_POST['injury_grade']) : '';
$reaction = isset($_POST['reaction']) ? add_escape_custom($_POST['reaction']) : '';
$external_allergyid = isset($_POST['external_allergyid']) ? add_escape_custom($_POST['external_allergyid']) : '';
$erx_source = isset($_POST['erx_source']) ? add_escape_custom($_POST['erx_source']) : 0;
$erx_uploaded = isset($_POST['erx_uploaded']) ? add_escape_custom($_POST['erx_uploaded']) : 0;

$xml_string = "";
$xml_string = "<list>";

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('patients', 'med', $user);
    
    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $pid;
    
    
    if ($acl_allow) {
        setListTouch($pid, $type);
        
        $strQuery = "INSERT INTO `lists`(`date`, `type`, `title`, `begdate`, `enddate`, `returndate`, `occurrence`, `classification`, `referredby`, `extrainfo`, `diagnosis`, `activity`, `comments`, `pid`, `user`, `groupname`, `outcome`, `destination`, `reinjury_id`, `injury_part`, `injury_type`, `injury_grade`, `reaction`, `external_allergyid`, `erx_source`, `erx_uploaded`) 
                                        VALUES ({$date},'{$type}','{$title}','{$begdate}','{$enddate}','{$returndate}','{$occurrence}','{$classification}','{$referredby}','{$extrainfo}','{$diagnosis}','{$activity}','{$comments}','{$pid}','{$user}','{$groupname}','{$outcome}','{$destination}','{$reinjury_id}','{$injury_part}','{$injury_type}','{$injury_grade}','{$reaction}','{$external_allergyid}','{$erx_source}','{$erx_uploaded}')";
        $result = sqlInsert($strQuery);

        $last_inseted_id = $result;

        $result1 = 1;
        if ($visit_id) {
            $sql_list_query = "INSERT INTO `issue_encounter`(`pid`, `list_id`, `encounter`, `resolved`) 
                            VALUES ('{$pid}','{$last_inseted_id}','{$visit_id}',0)";
            $result1 = sqlInsert($sql_list_query);
        }
        if ($result && $result1) {
            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The {$type} has been added</reason>";
            $xml_string .= "<id>{$last_inseted_id}</id>";
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

$xml_string .= "</list>";
echo $xml_string;
?>