<?php
header("Content-Type:text/xml");
$ignoreAuth = true;
require 'classes.php';

$xml_string = "";
$xml_string = "<contacts>";

$token = $_POST['token'];
/* $token = 'a9b450867020dc6bb08f3c94f9f3efe9'; */

if ($userId = validateToken($token)) {
    $provider_id = getUserProviderId($userId);
    $strQuery = "SELECT id,username, password, authorized, info, source, title, fname, lname, mname,  upin, see_auth, active, npi, taxonomy, specialty, organization, valedictory, assistant, email, url, street, streetb, city, state, zip, phone, phonew1, phonew2, phonecell, fax, notes FROM users WHERE username=" . $provider_id;
    $result = $db->get_results($strQuery);

    if ($result) {
        $xml_string .= "<status>0</status>";
        $xml_string .= "<reason>The Contact Record has been fetched</reason>";

        for ($i = 0; $i < count($result); $i++) {
            $xml_string .= "<contact>\n";

            foreach ($result[$i] as $fieldName => $fieldValue) {
                $rowValue = xmlsafestring($fieldValue);
                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
            }

            $xml_string .= "</contact>\n";
        }
    } else {
        $xml_string .= "<status>-1</status>";
        $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</contacts>";
echo $xml_string;
?>