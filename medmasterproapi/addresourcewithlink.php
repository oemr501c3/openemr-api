<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');
//error_reporting(0);
$xml_array = array();

$token = $_POST['token'];
$title = $_POST['title'];
$option_id = $_POST['option_id'];
$type = $_POST['type'];
//$url = $_POST['url'];
$link = isset($_POST['link']) ? $_POST['link'] : '';
$ext = $_POST['ext'];

//$token = '6f61bfa8d744e13bccabc422d8b28fa0';
//$title = 'PDF';
//$option_id = 'pdf';
//$ext = 'pdf';
//$type = 'link';
//$type = 'image';
//$type = 'pdf';
//$type = 'video';
//$link = 'http://media.giantbomb.com/uploads/0/5911/951077-ezio_super.png';
//$link = 'http://images.autodesk.com/adsk/files/cust_success_assassin_s_creed_v3.pdf';

$list_id = 'ExternalResources';
$seq = 0;
$is_default = 0;
$notes = '';
$mapping = '';


if ($userId = validateToken($token)) {
    $provider_id = getUserProviderId($userId);

    $path = $sitesDir . "{$site}/documents/userdata";
//    $path = $_SERVER['DOCUMENT_ROOT'] . "/openemr/sites/default/documents/userdata";
    
    if (!file_exists($path)) {
        mkdir($path);
        mkdir($path . "/images");
        mkdir($path . "/images/thumb/");
        mkdir($path . "/pdf");
        mkdir($path . "/videos");
    } elseif (!file_exists($path . "/images") || !file_exists($path . "/images/thumb/") || !file_exists($path . "/pdf") || !file_exists($path . "/videos")) {
//      echo "IN second If";
        mkdir($path . "/images");
        mkdir($path . "/images/thumb/");
        mkdir($path . "/pdf");
        mkdir($path . "/videos");
    }

    $data = file_get_contents($link);

    if ($data) {
        switch ($type) {
            case 'link':
                $notes = $link;
                break;
            case 'image':
                $image_date_name = date('Y-m-d_H-i-s');
                $image_name = $image_date_name . "." . $ext;
                $image_path = $path . "/images/" . $image_name;
//            $image_thumb_path = $path . "/images/thumb/" . $image_name;
                file_put_contents($image_path, $data);
                $thumb_path = $path . "/images/thumb/";
                createThumbnail($image_path, $image_date_name, 250,$thumb_path);
//                $notes = $imageURL . '/openemr/sites/default/documents/userdata/images/' . $image_name;
                $notes = $sitesUrl . "{$site}/documents/userdata/images/" . $image_name;
                break;
            case 'pdf':
                $pdf_name = date('Y-m-d_H-i-s') . "." . $ext;
                file_put_contents($path . "/pdf/" . $pdf_name, $data);
//                $notes = $imageURL . '/openemr/sites/default/documents/userdata/pdf/' . $pdf_name;
                 $notes = $sitesUrl . "{$site}/documents/userdata/pdf/" . $pdf_name;
                break;
            case 'video':
                $video_name = date('Y-m-d_H-i-s') . "." . $ext;
                file_put_contents($path . "/videos/" . $video_name, $data);
//                $notes = $imageURL . '/openemr/sites/default/documents/userdata/videos/' . $video_name;
                $notes = $sitesUrl . "{$site}/documents/userdata/videos/" . $video_name;
                break;
        }


        $select_query = "SELECT *  FROM `list_options` 
        WHERE `list_id` LIKE 'lists' AND `option_id` LIKE '{$list_id}' AND `title` LIKE '{$list_id}'";

        $result_select = $db->get_row($select_query);
        $result1 = true;
        if (!$result_select) {
            $insert_list = "INSERT INTO list_options ( list_id, option_id, title, seq, is_default, option_value ) 
                            VALUES ( 'lists','{$list_id}','{$list_id}', '0','1', '0')";
            $result1 = $db->query($insert_list);
        }

        $strQuery = "INSERT INTO `list_options`(`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) 
                        VALUES ('{$list_id}','{$option_id}','{$title}','{$seq}','{$is_default}','{$provider_id}','{$mapping}','{$notes}')";


        $result = $db->query($strQuery);

        if ($result && $result1) {
            newEvent($event = 'other-insert', $user, $groupname = 'Default', $success = '1', $comments = $strQuery);
            $xml_array['status'] = "0";
            $xml_array['reason'] = "The Resource has been added";
        } else {
            $xml_array['status'] = "-1";
            $xml_array['reason'] = "ERROR: Sorry, there was an error processing your data. Please re-submit the information again.";
        }
    } else {
        $xml_array['status'] = "-1";
        $xml_array['reason'] = "Invalid Url (Resource not found)";
    }
} else {
    $xml_array['status'] = "-2";
    $xml_array['reason'] = 'Invalid Token';
}


$xml = ArrayToXML::toXml($xml_array, 'Resource');
echo $xml;
?>