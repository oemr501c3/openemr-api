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
require_once('classes.php');

$xml_array = array();

$token = $_POST['token'];
$patientId = add_escape_custom($_POST['patientId']);

$id = add_escape_custom($_POST['id']);

$title = add_escape_custom($_POST['title']);
$language = add_escape_custom($_POST['language']); //d
$firstname = add_escape_custom($_POST['firstname']); // d
$lastname = add_escape_custom($_POST['lastname']); //d
$middlename = add_escape_custom($_POST['middlename']); //d
$dob = $_POST['dob']; //d
$street = add_escape_custom($_POST['street']); // streetAddressLine1, streetAddressLine2
$postal_code = add_escape_custom($_POST['postal_code']); // ZipCode d
$city = add_escape_custom($_POST['city']); //d
$state = add_escape_custom($_POST['state']); //d
$country_code = add_escape_custom($_POST['country_code']);
$ss = add_escape_custom($_POST['ss']); // if suffix d
$occupation = add_escape_custom($_POST['occupation']);
$phone_home = add_escape_custom($_POST['phone_home']); //d
$phone_biz = add_escape_custom($_POST['phone_biz']); //d
$phone_contact = add_escape_custom($_POST['phone_contact']); // d
$phone_cell = add_escape_custom($_POST['phone_cell']); //d
$status = add_escape_custom($_POST['status']);
$drivers_lincense = add_escape_custom($_POST['drivers_license']);
$contact_relationship = add_escape_custom($_POST['contact_relationship']); //d
$sex = add_escape_custom($_POST['sex']); //d
$email = add_escape_custom($_POST['email']); //d
$race = add_escape_custom($_POST['race']); //d
$ethnicity = add_escape_custom($_POST['ethnicity']); //d
$usertext1 = add_escape_custom($_POST['notes']); // note d
$nickname = add_escape_custom($_POST['nickname']);
$mothersname = add_escape_custom($_POST['mothersname']);
$guardiansname = add_escape_custom($_POST['guardiansname']);

$p_insurance_company = add_escape_custom($_POST['p_provider']);
$p_subscriber_employer_status = add_escape_custom($_POST['p_subscriber_employer']);
$p_group_number = add_escape_custom($_POST['p_group_number']);
$p_plan_name = add_escape_custom($_POST['p_plan_name']);
$p_subscriber_relationship = add_escape_custom($_POST['p_subscriber_relationship']);
$p_insurance_id = add_escape_custom($_POST['p_insurance_id']);


$s_insurance_company = add_escape_custom($_POST['s_provider']);
$s_subscriber_employer_status = add_escape_custom($_POST['s_subscriber_employer']);
$s_group_number = add_escape_custom($_POST['s_group_number']);
$s_plan_name = add_escape_custom($_POST['s_plan_name']);
$s_subscriber_relationship = add_escape_custom($_POST['s_subscriber_relationship']);
$s_insurance_id = add_escape_custom($_POST['s_insurance_id']);

$o_insurance_company = add_escape_custom($_POST['o_provider']);
$o_subscriber_employer_status = add_escape_custom($_POST['o_subscriber_employer']);
$o_group_number = add_escape_custom($_POST['o_group_number']);
$o_plan_name = add_escape_custom($_POST['o_plan_name']);
$o_subscriber_relationship = add_escape_custom($_POST['o_subscriber_relationship']);
$o_insurance_id = add_escape_custom($_POST['o_insurance_id']);

$image_data = isset($_POST['image_data']) ? $_POST['image_data'] : '';

