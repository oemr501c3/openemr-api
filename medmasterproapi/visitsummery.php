<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');
require ('includes/pdflibrary/config/lang/eng.php');
require ('includes/pdflibrary/tcpdf.php');

$xml_string = "";

$token = $_POST['token'];
$visit_id = $_POST['visit_id'];

//$token = 'fe15082d987f3fd5960a712c54494a68';
//$visit_id = 10;


if ($userId = validateToken($token)) {
    $user = getUsername($userId);

    $strQuery = "SELECT * , MAX( DATE ) , MAX( form_id ) AS form_id_max, COUNT( 0 ) AS count
                            FROM  `forms` 
                            WHERE encounter = {$visit_id}
                            GROUP BY form_name";

    $result = $db->get_results($strQuery);

    $ros_check = false;
    $rosc_check = false;
    $soap_check = false;
    $vitals_check = false;

    $total_ros = 0;
    $ros_data = array();

    $total_ros_checks = 0;
    $ros_data_checks = array();

    $total_vitals = 0;
    $vital_data = array();

    $total_soap = 0;
    $soap_data = array();

//    echo $strQuery;
    if ($result) {

        foreach ($result as $record) {
//            var_dump($record);continue;
            switch ($record->form_name) {
                case 'Review Of Systems':
                    $strQuery1 = "SELECT * 
                                        FROM  `form_ros` 
                                        WHERE  `id` = {$record->form_id_max}";
                    $ros = $db->get_results($strQuery1);
                    if ($ros) {
                        for ($i = 0; $i < count($ros); $i++) {
                            $xml_string .= "<ROS>\n";
                            $xml_string .= "<records>{$record->count}</records>\n";
                            foreach ($ros[$i] as $fieldName => $fieldValue) {
                                $rowValue = xmlsafestring($fieldValue);
                                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                            }
                            $xml_string .= "</ROS>\n";
                            $ros_data = $ros[$i];
                        }
                    } else {
                        $xml_string .= "<ROS><records>0</records></ROS>\n";
                    }
                    $total_ros = $record->count;
                    $ros_check = true;
                    break;
                case 'Review of Systems Checks':
                    $strQuery2 = "SELECT * 
                                        FROM  `form_reviewofs` 
                                        WHERE  `id` = {$record->form_id_max}";
                    $rosc = $db->get_results($strQuery2);

                    if ($rosc) {
                        for ($i = 0; $i < count($rosc); $i++) {
                            $xml_string .= "<ROSchecks>\n";
                            $xml_string .= "<records>{$record->count}</records>\n";

                            foreach ($rosc[$i] as $fieldName => $fieldValue) {
                                $rowValue = xmlsafestring($fieldValue);
                                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                            }
                            $xml_string .= "</ROSchecks>\n";
                            $ros_data_checks = $rosc[$i];
                        }
                    } else {
                        $xml_string .= "<ROSchecks><records>0</records></ROSchecks>\n";
                    }
                    $rosc_check = true;
                    $total_ros_checks = $record->count;
                    break;
                case 'SOAP':
                    $strQuery3 = "SELECT * 
                                        FROM  `form_soap` 
                                        WHERE  `id` = {$record->form_id_max}";
                    $soap = $db->get_results($strQuery3);
                    if ($soap) {
                        for ($i = 0; $i < count($soap); $i++) {
                            $xml_string .= "<SOAP>\n";
                            $xml_string .= "<records>{$record->count}</records>\n";

                            foreach ($soap[$i] as $fieldName => $fieldValue) {
                                $rowValue = xmlsafestring($fieldValue);
                                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                            }
                            $xml_string .= "</SOAP>\n";
                            $soap_data = $soap[$i];
                        }
                    } else {
                        $xml_string .= "<SOAP><records>0</records></SOAP>\n";
                    }
                    $total_soap = $record->count;
                    $soap_check = true;
                    break;
                case 'Vitals':
                    $strQuery4 = "SELECT * 
                                        FROM  `form_vitals` 
                                        WHERE  `id` = {$record->form_id_max}";
                    $vitals = $db->get_results($strQuery4);
                    if ($vitals) {
                        for ($i = 0; $i < count($vitals); $i++) {
                            $xml_string .= "<Vitals>\n";
                            $xml_string .= "<records>{$record->count}</records>\n";

                            foreach ($vitals[$i] as $fieldName => $fieldValue) {
                                $rowValue = xmlsafestring($fieldValue);
                                $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                            }
                            $xml_string .= "</Vitals>\n";

                            $vital_data = $vitals[$i];
                        }
                        $total_vitals = $record->count;
                    } else {
                        $xml_string .= "<Vitals><records>0</records></Vitals>\n";
                    }
                    $vitals_check = true;
                    break;
            }
        }
    }

    if (!$ros_check) {
        $xml_string .= "<ROS><records>0</records></ROS>\n";
    }

    if (!$rosc_check) {
        $xml_string .= "<ROSchecks><records>0</records></ROSchecks>\n";
    }

    if (!$soap_check) {
        $xml_string .= "<SOAP><records>0</records></SOAP>\n";
    }

    if (!$vitals_check) {
        $xml_string .= "<Vitals><records>0</records></Vitals>\n";
    }



    $count_query = "SELECT  `type` , COUNT( 0 ) AS count
                                                        FROM  `issue_encounter` AS ie
                                                        INNER JOIN  `lists` AS l ON ie.list_id = l.id
                                                        WHERE ie.encounter = {$visit_id}
                                                        GROUP BY  `type`";
    $medication_count = 0;
    $allergy_count = 0;
    $medical_problem_count = 0;
    $dental_count = 0;
    $surgery_count = 0;

    $count_results = $db->get_results($count_query);

    $xml_string .= "<Issues>";

    if ($count_results) {
//        var_dump($count_results);
//        exit;
        foreach ($count_results as $count_result) {
            switch ($count_result->type) {
                case 'allergy':
                    $allergy_count = $count_result->count;
                    break;
                case 'dental':
                    $dental_count = $count_result->count;
                    break;
                case 'medical_problem':
                    $medical_problem_count = $count_result->count;
                    break;
                case 'medication':
                    $medication_count = $count_result->count;
                    break;
                case 'surgery':
                    $surgery_count = $count_result->count;
                    break;
            }
        }

        $sql_visits = "SELECT type,title,begdate,diagnosis
                                                                FROM `issue_encounter` AS ie
                                                                INNER JOIN `lists` AS l ON ie.list_id = l.id
                                                                WHERE ie.encounter = " . $visit_id;

        $list_result = $db->get_results($sql_visits);


        if ($list_result) {
            for ($j = 0; $j < count($list_result); $j++) {
                $xml_string .= "<Issue>\n";
                foreach ($list_result[$j] as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_string .= "<$fieldName>$rowValue</$fieldName>\n";
                }
                $xml_string .= "</Issue>\n";
            }
        }
    }
    $xml_string .= "<allergy_count>{$allergy_count}</allergy_count>";
    $xml_string .= "<dental_count>{$dental_count}</dental_count>";
    $xml_string .= "<medical_problem_count>{$medical_problem_count}</medical_problem_count>";
    $xml_string .= "<medication_count>{$medication_count}</medication_count>";
    $xml_string .= "<surgery_count>{$surgery_count}</surgery_count>";
    $xml_string .= "</Issues>";

    if (!$count_results && !$result) {
        $xml_string1 .= "<PatientVisit>";
        $xml_string1 .= "<status>-1</status>";
        $xml_string1 .= "<reason>Rocord not found</reason>";
        $xml_string = $xml_string1 . $xml_string;
    } else {
        $xml_string1 .= "<PatientVisit>";
        $xml_string1 .= "<status>0</status>";
        $xml_string1 .= "<reason>Patient visit processing</reason>";
        $xml_string = $xml_string1 . $xml_string;
    }

//    } else {
//        $xml_string .= "<status>-1</status>";
//        $xml_string .= "<reason>Couldn't Find record</reason>";
//    }
} else {
    $xml_string .= "<PatientVisit>";
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token.</reason>";
}

$html = visitSummeryHtml($total_vitals, $vital_data, $total_soap, $soap_data, $total_ros, $ros_data, $total_ros_checks, $ros_data_checks, $medical_problem_count, $medication_count, $allergy_count, $dental_count, $surgery_count, $visit_id);
//echo $html;

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$encoded_pdf = createPdf($html, $pdf);
//echo $html;
$xml_string .= "<html>" . base64_encode($html) . "</html>";
$xml_string .= "<pdf>" . $encoded_pdf . "</pdf>";

$xml_string .= "</PatientVisit>";
echo $xml_string;
?>
