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
require_once 'classes.php';

$xml_string = "";
$xml_string = "<reviewofsystems>";

$token = $_POST['token'];
$visit_id = add_escape_custom($_POST['visit_id']);

$patientId = add_escape_custom($_POST['pid']);
$activity = isset($_POST['activity']) ? add_escape_custom($_POST['activity']) : 1;
$weight_change = add_escape_custom($_POST['weight_change']);
$weakness = add_escape_custom($_POST['weakness']);
$fatigue = add_escape_custom($_POST['fatigue']);
$anorexia = add_escape_custom($_POST['anorexia']);
$fever = add_escape_custom($_POST['fever']);
$chills = add_escape_custom($_POST['chills']);
$night_sweats = add_escape_custom($_POST['night_sweats']);
$insomnia = add_escape_custom($_POST['insomnia']);
$irritability = add_escape_custom($_POST['irritability']);
$heat_or_cold = add_escape_custom($_POST['heat_or_cold']);
$intolerance = add_escape_custom($_POST['intolerance']);
$change_in_vision = add_escape_custom($_POST['change_in_vision']);
$glaucoma_history = add_escape_custom($_POST['glaucoma_history']);
$eye_pain = add_escape_custom($_POST['eye_pain']);
$irritation = add_escape_custom($_POST['irritation']);
$redness = add_escape_custom($_POST['redness']);
$excessive_tearing = add_escape_custom($_POST['excessive_tearing']);
$double_vision = add_escape_custom($_POST['double_vision']);
$blind_spots = add_escape_custom($_POST['blind_spots']);
$photophobia = add_escape_custom($_POST['photophobia']);
$hearing_loss = add_escape_custom($_POST['hearing_loss']);
$discharge = add_escape_custom($_POST['discharge']);
$pain = add_escape_custom($_POST['pain']);
$vertigo = add_escape_custom($_POST['vertigo']);
$tinnitus = add_escape_custom($_POST['tinnitus']);
$frequent_colds = add_escape_custom($_POST['frequent_colds']);
$sore_throat = add_escape_custom($_POST['sore_throat']);
$sinus_problems = add_escape_custom($_POST['sinus_problems']);
$post_nasal_drip = add_escape_custom($_POST['post_nasal_drip']);
$nosebleed = add_escape_custom($_POST['nosebleed']);
$snoring = add_escape_custom($_POST['snoring']);
$apnea = add_escape_custom($_POST['apnea']);
$breast_mass = add_escape_custom($_POST['breast_mass']);
$breast_discharge = add_escape_custom($_POST['breast_discharge']);
$biopsy = add_escape_custom($_POST['biopsy']);
$abnormal_mammogram = add_escape_custom($_POST['abnormal_mammogram']);
$cough = add_escape_custom($_POST['cough']);
$sputum = add_escape_custom($_POST['sputum']);
$shortness_of_breath = add_escape_custom($_POST['shortness_of_breath']);
$wheezing = add_escape_custom($_POST['wheezing']);
$hemoptsyis = add_escape_custom($_POST['hemoptsyis']);
$asthma = add_escape_custom($_POST['asthma']);
$copd = add_escape_custom($_POST['copd']);
$chest_pain = add_escape_custom($_POST['chest_pain']);
$palpitation = add_escape_custom($_POST['palpitation']);
$syncope = add_escape_custom($_POST['syncope']);
$pnd = add_escape_custom($_POST['pnd']);
$doe = add_escape_custom($_POST['doe']);
$orthopnea = add_escape_custom($_POST['orthopnea']);
$peripheal = add_escape_custom($_POST['peripheal']);
$edema = add_escape_custom($_POST['edema']);
$legpain_cramping = add_escape_custom($_POST['legpain_cramping']);
$history_murmur = add_escape_custom($_POST['history_murmur']);
$arrythmia = add_escape_custom($_POST['arrythmia']);
$heart_problem = add_escape_custom($_POST['heart_problem']);
$dysphagia = add_escape_custom($_POST['dysphagia']);
$heartburn = add_escape_custom($_POST['heartburn']);
$bloating = add_escape_custom($_POST['bloating']);
$belching = add_escape_custom($_POST['belching']);
$flatulence = add_escape_custom($_POST['flatulence']);
$nausea = add_escape_custom($_POST['nausea']);
$vomiting = add_escape_custom($_POST['vomiting']);
$hematemesis = add_escape_custom($_POST['hematemesis']);
$gastro_pain = add_escape_custom($_POST['gastro_pain']);
$food_intolerance = add_escape_custom($_POST['food_intolerance']);
$hepatitis = add_escape_custom($_POST['hepatitis']);
$jaundice = add_escape_custom($_POST['jaundice']);
$hematochezia = add_escape_custom($_POST['hematochezia']);
$changed_bowel = add_escape_custom($_POST['changed_bowel']);
$diarrhea = add_escape_custom($_POST['diarrhea']);
$constipation = add_escape_custom($_POST['constipation']);
$polyuria = add_escape_custom($_POST['polyuria']);
$polydypsia = add_escape_custom($_POST['polydypsia']);
$dysuria = add_escape_custom($_POST['dysuria']);
$hematuria = add_escape_custom($_POST['hematuria']);
$frequency = add_escape_custom($_POST['frequency']);
$urgency = add_escape_custom($_POST['urgency']);
$incontinence = add_escape_custom($_POST['incontinence']);
$renal_stones = add_escape_custom($_POST['renal_stones']);
$utis = add_escape_custom($_POST['utis']);
$hesitancy = add_escape_custom($_POST['hesitancy']);
$dribbling = add_escape_custom($_POST['dribbling']);
$stream = add_escape_custom($_POST['stream']);
$nocturia = add_escape_custom($_POST['nocturia']);
$erections = add_escape_custom($_POST['erections']);
$ejaculations = add_escape_custom($_POST['ejaculations']);
$g = add_escape_custom($_POST['g']);
$p = add_escape_custom($_POST['p']);
$ap =add_escape_custom($_POST['ap']);
$lc = add_escape_custom($_POST['lc']);
$mearche = add_escape_custom($_POST['mearche']);
$menopause = add_escape_custom($_POST['menopause']);
$lmp = add_escape_custom($_POST['lmp']);
$f_frequency = add_escape_custom($_POST['f_frequency']);
$f_flow = add_escape_custom($_POST['f_flow']);
$f_symptoms = add_escape_custom($_POST['f_symptoms']);
$abnormal_hair_growth = add_escape_custom($_POST['abnormal_hair_growth']);
$f_hirsutism = add_escape_custom($_POST['f_hirsutism']);
$joint_pain = add_escape_custom($_POST['joint_pain']);
$swelling = add_escape_custom($_POST['swelling']);
$m_redness = add_escape_custom($_POST['m_redness']);
$m_warm = add_escape_custom($_POST['m_warm']);
$m_stiffness = add_escape_custom($_POST['m_stiffness']);
$muscle = add_escape_custom($_POST['muscle']);
$m_aches = add_escape_custom($_POST['m_aches']);
$fms = add_escape_custom($_POST['fms']);
$arthritis = add_escape_custom($_POST['arthritis']);
$loc = add_escape_custom($_POST['loc']);
$seizures = add_escape_custom($_POST['seizures']);
$stroke = add_escape_custom($_POST['stroke']);
$tia = add_escape_custom($_POST['tia']);
$n_numbness = add_escape_custom($_POST['n_numbness']);
$n_weakness = add_escape_custom($_POST['n_weakness']);
$paralysis = add_escape_custom($_POST['paralysis']);
$intellectual_decline = add_escape_custom($_POST['intellectual_decline']);
$memory_problems = add_escape_custom($_POST['memory_problems']);
$dementia = add_escape_custom($_POST['dementia']);
$n_headache = add_escape_custom($_POST['n_headache']);
$s_cancer = add_escape_custom($_POST['s_cancer']);
$psoriasis = add_escape_custom($_POST['psoriasis']);
$s_acne = add_escape_custom($_POST['s_acne']);
$s_other = add_escape_custom($_POST['s_other']);
$s_disease = add_escape_custom($_POST['s_disease']);
$p_diagnosis = add_escape_custom($_POST['p_diagnosis']);
$p_medication = add_escape_custom($_POST['p_medication']);
$depression = add_escape_custom($_POST['depression']);
$anxiety = add_escape_custom($_POST['anxiety']);
$social_difficulties = add_escape_custom($_POST['social_difficulties']);
$thyroid_problems = add_escape_custom($_POST['thyroid_problems']);
$diabetes = add_escape_custom($_POST['diabetes']);
$abnormal_blood = add_escape_custom($_POST['abnormal_blood']);
$anemia = add_escape_custom($_POST['anemia']);
$fh_blood_problems = add_escape_custom($_POST['fh_blood_problems']);
$bleeding_problems = add_escape_custom($_POST['bleeding_problems']);
$allergies = add_escape_custom($_POST['allergies']);
$frequent_illness = add_escape_custom($_POST['frequent_illness']);
$hiv =add_escape_custom($_POST['hiv']);
$hai_status = add_escape_custom($_POST['hai_status']);

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);
     
    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patientId;
    
    if ($acl_allow) {
        $strQuery = "INSERT INTO form_ros (pid, activity, date, weight_change, weakness, fatigue, anorexia, fever, chills, night_sweats, insomnia, irritability, heat_or_cold, intolerance, change_in_vision, glaucoma_history, eye_pain, irritation, redness, excessive_tearing, double_vision, blind_spots, photophobia, hearing_loss, discharge, pain, vertigo, tinnitus, frequent_colds, sore_throat, sinus_problems, post_nasal_drip, nosebleed, snoring, apnea, breast_mass, breast_discharge, biopsy, abnormal_mammogram, cough, sputum, shortness_of_breath, wheezing, hemoptsyis, asthma, copd, chest_pain, palpitation, syncope, pnd, doe, orthopnea, peripheal, edema, legpain_cramping, history_murmur, arrythmia, heart_problem, dysphagia, heartburn, bloating, belching, flatulence, nausea, vomiting, hematemesis, gastro_pain, food_intolerance, hepatitis, jaundice, hematochezia, changed_bowel, diarrhea, constipation, polyuria, polydypsia, dysuria, hematuria, frequency, urgency, incontinence, renal_stones, utis, hesitancy, dribbling, stream, nocturia, erections, ejaculations, g, p, ap, lc, mearche, menopause, lmp, f_frequency, f_flow, f_symptoms, abnormal_hair_growth, f_hirsutism, joint_pain, swelling, m_redness, m_warm, m_stiffness, muscle, m_aches, fms, arthritis, loc, seizures, stroke, tia, n_numbness, n_weakness, paralysis, intellectual_decline, memory_problems, dementia, n_headache, s_cancer, psoriasis, s_acne, s_other, s_disease, p_diagnosis, p_medication, depression, anxiety, social_difficulties, thyroid_problems, diabetes, abnormal_blood, anemia, fh_blood_problems, bleeding_problems, allergies, frequent_illness, hiv, hai_status) VALUES ('" . $patientId . "', '" . $activity . "', '" . date('Y-m-d H:i:s') . "', '" . $weight_change . "', '" . $weakness . "', '" . $fatigue . "', '" . $anorexia . "', '" . $fever . "', '" . $chills . "', '" . $night_sweats . "', '" . $insomnia . "', '" . $irritability . "', '" . $heat_or_cold . "', '" . $intolerance . "', '" . $change_in_vision . "', '" . $glaucoma_history . "', '" . $eye_pain . "', '" . $irritation . "', '" . $redness . "', '" . $excessive_tearing . "', '" . $double_vision . "', '" . $blind_spots . "', '" . $photophobia . "', '" . $hearing_loss . "', '" . $discharge . "', '" . $pain . "', '" . $vertigo . "', '" . $tinnitus . "', '" . $frequent_colds . "', '" . $sore_throat . "', '" . $sinus_problems . "', '" . $post_nasal_drip . "', '" . $nosebleed . "', '" . $snoring . "', '" . $apnea . "', '" . $breast_mass . "', '" . $breast_discharge . "', '" . $biopsy . "', '" . $abnormal_mammogram . "', '" . $cough . "', '" . $sputum . "', '" . $shortness_of_breath . "', '" . $wheezing . "', '" . $hemoptsyis . "', '" . $asthma . "', '" . $copd . "', '" . $chest_pain . "', '" . $palpitation . "', '" . $syncope . "', '" . $pnd . "', '" . $doe . "', '" . $orthopnea . "', '" . $peripheal . "', '" . $edema . "', '" . $legpain_cramping . "', '" . $history_murmur . "', '" . $arrythmia . "', '" . $heart_problem . "', '" . $dysphagia . "', '" . $heartburn . "', '" . $bloating . "', '" . $belching . "', '" . $flatulence . "', '" . $nausea . "', '" . $vomiting . "', '" . $hematemesis . "', '" . $gastro_pain . "', '" . $food_intolerance . "', '" . $hepatitis . "', '" . $jaundice . "', '" . $hematochezia . "', '" . $changed_bowel . "', '" . $diarrhea . "', '" . $constipation . "', '" . $polyuria . "', '" . $polydypsia . "', '" . $dysuria . "', '" . $hematuria . "', '" . $frequency . "', '" . $urgency . "', '" . $incontinence . "', '" . $renal_stones . "', '" . $utis . "', '" . $hesitancy . "', '" . $dribbling . "', '" . $stream . "', '" . $nocturia . "', '" . $erections . "', '" . $ejaculations . "', '" . $g . "', '" . $p . "', '" . $ap . "', '" . $lc . "', '" . $mearche . "', '" . $menopause . "', '" . $lmp . "', '" . $f_frequency . "', '" . $f_flow . "', '" . $f_symptoms . "', '" . $abnormal_hair_growth . "', '" . $f_hirsutism . "', '" . $joint_pain . "', '" . $swelling . "', '" . $m_redness . "', '" . $m_warm . "', '" . $m_stiffness . "', '" . $muscle . "', '" . $m_aches . "', '" . $fms . "', '" . $arthritis . "', '" . $loc . "', '" . $seizures . "', '" . $stroke . "', '" . $tia . "', '" . $n_numbness . "', '" . $n_weakness . "', '" . $paralysis . "', '" . $intellectual_decline . "', '" . $memory_problems . "', '" . $dementia . "', '" . $n_headache . "', '" . $s_cancer . "', '" . $psoriasis . "', '" . $s_acne . "', '" . $s_other . "', '" . $s_disease . "', '" . $p_diagnosis . "', '" . $p_medication . "', '" . $depression . "', '" . $anxiety . "', '" . $social_difficulties . "', '" . $thyroid_problems . "', '" . $diabetes . "', '" . $abnormal_blood . "', '" . $anemia . "', '" . $fh_blood_problems . "', '" . $bleeding_problems . "', '" . $allergies . "', '" . $frequent_illness . "', '" . $hiv . "', '" . $hai_status . "')";

        $result = sqlInsert($strQuery);

        $last_inserted_id = $result;

        if ($result) {
            addForm($visit_id, $form_name = 'Review Of Systems', $last_inserted_id, $formdir = 'ros ', $patientId, $authorized = "1", $date = "NOW()", $user, $group = "Default");

            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>Review of Systems added successfully</reason>";
            $xml_string .= "<rosid>" . $last_inserted_id . "</rosid>";
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>Could not add Review of Systems</reason>";
        }
    } else {
        $xml_string .= "<status>-2</status>\n";
        $xml_string .= "<reason>You are not Authorized to perform this action</reason>\n";
    }
} else {
    $xml_string .= "<status>-2</status>";
    $xml_string .= "<reason>Invalid Token</reason>";
}

$xml_string .= "</reviewofsystems>";
echo $xml_string;
?>