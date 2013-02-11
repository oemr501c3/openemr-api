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
$xml_string = "<roschecks>";

$token = $_POST['token'];

$id = add_escape_custom($_POST['id']);

$groupname = isset($_POST['groupname']) ? add_escape_custom($_POST['groupname']) : 'Default';
$authorized = isset($_POST['authorized']) ? add_escape_custom($_POST['authorized']) : 1;
$activity = isset($_POST['activity']) ? add_escape_custom($_POST['activity']) : 1;

$fever = add_escape_custom($_POST['fever']);
$chills = add_escape_custom($_POST['chills']);
$night_sweats = add_escape_custom($_POST['night_sweats']);
$weight_loss = add_escape_custom($_POST['weight_loss']);
$poor_appetite = add_escape_custom($_POST['poor_appetite']);
$insomnia = add_escape_custom($_POST['insomnia']);
$fatigued = add_escape_custom($_POST['fatigued']);
$depressed = add_escape_custom($_POST['depressed']);
$hyperactive = add_escape_custom($_POST['hyperactive']);
$exposure_to_foreign_countries = add_escape_custom($_POST['exposure_to_foreign_countries']);
$cataracts = add_escape_custom($_POST['cataracts']);
$cataract_surgery = add_escape_custom($_POST['cataract_surgery']);
$glaucoma = add_escape_custom($_POST['glaucoma']);
$double_vision = add_escape_custom($_POST['double_vision']);
$blurred_vision = add_escape_custom($_POST['blurred_vision']);
$poor_hearing = add_escape_custom($_POST['poor_hearing']);
$headaches = add_escape_custom($_POST['headaches']);
$ringing_in_ears = add_escape_custom($_POST['ringing_in_ears']);
$bloody_nose = add_escape_custom($_POST['bloody_nose']);
$sinusitis = add_escape_custom($_POST['sinusitis']);
$sinus_surgery = add_escape_custom($_POST['sinus_surgery']);
$dry_mouth = add_escape_custom($_POST['dry_mouth']);
$strep_throat = add_escape_custom($_POST['strep_throat']);
$tonsillectomy = add_escape_custom($_POST['tonsillectomy']);
$swollen_lymph_nodes = add_escape_custom($_POST['swollen_lymph_nodes']);
$throat_cancer = add_escape_custom($_POST['throat_cancer']);
$throat_cancer_surgery = add_escape_custom($_POST['throat_cancer_surgery']);
$heart_attack = add_escape_custom($_POST['heart_attack']);
$irregular_heart_beat = add_escape_custom($_POST['irregular_heart_beat']);
$chest_pains = add_escape_custom($_POST['chest_pains']);
$shortness_of_breath = add_escape_custom($_POST['shortness_of_breath']);
$high_blood_pressure = add_escape_custom($_POST['high_blood_pressure']);
$heart_failure = add_escape_custom($_POST['heart_failure']);
$poor_circulation = add_escape_custom($_POST['poor_circulation']);
$vascular_surgery = add_escape_custom($_POST['vascular_surgery']);
$cardiac_catheterization = add_escape_custom($_POST['cardiac_catheterization']);
$coronary_artery_bypass = add_escape_custom($_POST['coronary_artery_bypass']);
$heart_transplant = add_escape_custom($_POST['heart_transplant']);
$stress_test = add_escape_custom($_POST['stress_test']);
$emphysema = add_escape_custom($_POST['emphysema']);
$chronic_bronchitis = add_escape_custom($_POST['chronic_bronchitis']);
$interstitial_lung_disease = add_escape_custom($_POST['interstitial_lung_disease']);
$shortness_of_breath_2 = add_escape_custom($_POST['shortness_of_breath_2']);
$lung_cancer = add_escape_custom($_POST['lung_cancer']);
$lung_cancer_surgery = add_escape_custom($_POST['lung_cancer_surgery']);
$pheumothorax = add_escape_custom($_POST['pheumothorax']);
$stomach_pains = add_escape_custom($_POST['stomach_pains']);
$peptic_ulcer_disease = add_escape_custom($_POST['peptic_ulcer_disease']);
$gastritis = add_escape_custom($_POST['gastritis']);
$endoscopy = add_escape_custom($_POST['endoscopy']);
$polyps = add_escape_custom($_POST['polyps']);
$colonoscopy = add_escape_custom($_POST['colonoscopy']);
$colon_cancer = add_escape_custom($_POST['colon_cancer']);
$colon_cancer_surgery = add_escape_custom($_POST['colon_cancer_surgery']);
$ulcerative_colitis = add_escape_custom($_POST['ulcerative_colitis']);
$crohns_disease = add_escape_custom($_POST['crohns_disease']);
$appendectomy = add_escape_custom($_POST['appendectomy']);
$divirticulitis = add_escape_custom($_POST['divirticulitis']);
$divirticulitis_surgery = add_escape_custom($_POST['divirticulitis_surgery']);
$gall_stones = add_escape_custom($_POST['gall_stones']);
$cholecystectomy = add_escape_custom($_POST['cholecystectomy']);
$hepatitis = add_escape_custom($_POST['hepatitis']);
$cirrhosis_of_the_liver = add_escape_custom($_POST['cirrhosis_of_the_liver']);
$splenectomy = add_escape_custom($_POST['splenectomy']);
$kidney_failure = add_escape_custom($_POST['kidney_failure']);
$kidney_stones = add_escape_custom($_POST['kidney_stones']);
$kidney_cancer = add_escape_custom($_POST['kidney_cancer']);
$kidney_infections = add_escape_custom($_POST['kidney_infections']);
$bladder_infections = add_escape_custom($_POST['bladder_infections']);
$bladder_cancer = add_escape_custom($_POST['bladder_cancer']);
$prostate_problems = add_escape_custom($_POST['prostate_problems']);
$prostate_cancer = add_escape_custom($_POST['prostate_cancer']);
$kidney_transplant = add_escape_custom($_POST['kidney_transplant']);
$sexually_transmitted_disease = add_escape_custom($_POST['sexually_transmitted_disease']);
$burning_with_urination = add_escape_custom($_POST['burning_with_urination']);
$discharge_from_urethra = add_escape_custom($_POST['discharge_from_urethra']);
$rashes = add_escape_custom($_POST['rashes']);
$infections = add_escape_custom($_POST['infections']);
$ulcerations = add_escape_custom($_POST['ulcerations']);
$pemphigus = add_escape_custom($_POST['pemphigus']);
$herpes = add_escape_custom($_POST['herpes']);
$osetoarthritis = add_escape_custom($_POST['osetoarthritis']);
$rheumotoid_arthritis = add_escape_custom($_POST['rheumotoid_arthritis']);
$lupus = add_escape_custom($_POST['lupus']);
$ankylosing_sondlilitis = add_escape_custom($_POST['ankylosing_sondlilitis']);
$swollen_joints = add_escape_custom($_POST['swollen_joints']);
$stiff_joints = add_escape_custom($_POST['stiff_joints']);
$broken_bones = add_escape_custom($_POST['broken_bones']);
$neck_problems = add_escape_custom($_POST['neck_problems']);
$back_problems = add_escape_custom($_POST['back_problems']);
$back_surgery = add_escape_custom($_POST['back_surgery']);
$scoliosis = add_escape_custom($_POST['scoliosis']);
$herniated_disc = add_escape_custom($_POST['herniated_disc']);
$shoulder_problems = add_escape_custom($_POST['shoulder_problems']);
$elbow_problems = add_escape_custom($_POST['elbow_problems']);
$wrist_problems = add_escape_custom($_POST['wrist_problems']);
$hand_problems = add_escape_custom($_POST['hand_problems']);
$hip_problems = add_escape_custom($_POST['hip_problems']);
$knee_problems = add_escape_custom($_POST['knee_problems']);
$ankle_problems = add_escape_custom($_POST['ankle_problems']);
$foot_problems = add_escape_custom($_POST['foot_problems']);
$insulin_dependent_diabetes = add_escape_custom($_POST['insulin_dependent_diabetes']);
$noninsulin_dependent_diabetes = add_escape_custom($_POST['noninsulin_dependent_diabetes']);
$hypothyroidism = add_escape_custom($_POST['hypothyroidism']);
$hyperthyroidism = add_escape_custom($_POST['hyperthyroidism']);
$cushing_syndrom = add_escape_custom($_POST['cushing_syndrom']);
$addison_syndrom = add_escape_custom($_POST['addison_syndrom']);
$additional_notes = add_escape_custom($_POST['additional_notes']);


