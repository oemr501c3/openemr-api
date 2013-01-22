<?php

//	header ("Content-Type:text/xml");
$ignoreAuth = true;
require ("classes.php");

$xml_string = "";
$xml_string = "<facility>";

$token = $_POST['token'];

//$token = 'fe15082d987f3fd5960a712c54494a68';

$name = $_POST['name'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal_code = $_POST['postal_code'];
$country_code = $_POST['country_code'];
$federal_ein = $_POST['federal_ein'];
$service_location = $_POST['service_location'];
$billing_location = $_POST['billing_location'];
$accepts_assignment = $_POST['accepts_assignment'];
$pos_code = $_POST['pos_code'];
$x12_sender_id = $_POST['x12_sender_id'];
$attn = $_POST['attn'];
$domain_identifier = $_POST['domain_identifier'];
$facility_npi = $_POST['facility_npi'];
$tax_id_type = $_POST['tax_id_type'];
$color = $_POST['color'];
$primary_business_entity = 0;

/*
  $name = "haroon";
  $phone = "38373388";
  $fax ="738373939";
  $street = "house 33 st 33";
  $city = "isb";
  $state = "kp";
  $postal_code = "33333";
  $country_code = "am";
  $federal_ein = "833938";
  $service_location = "11";
  $billing_location = "34";
  $accepts_assignment = "54";
  $pos_code = "38";
  $x12_sender_id = "ha";
  $attn = "333";
  $domain_identifier = "huu3";
  $facility_npi = "83ikj";
  $tax_id_type = "33333";
  $color = "#99d99d";
  $primary_business_entity = 0; */

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $strQuery = "INSERT INTO facility (name, phone, fax, street, city, state, postal_code, country_code, federal_ein, service_location, billing_location, accepts_assignment, pos_code, x12_sender_id, attn, domain_identifier, facility_npi, tax_id_type, color, primary_business_entity) 
        VALUES ('" . $name . "', '" . $phone . "', '" . $fax . "', '" . $street . "', '" . $city . "', '" . $state . "', '" . $postal_code . "', '" . $country_code . "', '" . $federal_ein . "', '" . $service_location . "', '" . $billing_location . "', '" . $accepts_assignment . "', '" . $pos_code . "', '" . $x12_sender_id . "', '" . $attn . "', '" . $domain_identifier . "', '" . $facility_npi . "', '" . $tax_id_type . "', '" . $color . "', '" . $primary_business_entity . "')";
    $result = $db->query($strQuery);

    if ($result) {
        newEvent($event = 'facility-record-add', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Facility has been added</reason>";
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</facility>";
echo $xml_string;
?>