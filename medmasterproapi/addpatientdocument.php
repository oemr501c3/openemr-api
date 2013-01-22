<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');
//ini_set('display_errors', '1');
$xml_array = array();

$token = $_POST['token'];

//$token = 'fe15082d987f3fd5960a712c54494a68';

$patient_id = $_POST['patientId'];
$docdate = $_POST['docDate'];
$list_id = isset($_POST['listId']) ? $_POST['listId'] : 0;
//$category_id = $_POST['categoryId'];
$cat_id = $_POST['categoryId'];
$image_content = $_POST['data'];
$ext = $_POST['docType'];
$mimetype = $_POST['mimeType'];
//$patient_id = 1;
//$docdate = 2012-09-10;
//$list_id = 0;
//$category_id = 3;
//sha1_file
//$image_content = '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';


if ($userId = validateToken($token)) {
    $provider_id = getPatientsProvider($patient_id);
    $provider_username = getProviderUsername($provider_id);

    $id = 1;
    $type = "file_url";
    $size = '';
    $date = date('Y-m-d H:i:s');
    $url = '';
//        $mimetype = 'image/jpeg';
    $hash = '';

//    $image_path = $_SERVER['DOCUMENT_ROOT'] . "/openemr/sites/default/documents/{$patient_id}";
    $image_path = $sitesDir . "{$site}/documents/{$patient_id}";

    if (!file_exists($image_path)) {
        mkdir($image_path);
    }

//        switch ($category_id) {
//            case 1: // Patient Photograph
//                $cat_id = 10;
//                break;
//            case 2: // Patient ID card
//                $cat_id = 5;
//                break;
//            case 3: // Medical Record
//                $cat_id = 3;
//                break;
//            case 4: // Lab report
//                $cat_id = 2;
//                break;
//        }

    $image_date = date('Y-m-d_H-i-s');

    file_put_contents($image_path . "/" . $image_date . "." . $ext, base64_decode($image_content));


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

    $result = $db->query($strQuery);

    $strQuery1 = "INSERT INTO `categories_to_documents`(`category_id`, `document_id`) VALUES ({$cat_id},{$id})";

    $result1 = $db->query($strQuery1);

    if ($cat_id == 2) {
        $device_token_badge = getDeviceTokenBadge($provider_username, 'labreport');
        $badge = $device_token_badge ['badge'];
        $deviceToken = $device_token_badge ['device_token'];
        if ($deviceToken) {
            $notification_res = notification($deviceToken, $badge, $msg_count = 0, $apt_count = 0, $message = 'New Labreport Notification!');
        }
    }

    if ($result && $result1) {
//            newEvent($event = 'patient-record-add', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
        $xml_array['status'] = "0";
        $xml_array['reason'] = "The Image has been added";
        if ($notification_res) {
            $xml_array['notification'] = 'Add Patient document Notification(' . $notification_res . ')';
        } else {
            $xml_array['notification'] = 'Notificaiotn Failed.';
        }
    } else {
        $xml_array['status'] = "-1";
        $xml_array['reason'] = "ERROR: Sorry, there was an error processing your data. Please re-submit the information again.";
    }
//    } else {
//        $xml_array['status'] = "-3";
//        $xml_array['reason'] = "Invalid Secret Key";
//    }
} else {
    $xml_array['status'] = "-2";
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'PatientImage');
echo $xml;
?>