if ($userId = validateToken($token)) {

    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);
$_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
//    $_SESSION['pid'] = $patientId;
    if ($acl_allow) {
        $strQuery = "UPDATE `form_reviewofs` SET 
                    `user`='{$user}',`groupname`='{$groupname}',
                    `authorized`='{$authorized}',`activity`='{$activity}',`fever`='{$fever}',`chills`='{$chills}',
                    `night_sweats`='{$night_sweats}',`weight_loss`='{$weight_loss}',`poor_appetite`='{$poor_appetite}',`insomnia`='{$insomnia}',
                    `fatigued`='{$fatigued}',`depressed`='{$depressed}',`hyperactive`='{$hyperactive}',
                    `exposure_to_foreign_countries`='{$exposure_to_foreign_countries}',`cataracts`='{$cataracts}',`cataract_surgery`='{$cataract_surgery}',
                    `glaucoma`='{$glaucoma}',`double_vision`='{$double_vision}',`blurred_vision`='{$blurred_vision}',`poor_hearing`='{$poor_hearing}',
                    `headaches`='{$headaches}',`ringing_in_ears`='{$ringing_in_ears}',`bloody_nose`='{$bloody_nose}',`sinusitis`='{$sinusitis}',
                    `sinus_surgery`='{$sinus_surgery}',`dry_mouth`='{$dry_mouth}',`strep_throat`='{$strep_throat}',`tonsillectomy`='{$tonsillectomy}',
                    `swollen_lymph_nodes`='{$swollen_lymph_nodes}',`throat_cancer`='{$throat_cancer}',`throat_cancer_surgery`='{$throat_cancer_surgery}',
                    `heart_attack`='{$heart_attack}',`irregular_heart_beat`='{$irregular_heart_beat}',`chest_pains`='{$chest_pains}',
                    `shortness_of_breath`='{$shortness_of_breath}',`high_blood_pressure`='{$high_blood_pressure}',`heart_failure`='{$heart_failure}',
                    `poor_circulation`='{$poor_circulation}',`vascular_surgery`='{$vascular_surgery}',`cardiac_catheterization`='{$cardiac_catheterization}',
                    `coronary_artery_bypass`='{$coronary_artery_bypass}',`heart_transplant`='{$heart_transplant}',`stress_test`='{$stress_test}',
                    `emphysema`='{$emphysema}',`chronic_bronchitis`='{$chronic_bronchitis}',`interstitial_lung_disease`='{$interstitial_lung_disease}',
                    `shortness_of_breath_2`='{$shortness_of_breath_2}',`lung_cancer`='{$lung_cancer}',`lung_cancer_surgery`='{$lung_cancer_surgery}',
                    `pheumothorax`='{$pheumothorax}',`stomach_pains`='{$stomach_pains}',`peptic_ulcer_disease`='{$peptic_ulcer_disease}',`gastritis`='{$gastritis}',
                    `endoscopy`='{$endoscopy}',`polyps`='{$polyps}',`colonoscopy`='{$colonoscopy}',`colon_cancer`='{$colon_cancer}',
                    `colon_cancer_surgery`='{$colon_cancer_surgery}',`ulcerative_colitis`='{$ulcerative_colitis}',`crohns_disease`='{$crohns_disease}',
                    `appendectomy`='{$appendectomy}',`divirticulitis`='{$divirticulitis}',`divirticulitis_surgery`='{$divirticulitis_surgery}',
                    `gall_stones`='{$gall_stones}',`cholecystectomy`='{$cholecystectomy}',`hepatitis`='{$hepatitis}',`cirrhosis_of_the_liver`='{$cirrhosis_of_the_liver}',
                    `splenectomy`='{$splenectomy}',`kidney_failure`='{$kidney_failure}',`kidney_stones`='{$kidney_stones}',`kidney_cancer`='{$kidney_cancer}',
                    `kidney_infections`='{$kidney_infections}',`bladder_infections`='{$bladder_infections}',`bladder_cancer`='{$bladder_cancer}',
                    `prostate_problems`='{$prostate_problems}',`prostate_cancer`='{$prostate_cancer}',`kidney_transplant`='{$kidney_transplant}',
                    `sexually_transmitted_disease`='{$sexually_transmitted_disease}',`burning_with_urination`='{$burning_with_urination}',`discharge_from_urethra`='{$discharge_from_urethra}',
                    `rashes`='{$rashes}',`infections`='{$infections}',`ulcerations`='{$ulcerations}',`pemphigus`='{$pemphigus}',`herpes`='{$herpes}',
                    `osetoarthritis`='{$osetoarthritis}',`rheumotoid_arthritis`='{$rheumotoid_arthritis}',`lupus`='{$lupus}',`ankylosing_sondlilitis`='{$ankylosing_sondlilitis}'
                    ,`swollen_joints`='{$swollen_joints}',`stiff_joints`='{$stiff_joints}',`broken_bones`='{$broken_bones}',`neck_problems`='{$neck_problems}',
                    `back_problems`='{$back_problems}',`back_surgery`='{$back_surgery}',`scoliosis`='{$scoliosis}',`herniated_disc`='{$herniated_disc}',
                    `shoulder_problems`='{$shoulder_problems}',`elbow_problems`='{$elbow_problems}',`wrist_problems`='{$wrist_problems}',`hand_problems`='{$hand_problems}',
                    `hip_problems`='{$hip_problems}',`knee_problems`='{$knee_problems}',`ankle_problems`='{$ankle_problems}',`foot_problems`='{$foot_problems}',
                    `insulin_dependent_diabetes`='{$insulin_dependent_diabetes}',`noninsulin_dependent_diabetes`='{$noninsulin_dependent_diabetes}',`hypothyroidism`='{$hypothyroidism}',
                    `hyperthyroidism`='{$hyperthyroidism}',`cushing_syndrom`='{$cushing_syndrom}',`addison_syndrom`='{$addison_syndrom}',
                    `additional_notes`='{$additional_notes}' 
                    WHERE id = ?";

        $result = sqlStatement($strQuery,array($id));


        if ($result !== FALSE) {

            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Review of System Checks has been updated</reason>";
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

$xml_string .= "</roschecks>";
echo $xml_string;
?>