<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once 'classes.php';
$xml_array = array();

$username = $_REQUEST['username'];
$cspin = $_REQUEST['pin'];



$getdashboardinfo = isset($_REQUEST['getdashboardinfo']) ? $_REQUEST['getdashboardinfo'] : true;
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
if ($date == "") {
    $date = date('Y-m-d');
}

$pin = sha1($cspin);

$strQuery = "SELECT * FROM users WHERE username='" . $username . "' AND upin='" . $pin . "'";
$result = sqlQuery($strQuery);

if ($result) {
    $userId = $result['id'];
    $token = getToken($userId);

    $provider_id = $result['id'];
    $xml_array['status'] = 0;
    $xml_array['reason'] = 'User fetched.';
    $xml_array['token'] = $token;
    $xml_array['id'] = $result['id'];
    $xml_array['provider_id'] = $provider_id;
    $xml_array['firstname'] = $result['fname'];
    $xml_array['lastname'] = $result['lname'];
    $xml_array['greeting'] = '';
    $xml_array['title'] = $result['title'];

    if ($getdashboardinfo) {
        
        $appointments = fetchAppointments($date, $date, $patient_id = null, $provider_id, $facility_id = null);
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
        $strQuery = "SELECT * FROM prescriptions WHERE date_added = ? AND provider_id = ?";
        $result = sqlStatement($strQuery,array($date,$provider_id));

        if ($result->_numOfRows > 0) {
            $xml_array["Prescriptionlist"]['status'] = 0;
            $xml_array["Prescriptionlist"]['reason'] = 'Prescriptions records fetched.';
            
            while ($res = sqlFetchArray($result)) {

                foreach ($res as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_array["Prescriptionlist"]['Prescription-' . $i][$fieldName] = $rowValue;
                }
            }
        } else {
            $xml_array["Prescriptionlist"]['status'] = -1;
            $xml_array["Prescriptionlist"]['reason'] = 'Prescription not found.';
        }

        $labQuery = "SELECT *
                        FROM `categories` AS c
                        INNER JOIN `categories_to_documents` AS ctd ON c.id = ctd.category_id
                        INNER JOIN `documents` AS d ON ctd.document_id = d.id
                        INNER JOIN `patient_data` AS pd ON pd.pid = d.foreign_id
                        WHERE c.id = 2 AND d.docdate = ? AND pd.providerID = ?";

        $labresult = sqlStatement($labQuery,array($date,$provider_id));

        if ($labresult) {
            $xml_array["Labresultslist"]['status'] = 0;
            $xml_array["Labresultslist"]['reason'] = 'Lab Results fetched';

            while ($labres = sqlFetchArray($labresult)) {
                foreach ($labres as $fieldName => $fieldValue) {
                    if ($fieldName == 'url') {
                        if (!empty($fieldValue)) {
                            $fieldValue = getUrl($fieldValue);
                        } else {
                            $fieldValue = '';
                        }
                    }
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_array["Labresultslist"]['Labresult-' . $i][$fieldName] = $rowValue;
                }
            }
        } else {
            $xml_array["Labresultslist"]['status'] = -1;
            $xml_array["Labresultslist"]['reason'] = 'Lab results not found';
        }
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


        $messageResult = sqlStatement($sql, array($username));
        if ($messageResult->_numOfRows > 0) {
            $xml_array["Messages"]['status'] = 0;
            $xml_array["Messages"]['reason'] = 'Messages Processed successfully';

            $count = 1;

            while ($myrow = sqlFetchArray($messageResult)) {
                foreach ($myrow as $fieldName => $fieldValue) {
                    $rowValue = xmlsafestring($fieldValue);
                    $xml_array["Messages"]['Message-' . $count][$fieldName] = $rowValue;
                }$count++;
            }
        } else {
            $xml_array["Messages"]['status'] = -1;
            $xml_array["Messages"]['reason'] = 'Messages not found.';
        }
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    newEvent($event = 'login', $username, $groupname = 'Default', $success = '1', 'success: ' . $ip);
} else {
    $xml_array['status'] = -1;
    $xml_array['reason'] = 'Username/Password incorrect.';
}

$xml = ArrayToXML::toXml($xml_array, 'MedMasterUser');
echo $xml;