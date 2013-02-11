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
$rosId = add_escape_custom($_POST['id']);

$patientId = add_escape_custom($_POST['pid']);
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
$ap = add_escape_custom($_POST['ap']);
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
$hiv = add_escape_custom($_POST['hiv']);
$hai_status = add_escape_custom($_POST['hai_status']);

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);
    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patientId;
    if ($acl_allow) {
        $strQuery = 'UPDATE form_ros SET ';
        $strQuery .=' weight_change = "' . $weight_change . '",';
        $strQuery .=' weakness = "' . $weakness . '",';
        $strQuery .=' fatigue = "' . $fatigue . '",';
        $strQuery .=' anorexia = "' . $anorexia . '",';
        $strQuery .=' fever = "' . $fever . '",';
        $strQuery .=' chills = "' . $chills . '",';
        $strQuery .=' night_sweats = "' . $night_sweats . '",';
        $strQuery .=' insomnia = "' . $insomnia . '",';
        $strQuery .=' irritability = "' . $irritability . '",';
        $strQuery .=' heat_or_cold = "' . $heat_or_cold . '",';
        $strQuery .=' intolerance = "' . $intolerance . '",';
        $strQuery .=' change_in_vision = "' . $change_in_vision . '",';
        $strQuery .=' glaucoma_history = "' . $glaucoma_history . '",';
        $strQuery .=' eye_pain = "' . $eye_pain . '",';
        $strQuery .=' irritation = "' . $irritation . '",';
        $strQuery .=' redness = "' . $redness . '",';
        $strQuery .=' excessive_tearing = "' . $excessive_tearing . '",';
        $strQuery .=' double_vision = "' . $double_vision . '",';
        $strQuery .=' blind_spots = "' . $blind_spots . '",';
        $strQuery .=' photophobia = "' . $photophobia . '",';
        $strQuery .=' hearing_loss = "' . $hearing_loss . '",';
        $strQuery .=' discharge = "' . $discharge . '",';
        $strQuery .=' pain = "' . $pain . '",';
        $strQuery .=' vertigo = "' . $vertigo . '",';
        $strQuery .=' tinnitus = "' . $tinnitus . '",';
        $strQuery .=' frequent_colds = "' . $frequent_colds . '",';
        $strQuery .=' sore_throat = "' . $sore_throat . '",';
        $strQuery .=' sinus_problems = "' . $sinus_problems . '",';
        $strQuery .=' post_nasal_drip = "' . $post_nasal_drip . '",';
        $strQuery .=' nosebleed = "' . $nosebleed . '",';
        $strQuery .=' snoring = "' . $snoring . '",';
        $strQuery .=' apnea = "' . $apnea . '",';
        $strQuery .=' breast_mass = "' . $breast_mass . '",';
        $strQuery .=' breast_discharge = "' . $breast_discharge . '",';
        $strQuery .=' biopsy = "' . $biopsy . '",';
        $strQuery .=' abnormal_mammogram = "' . $abnormal_mammogram . '",';
        $strQuery .=' cough = "' . $cough . '",';
        $strQuery .=' sputum = "' . $sputum . '",';
        $strQuery .=' shortness_of_breath = "' . $shortness_of_breath . '",';
        $strQuery .=' wheezing = "' . $wheezing . '",';
        $strQuery .=' hemoptsyis = "' . $hemoptsyis . '",';
        $strQuery .=' asthma = "' . $asthma . '",';
        $strQuery .=' copd = "' . $copd . '",';
        $strQuery .=' chest_pain = "' . $chest_pain . '",';
        $strQuery .=' palpitation = "' . $palpitation . '",';
        $strQuery .=' syncope = "' . $syncope . '",';
        $strQuery .=' pnd = "' . $pnd . '",';
        $strQuery .=' doe = "' . $doe . '",';
        $strQuery .=' orthopnea = "' . $orthopnea . '",';
        $strQuery .=' peripheal = "' . $peripheal . '",';
        $strQuery .=' edema = "' . $edema . '",';
        $strQuery .=' legpain_cramping = "' . $legpain_cramping . '",';
        $strQuery .=' history_murmur = "' . $history_murmur . '",';
        $strQuery .=' arrythmia = "' . $arrythmia . '",';
        $strQuery .=' heart_problem = "' . $heart_problem . '",';
        $strQuery .=' dysphagia = "' . $dysphagia . '",';
        $strQuery .=' heartburn = "' . $heartburn . '",';
        $strQuery .=' bloating = "' . $bloating . '",';
        $strQuery .=' belching = "' . $belching . '",';
        $strQuery .=' flatulence = "' . $flatulence . '",';
        $strQuery .=' nausea = "' . $nausea . '",';
        $strQuery .=' vomiting = "' . $vomiting . '",';
        $strQuery .=' hematemesis = "' . $hematemesis . '",';
        $strQuery .=' gastro_pain = "' . $gastro_pain . '",';
        $strQuery .=' food_intolerance = "' . $food_intolerance . '",';
        $strQuery .=' hepatitis = "' . $hepatitis . '",';
        $strQuery .=' jaundice = "' . $jaundice . '",';
        $strQuery .=' hematochezia = "' . $hematochezia . '",';
        $strQuery .=' changed_bowel = "' . $changed_bowel . '",';
        $strQuery .=' diarrhea = "' . $diarrhea . '",';
        $strQuery .=' constipation = "' . $constipation . '",';
        $strQuery .=' polyuria = "' . $polyuria . '",';
        $strQuery .=' polydypsia = "' . $polydypsia . '",';
        $strQuery .=' dysuria = "' . $dysuria . '",';
        $strQuery .=' hematuria = "' . $hematuria . '",';
        $strQuery .=' frequency = "' . $frequency . '",';
        $strQuery .=' urgency = "' . $urgency . '",';
        $strQuery .=' incontinence = "' . $incontinence . '",';
        $strQuery .=' renal_stones = "' . $renal_stones . '",';
        $strQuery .=' utis = "' . $utis . '",';
        $strQuery .=' hesitancy = "' . $hesitancy . '",';
        $strQuery .=' dribbling = "' . $dribbling . '",';
        $strQuery .=' stream = "' . $stream . '",';
        $strQuery .=' nocturia = "' . $nocturia . '",';
        $strQuery .=' erections = "' . $erections . '",';
        $strQuery .=' ejaculations = "' . $ejaculations . '",';
        $strQuery .=' g = "' . $g . '",';
        $strQuery .=' p = "' . $p . '",';
        $strQuery .=' ap = "' . $ap . '",';
        $strQuery .=' lc = "' . $lc . '",';
        $strQuery .=' mearche = "' . $mearche . '",';
        $strQuery .=' menopause = "' . $menopause . '",';
        $strQuery .=' lmp = "' . $lmp . '",';
        $strQuery .=' f_frequency = "' . $f_frequency . '",';
        $strQuery .=' f_flow = "' . $f_flow . '",';
        $strQuery .=' f_symptoms = "' . $f_symptoms . '",';
        $strQuery .=' abnormal_hair_growth = "' . $abnormal_hair_growth . '",';
        $strQuery .=' f_hirsutism = "' . $f_hirsutism . '",';
        $strQuery .=' joint_pain = "' . $joint_pain . '",';
        $strQuery .=' swelling = "' . $swelling . '",';
        $strQuery .=' m_redness = "' . $m_redness . '",';
        $strQuery .=' m_warm = "' . $m_warm . '",';
        $strQuery .=' m_stiffness = "' . $m_stiffness . '",';
        $strQuery .=' muscle = "' . $muscle . '",';
        $strQuery .=' m_aches = "' . $m_aches . '",';
        $strQuery .=' fms = "' . $fms . '",';
        $strQuery .=' arthritis = "' . $arthritis . '",';
        $strQuery .=' loc = "' . $loc . '",';
        $strQuery .=' seizures = "' . $seizures . '",';
        $strQuery .=' stroke = "' . $stroke . '",';
        $strQuery .=' tia = "' . $tia . '",';
        $strQuery .=' n_numbness = "' . $n_numbness . '",';
        $strQuery .=' n_weakness = "' . $n_weakness . '",';
        $strQuery .=' paralysis = "' . $paralysis . '",';
        $strQuery .=' intellectual_decline = "' . $intellectual_decline . '",';
        $strQuery .=' memory_problems = "' . $memory_problems . '",';
        $strQuery .=' dementia = "' . $dementia . '",';
        $strQuery .=' n_headache = "' . $n_headache . '",';
        $strQuery .=' s_cancer = "' . $s_cancer . '",';
        $strQuery .=' psoriasis = "' . $psoriasis . '",';
        $strQuery .=' s_acne = "' . $s_acne . '",';
        $strQuery .=' s_other = "' . $s_other . '",';
        $strQuery .=' s_disease = "' . $s_disease . '",';
        $strQuery .=' p_diagnosis = "' . $p_diagnosis . '",';
        $strQuery .=' p_medication = "' . $p_medication . '",';
        $strQuery .=' depression = "' . $depression . '",';
        $strQuery .=' anxiety = "' . $anxiety . '",';
        $strQuery .=' social_difficulties = "' . $social_difficulties . '",';
        $strQuery .=' thyroid_problems = "' . $thyroid_problems . '",';
        $strQuery .=' diabetes = "' . $diabetes . '",';
        $strQuery .=' abnormal_blood = "' . $abnormal_blood . '",';
        $strQuery .=' anemia = "' . $anemia . '",';
        $strQuery .=' fh_blood_problems = "' . $fh_blood_problems . '",';
        $strQuery .=' bleeding_problems = "' . $bleeding_problems . '",';
        $strQuery .=' allergies = "' . $allergies . '",';
        $strQuery .=' frequent_illness = "' . $frequent_illness . '",';
        $strQuery .=' hiv = "' . $hiv . '",';
        $strQuery .=' hai_status = "' . $hai_status . '"';
        $strQuery .= ' WHERE id = ?';

        $result = sqlStatement($strQuery, array($rosId));

        if ($result !== FALSE) {

            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Review of Systems has been updated</reason>";
        } else {
            $xml_string .= "<status>-1</status>";
            $xml_string .= "<reason>ERROR: Sorry, there was an error processing your data. Please re-submit the information again.</reason>";
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