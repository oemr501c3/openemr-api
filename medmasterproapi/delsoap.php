<?php 
	header ("Content-Type:text/xml"); 
	
	$ignoreAuth = true;
//ini_set('display_errors', '1');
require 'classes.php';
	
	$xml_array = array();
	$token = $_POST['token'];
	$id=$_POST['id'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
	$strQuery = "DELETE FROM form_soap WHERE id = $id";
//echo $strQuery;
	$dbresult = $db->query($strQuery);
	if($dbresult)
	{
		$xml_array['status'] = 0;
		$xml_array['reason'] = 'The SOAP has been deleted';
		}	
		else {$xml_array['status'] = 1;
		$xml_array['reason'] = 'ERROR: Sorry, there was an error processing your data. Please re-submit the information again.';
		}
	$xml = ArrayToXML::toXml($xml_array, 'soap');
	echo $xml;
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}
?>