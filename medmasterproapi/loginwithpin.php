<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';
//ini_set('display_errors', '1');
$xml_array = array();

$username = $_REQUEST['username'];
$cspin = $_REQUEST['pin'];
$getdashboardinfo = isset($_REQUEST['getdashboardinfo']) ? $_REQUEST['getdashboardinfo'] : true;
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
if($date == ""){
   $date = date('Y-m-d');
}

$pin = sha1($cspin);

$strQuery = "SELECT * FROM medmasterusers WHERE username='" . $username . "' AND pin='" . $pin . "'";
$result = $db->get_row($strQuery);

if ($result) {
    $userId = $result->id;
    $token = getToken($userId);
     
    $provider_id = $result->uid;
    $xml_array['status'] = 0;
    $xml_array['reason'] = 'User fetched.';
    $xml_array['token'] = $token;
    $xml_array['id'] = $result->id;
    $xml_array['provider_id'] = $provider_id;
    $xml_array['firstname'] = $result->firstname;
    $xml_array['lastname'] = $result->lastname;
    $xml_array['greeting'] = $result->greeting;
    $xml_array['title'] = $result->title;
    
    if ($getdashboardinfo) {
//        $date = date('Y-m-d');
//        $date = "2012-07-24";
        $appointments = fetchAppointments($date, $date, $patient_id = null, $provider_id, $facility_id = null);
//    echo var_dump($appointments);

        if ($appointments) {
            foreach ($appointments as $key => $appointment) {
                $xml_array["Appointmentlist"]["Appointment-$key"] = $appointment;
            }
        } else {
            $xml_array["Appointmentlist"]['status'] = -1;
            $xml_array["Appointmentlist"]['reason'] = 'Appointment not found.';
        }
        /**
         * Particular Date prescription 
         */
        $strQuery = "SELECT * FROM prescriptions WHERE date_added = '{$date}' AND provider_id = {$provider_id}";
        $result = $db->get_results($strQuery);

        if ($result) {
            $xml_array["Prescriptionlist"]['status'] = 0;
            $xml_array["Prescriptionlist"]['reason'] = 'Prescriptions records fetched.';

//            $xml_string1 .= "<status>0</status>\n";
//            $xml_string1 .= "<reason>Success processing patient prescriptions records</reason>\n";

            for ($i = 0; $i < count($result); $i++) {
//                $xml_string1 .= "<prescription>\n";

                foreach ($result[$i] as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
//                    $xml_string1 .= "<$fieldName>$rowValue</$fieldName>\n";
                    $xml_array["Prescriptionlist"]['Prescription-' . $i][$fieldName] = $rowValue;
                }

//                $xml_string1 .= "</prescription>\n";
            }
        } else {
//            $xml_string1 .= "<status>-1</status>\n";
//            $xml_string1 .= '<reason>Cound not find prescription results</reason>\n';
            $xml_array["Prescriptionlist"]['status'] = -1;
            $xml_array["Prescriptionlist"]['reason'] = 'Prescription not found.';
        }
//        $xml_array['prescriptionlist'] = $xml_string1;

        /**
         * Particular date lab reports 
         */
        $labQuery = "SELECT *
                        FROM `categories` AS c
                        INNER JOIN `categories_to_documents` AS ctd ON c.id = ctd.category_id
                        INNER JOIN `documents` AS d ON ctd.document_id = d.id
                        INNER JOIN `patient_data` AS pd ON pd.pid = d.foreign_id
                        WHERE c.id = 2 AND d.docdate = '{$date}' AND pd.providerID = $provider_id";
//      echo $labQuery;exit;  
        $labresult = $db->get_results($labQuery);

        if ($labresult) {
            $xml_array["Labresultslist"]['status'] = 0;
            $xml_array["Labresultslist"]['reason'] = 'Lab Results fetched';

//            $xml_string2 .= "<status>0</status>\n";
//            $xml_string2 .= "<reason>Success processing patient prescriptions records</reason>\n";
            for ($i = 0; $i < count($labresult); $i++) {
//                $xml_string2 .= "<labresult>\n";

                foreach ($labresult[$i] as $fieldName => $fieldValue) {
                    if ($fieldName == 'url') {
                        if (!empty($fieldValue)) {
                            $fieldValue = getUrl($fieldValue);
                        } else {
                            $fieldValue = '';
                        }
                    }
                    $rowValue = xmlsafestring($fieldValue);
//                    $xml_string2 .= "<$fieldName>$rowValue</$fieldName>\n";
                    $xml_array["Labresultslist"]['Labresult-' . $i][$fieldName] = $rowValue;
                }

//                $xml_string2 .= "</labresult>\n";
            }
        } else {
            $xml_array["Labresultslist"]['status'] = -1;
            $xml_array["Labresultslist"]['reason'] = 'Lab results not found';

//            $xml_string2 .= "<status>-1</status>";
//            $xml_string2 .= "<reason>Could find any lab results for today</reason>";
        }
//        $xml_array['labresultslist'] = $xml_string2;
        /**
         * User Messages 
         */
        $sql = "SELECT pnotes.id, pnotes.user, pnotes.pid, pnotes.title, pnotes.date,pnotes.body, pnotes.message_status, 
                        IF(pnotes.user != pnotes.pid,users.fname,patient_data.fname) as users_fname,
                        IF(pnotes.user != pnotes.pid,users.lname,patient_data.lname) as users_lname,
                        patient_data.fname as patient_data_fname, patient_data.lname as patient_data_lname
                        FROM ((pnotes LEFT JOIN users ON pnotes.user = users.username) 
                        JOIN patient_data ON pnotes.pid = patient_data.pid) WHERE pnotes.message_status LIKE 'New' 
                        AND pnotes.deleted != '1' AND pnotes.date >= '{$date} 00:00:00' AND pnotes.date <= '{$date} 24:00:00' AND pnotes.assigned_to LIKE ?";



//        $result = sqlStatement($sql, array($username));
//
//        $labresult = $db->get_results($labQuery);

        $messageResult = sqlStatement($sql, array($username));
        if ($messageResult->_numOfRows > 0) {
//            $xml_string_message .= "<status>0</status>";
//            $xml_string_message .= "<reason>Messages Processed successfully</reason>";
            $xml_array["Messages"]['status'] = 0;
            $xml_array["Messages"]['reason'] = 'Messages Processed successfully';

            $count = 1;

            while ($myrow = sqlFetchArray($messageResult)) {
//                $xml_string_message .= "<Message>\n";
                foreach ($myrow as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
//                    $xml_string_message .= "<$fieldName>$rowValue</$fieldName>\n";
                    $xml_array["Messages"]['Message-' . $count][$fieldName] = $rowValue;
                }
//                $xml_string_message .= "</Message>\n";
                $count++;
            }
        } else {
            $xml_array["Messages"]['status'] = -1;
            $xml_array["Messages"]['reason'] = 'Messages not found.';
        }
    }



} else {
    $xml_array['status'] = -1;
    $xml_array['reason'] = 'Invalid Pin.';
}

$xml = ArrayToXML::toXml($xml_array, 'MedMasterUser');
echo $xml;
?>