if ($userId = validateToken($token)) {
    $user_data = getUserData($userId);

    $user = $user_data['user'];
    $emr = $user_data['emr'];
    $username = $user_data['username'];
    $password = $user_data['password'];
    $acl_allow = acl_check('patients', 'demo', $user);

    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patientId;

    if ($acl_allow) {

        $postData = array(
            'id' => $id,
            'title' => $title,
            'fname' => $firstname,
            'lname' => $lastname,
            'mname' => $middlename,
            'sex' => $sex,
            'status' => $status,
            'drivers_license' => $drivers_lincense,
            'contact_relationship' => $contact_relationship,
            'phone_biz' => $phone_biz,
            'phone_cell' => $phone_cell,
            'phone_contact' => $phone_contact,
            'phone_home' => $phone_home,
            'DOB' => $dob,
            'language' => $language,
            'financial' => $financial,
            'street' => $street,
            'postal_code' => $postal_code,
            'city' => $city,
            'state' => $state,
            'country_code' => $country_code,
            'ss' => $ss,
            'occupation' => $occupation,
            'email' => $email,
            'race' => $race,
            'ethnicity' => $ethnicity,
            'usertext1' => $usertext1,
            'genericname1' => $nickname,
            'mothersname' => $mothersname,
            'guardiansname' => $guardiansname,
        );


        updatePatientData($patientId, $postData, $create = false);


        $primary_insurace_data = getInsuranceData($patientId);

        $secondary_insurace_data = getInsuranceData($patientId, 'secondary');

        $other_insurace_data = getInsuranceData($patientId, 'tertiary');

        $p_insurace_data = array(
            'provider' => $p_insurance_company,
            'group_number' => $p_group_number,
            'plan_name' => $p_plan_name,
            'subscriber_employer' => $p_subscriber_employer_status,
            'subscriber_relationship' => $p_subscriber_relationship,
            'policy_number' => $p_insurance_id
        );

        if ($primary_insurace_data) {
            updateInsuranceData($primary_insurace_data['id'], $p_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "primary", $p_insurance_company, $policy_number = $p_insurance_id, $group_number = $p_group_number, $plan_name = $p_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship =
                    $p_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer =
                    $p_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE"
            );
        }

        $s_insurace_data = array(
            'provider' => $s_insurance_company,
            'group_number' => $s_group_number,
            'plan_name' => $s_plan_name,
            'subscriber_employer' => $s_subscriber_employer_status,
            'subscriber_relationship' => $s_subscriber_relationship,
            'policy_number' => $s_insurance_id
        );

        if ($secondary_insurace_data) {
            updateInsuranceData($secondary_insurace_data['id'], $s_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "secondary", $s_insurance_company, $policy_number = $s_insurance_id, $group_number = $s_group_number, $plan_name = $s_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship = $s_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer = $s_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE");
        }

        $o_insurace_data = array(
            'provider' => $o_insurance_company,
            'group_number' => $o_group_number,
            'plan_name' => $o_plan_name,
            'subscriber_employer' => $o_subscriber_employer_status,
            'subscriber_relationship' => $o_subscriber_relationship,
            'policy_number' => $o_insurance_id
        );

        if ($other_insurace_data) {
            updateInsuranceData($other_insurace_data['id'], $o_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "tertiary", $o_insurance_company, $policy_number = $o_insurance_id, $group_number = $o_group_number, $plan_name = $o_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship = $o_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer = $o_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE");
        }


        if ($image_data) {

            $id = 1;
            $type = "file_url";
            $size = '';
            $date = date('Y-m-d H:i:s');
            $url = '';
            $mimetype = 'image/jpeg';
            $hash = '';
            $patient_id = $patientId;
            $ext = 'png';
            $cat_title = 'Patient Profile Image';

            $strQuery2 = "SELECT id from `categories` WHERE name LIKE '{$cat_title}'";
            $result3 = $db->get_row($strQuery2);

            if ($result3) {
                $cat_id = $result3->id;
            } else {
                sqlStatement("lock tables categories read");

                $result4 = sqlQuery("select max(id)+1 as id from categories");

                $cat_id = $result4['id'];

                sqlStatement("unlock tables");

                $cat_insert_query = "INSERT INTO `categories`(`id`, `name`, `value`, `parent`, `lft`, `rght`) 
                VALUES ({$cat_id},'{$cat_title}','',1,0,0)";

                sqlStatement($cat_insert_query);
            }

            $strQuery4 = "SELECT d.url,d.id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE d.foreign_id ={$patient_id}
                                AND c2d.category_id ={$cat_id}
                                ORDER BY category_id, d.date DESC";

            $result4 = $db->get_results($strQuery4);

            if ($result4) {
                $file_path = $result4[0]->url;
                $document_id = $result4[0]->id;
                unlink($file_path);

                $strQueryD = "DELETE FROM `documents` WHERE id =?";
                $resultD = sqlStatement($strQueryD, array($document_id));

                $strQueryD1 = "DELETE FROM `categories_to_documents` WHERE document_id =?";
                $resultD = sqlStatement($strQueryD1, array($document_id));
            }

            $image_path = $sitesDir . "{$site}/documents/{$patient_id}";

            if (!file_exists($image_path)) {
                mkdir($image_path);
            }

            $image_date = date('Y-m-d_H-i-s');

            file_put_contents($image_path . "/" . $image_date . "." . $ext, base64_decode($image_data));


            sqlStatement("lock tables documents read");

            $result = sqlQuery("select max(id)+1 as did from documents");

            sqlStatement("unlock tables");

            if ($result['did'] > 1) {
                $id = $result['did'];
            }

            $hash = sha1_file($image_path . "/" . $image_date . "." . $ext);

            $url = "file://" . $image_path . "/" . $image_date . "." . $ext;

            $size = filesize($url);

            $strQuery = "INSERT INTO `documents`( `id`, `type`, `size`, `date`, `url`, `mimetype`, `foreign_id`, `docdate`, `hash`, `list_id`) 
             VALUES ({$id},'{$type}','{$size}','{$date}','{$url}','{$mimetype}',{$patient_id},'{$docdate}','{$hash}','{$list_id}')";

            $result = sqlStatement($strQuery);

            $strQuery1 = "INSERT INTO `categories_to_documents`(`category_id`, `document_id`) VALUES ({$cat_id},{$id})";

            $result1 = sqlStatement($strQuery1);
        }


        $xml_array['status'] = 0;
        $xml_array['reason'] = 'Patient updated successfully';
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'You are not Authorized to perform this action';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}

$xml = ArrayToXML::toXml($xml_array, 'Patient');
echo $xml;
?>