<?php
/**
 * api/addroschecks.php add patient's review of systems checks.
 *
 * Api add's patient review of systems checks against particular visit.
 *
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


$date = 'NOW()';
$pid = $_POST['pid'];
$visit_id = $_POST['visit_id'];
$groupname = isset($_POST['groupname']) ? $_POST['groupname'] : 'Default';
$authorized = isset($_POST['authorized']) ? $_POST['authorized'] : 1;
$activity = isset($_POST['activity']) ? $_POST['activity'] : 1;



$fever = $_POST['fever'];
$chills = $_POST['chills'];
$night_sweats = $_POST['night_sweats'];
$weight_loss = $_POST['weight_loss'];
$poor_appetite = $_POST['poor_appetite'];
$insomnia = $_POST['insomnia'];
$fatigued = $_POST['fatigued'];
$depressed = $_POST['depressed'];
$hyperactive = $_POST['hyperactive'];
$exposure_to_foreign_countries = $_POST['exposure_to_foreign_countries'];
$cataracts = $_POST['cataracts'];
$cataract_surgery = $_POST['cataract_surgery'];
$glaucoma = $_POST['glaucoma'];
$double_vision = $_POST['double_vision'];
$blurred_vision = $_POST['blurred_vision'];
$poor_hearing = $_POST['poor_hearing'];
$headaches = $_POST['headaches'];
$ringing_in_ears = $_POST['ringing_in_ears'];
$bloody_nose = $_POST['bloody_nose'];
$sinusitis = $_POST['sinusitis'];
$sinus_surgery = $_POST['sinus_surgery'];
$dry_mouth = $_POST['dry_mouth'];
$strep_throat = $_POST['strep_throat'];
$tonsillectomy = $_POST['tonsillectomy'];
$swollen_lymph_nodes = $_POST['swollen_lymph_nodes'];
$throat_cancer = $_POST['throat_cancer'];
$throat_cancer_surgery = $_POST['throat_cancer_surgery'];
$heart_attack = $_POST['heart_attack'];
$irregular_heart_beat = $_POST['irregular_heart_beat'];
$chest_pains = $_POST['chest_pains'];
$shortness_of_breath = $_POST['shortness_of_breath'];
$high_blood_pressure = $_POST['high_blood_pressure'];
$heart_failure = $_POST['heart_failure'];
$poor_circulation = $_POST['poor_circulation'];
$vascular_surgery = $_POST['vascular_surgery'];
$cardiac_catheterization = $_POST['cardiac_catheterization'];
$coronary_artery_bypass = $_POST['coronary_artery_bypass'];
$heart_transplant = $_POST['heart_transplant'];
$stress_test = $_POST['stress_test'];
$emphysema = $_POST['emphysema'];
$chronic_bronchitis = $_POST['chronic_bronchitis'];
$interstitial_lung_disease = $_POST['interstitial_lung_disease'];
$shortness_of_breath_2 = $_POST['shortness_of_breath_2'];
$lung_cancer = $_POST['lung_cancer'];
$lung_cancer_surgery = $_POST['lung_cancer_surgery'];
$pheumothorax = $_POST['pheumothorax'];
$stomach_pains = $_POST['stomach_pains'];
$peptic_ulcer_disease = $_POST['peptic_ulcer_disease'];
$gastritis = $_POST['gastritis'];
$endoscopy = $_POST['endoscopy'];
$polyps = $_POST['polyps'];
$colonoscopy = $_POST['colonoscopy'];
$colon_cancer = $_POST['colon_cancer'];
$colon_cancer_surgery = $_POST['colon_cancer_surgery'];
$ulcerative_colitis = $_POST['ulcerative_colitis'];
$crohns_disease = $_POST['crohns_disease'];
$appendectomy = $_POST['appendectomy'];
$divirticulitis = $_POST['divirticulitis'];
$divirticulitis_surgery = $_POST['divirticulitis_surgery'];
$gall_stones = $_POST['gall_stones'];
$cholecystectomy = $_POST['cholecystectomy'];
$hepatitis = $_POST['hepatitis'];
$cirrhosis_of_the_liver = $_POST['cirrhosis_of_the_liver'];
$splenectomy = $_POST['splenectomy'];
$kidney_failure = $_POST['kidney_failure'];
$kidney_stones = $_POST['kidney_stones'];
$kidney_cancer = $_POST['kidney_cancer'];
$kidney_infections = $_POST['kidney_infections'];
$bladder_infections = $_POST['bladder_infections'];
$bladder_cancer = $_POST['bladder_cancer'];
$prostate_problems = $_POST['prostate_problems'];
$prostate_cancer = $_POST['prostate_cancer'];
$kidney_transplant = $_POST['kidney_transplant'];
$sexually_transmitted_disease = $_POST['sexually_transmitted_disease'];
$burning_with_urination = $_POST['burning_with_urination'];
$discharge_from_urethra = $_POST['discharge_from_urethra'];
$rashes = $_POST['rashes'];
$infections = $_POST['infections'];
$ulcerations = $_POST['ulcerations'];
$pemphigus = $_POST['pemphigus'];
$herpes = $_POST['herpes'];
$osetoarthritis = $_POST['osetoarthritis'];
$rheumotoid_arthritis = $_POST['rheumotoid_arthritis'];
$lupus = $_POST['lupus'];
$ankylosing_sondlilitis = $_POST['ankylosing_sondlilitis'];
$swollen_joints = $_POST['swollen_joints'];
$stiff_joints = $_POST['stiff_joints'];
$broken_bones = $_POST['broken_bones'];
$neck_problems = $_POST['neck_problems'];
$back_problems = $_POST['back_problems'];
$back_surgery = $_POST['back_surgery'];
$scoliosis = $_POST['scoliosis'];
$herniated_disc = $_POST['herniated_disc'];
$shoulder_problems = $_POST['shoulder_problems'];
$elbow_problems = $_POST['elbow_problems'];
$wrist_problems = $_POST['wrist_problems'];
$hand_problems = $_POST['hand_problems'];
$hip_problems = $_POST['hip_problems'];
$knee_problems = $_POST['knee_problems'];
$ankle_problems = $_POST['ankle_problems'];
$foot_problems = $_POST['foot_problems'];
$insulin_dependent_diabetes = $_POST['insulin_dependent_diabetes'];
$noninsulin_dependent_diabetes = $_POST['noninsulin_dependent_diabetes'];
$hypothyroidism = $_POST['hypothyroidism'];
$hyperthyroidism = $_POST['hyperthyroidism'];
$cushing_syndrom = $_POST['cushing_syndrom'];
$addison_syndrom = $_POST['addison_syndrom'];
$additional_notes = $_POST['additional_notes'];

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    $acl_allow = acl_check('encounters', 'auth_a', $user);

    $_SESSION['authUser'] = $user;
    $_SESSION['authGroup'] = $site;
    $_SESSION['pid'] = $patientId;

    if ($acl_allow) {
        $strQuery = "INSERT INTO `form_reviewofs`(
                    `date`, `pid`, `user`, `groupname`, `authorized`, `activity`, `fever`, `chills`, 
                    `night_sweats`, `weight_loss`, `poor_appetite`, `insomnia`, `fatigued`, `depressed`, 
                    `hyperactive`, `exposure_to_foreign_countries`, `cataracts`, `cataract_surgery`, `glaucoma`, 
                    `double_vision`, `blurred_vision`, `poor_hearing`, `headaches`, `ringing_in_ears`, `bloody_nose`, 
                    `sinusitis`, `sinus_surgery`, `dry_mouth`, `strep_throat`, `tonsillectomy`, `swollen_lymph_nodes`, 
                    `throat_cancer`, `throat_cancer_surgery`, `heart_attack`, `irregular_heart_beat`, `chest_pains`, 
                    `shortness_of_breath`, `high_blood_pressure`, `heart_failure`, `poor_circulation`, `vascular_surgery`, 
                    `cardiac_catheterization`, `coronary_artery_bypass`, `heart_transplant`, `stress_test`, `emphysema`, 
                    `chronic_bronchitis`, `interstitial_lung_disease`, `shortness_of_breath_2`, `lung_cancer`, 
                    `lung_cancer_surgery`, `pheumothorax`, `stomach_pains`, `peptic_ulcer_disease`, `gastritis`, `endoscopy`, 
                    `polyps`, `colonoscopy`, `colon_cancer`, `colon_cancer_surgery`, `ulcerative_colitis`, `crohns_disease`, 
                    `appendectomy`, `divirticulitis`, `divirticulitis_surgery`, `gall_stones`, `cholecystectomy`, 
                    `hepatitis`, `cirrhosis_of_the_liver`, `splenectomy`, `kidney_failure`, `kidney_stones`, 
                    `kidney_cancer`, `kidney_infections`, `bladder_infections`, `bladder_cancer`, `prostate_problems`, 
                    `prostate_cancer`, `kidney_transplant`, `sexually_transmitted_disease`, `burning_with_urination`, 
                    `discharge_from_urethra`, `rashes`, `infections`, `ulcerations`, `pemphigus`, `herpes`, `osetoarthritis`, 
                    `rheumotoid_arthritis`, `lupus`, `ankylosing_sondlilitis`, `swollen_joints`, `stiff_joints`, `broken_bones`, 
                    `neck_problems`, `back_problems`, `back_surgery`, `scoliosis`, `herniated_disc`, `shoulder_problems`, 
                    `elbow_problems`, `wrist_problems`, `hand_problems`, `hip_problems`, `knee_problems`, `ankle_problems`, 
                    `foot_problems`, `insulin_dependent_diabetes`, `noninsulin_dependent_diabetes`, `hypothyroidism`, `hyperthyroidism`, 
                    `cushing_syndrom`, `addison_syndrom`, `additional_notes`
                    ) VALUES (
                    $date, '" . add_escape_custom($pid) . "', '" . add_escape_custom($user) . "', '" . add_escape_custom($groupname) . "', '" . add_escape_custom($authorized) . "', '" . add_escape_custom($activity) . "', '" . add_escape_custom($fever) . "', '" . add_escape_custom($chills) . "', 
                    '" . add_escape_custom($night_sweats) . "', '" . add_escape_custom($weight_loss) . "', '" . add_escape_custom($poor_appetite) . "', '" . add_escape_custom($insomnia) . "', '" . add_escape_custom($fatigued) . "', '" . add_escape_custom($depressed) . "', 
                    '" . add_escape_custom($hyperactive) . "', '" . add_escape_custom($exposure_to_foreign_countries) . "', '" . add_escape_custom($cataracts) . "', '" . add_escape_custom($cataract_surgery) . "', '" . add_escape_custom($glaucoma) . "', 
                    '" . add_escape_custom($double_vision) . "', '" . add_escape_custom($blurred_vision) . "', '" . add_escape_custom($poor_hearing) . "', '" . add_escape_custom($headaches) . "', '" . add_escape_custom($ringing_in_ears) . "', '" . add_escape_custom($bloody_nose) . "', 
                    '" . add_escape_custom($sinusitis) . "', '" . add_escape_custom($sinus_surgery) . "', '" . add_escape_custom($dry_mouth) . "', '" . add_escape_custom($strep_throat) . "', '" . add_escape_custom($tonsillectomy) . "', '" . add_escape_custom($swollen_lymph_nodes) . "', 
                    '" . add_escape_custom($throat_cancer) . "', '" . add_escape_custom($throat_cancer_surgery) . "', '" . add_escape_custom($heart_attack) . "', '" . add_escape_custom($irregular_heart_beat) . "', '" . add_escape_custom($chest_pains) . "', 
                    '" . add_escape_custom($shortness_of_breath) . "', '" . add_escape_custom($high_blood_pressure) . "', '" . add_escape_custom($heart_failure) . "', '" . add_escape_custom($poor_circulation) . "', '" . add_escape_custom($vascular_surgery) . "', 
                    '" . add_escape_custom($cardiac_catheterization) . "', '" . add_escape_custom($coronary_artery_bypass) . "', '" . add_escape_custom($heart_transplant) . "', '" . add_escape_custom($stress_test) . "', '" . add_escape_custom($emphysema) . "', 
                    '" . add_escape_custom($chronic_bronchitis) . "', '" . add_escape_custom($interstitial_lung_disease) . "', '" . add_escape_custom($shortness_of_breath_2) . "', '" . add_escape_custom($lung_cancer) . "', 
                    '" . add_escape_custom($lung_cancer_surgery) . "', '" . add_escape_custom($pheumothorax) . "', '" . add_escape_custom($stomach_pains) . "', '" . add_escape_custom($peptic_ulcer_disease) . "', '" . add_escape_custom($gastritis) . "', '" . add_escape_custom($endoscopy) . "', 
                    '" . add_escape_custom($polyps) . "', '" . add_escape_custom($colonoscopy) . "', '" . add_escape_custom($colon_cancer) . "', '" . add_escape_custom($colon_cancer_surgery) . "', '" . add_escape_custom($ulcerative_colitis) . "', '" . add_escape_custom($crohns_disease) . "', 
                    '" . add_escape_custom($appendectomy) . "', '" . add_escape_custom($divirticulitis) . "', '" . add_escape_custom($divirticulitis_surgery) . "', '" . add_escape_custom($gall_stones) . "', '" . add_escape_custom($cholecystectomy) . "', 
                    '" . add_escape_custom($hepatitis) . "', '" . add_escape_custom($cirrhosis_of_the_liver) . "', '" . add_escape_custom($splenectomy) . "', '" . add_escape_custom($kidney_failure) . "', '" . add_escape_custom($kidney_stones) . "', 
                    '" . add_escape_custom($kidney_cancer) . "', '" . add_escape_custom($kidney_infections) . "', '" . add_escape_custom($bladder_infections) . "', '" . add_escape_custom($bladder_cancer) . "', '" . add_escape_custom($prostate_problems) . "', 
                    '" . add_escape_custom($prostate_cancer) . "', '" . add_escape_custom($kidney_transplant) . "', '" . add_escape_custom($sexually_transmitted_disease) . "', '" . add_escape_custom($burning_with_urination) . "', 
                    '" . add_escape_custom($discharge_from_urethra) . "', '" . add_escape_custom($rashes) . "', '" . add_escape_custom($infections) . "', '" . add_escape_custom($ulcerations) . "', '" . add_escape_custom($pemphigus) . "', '" . add_escape_custom($herpes) . "', '" . add_escape_custom($osetoarthritis) . "', 
                    '" . add_escape_custom($rheumotoid_arthritis) . "', '" . add_escape_custom($lupus) . "', '" . add_escape_custom($ankylosing_sondlilitis) . "', '" . add_escape_custom($swollen_joints) . "', '" . add_escape_custom($stiff_joints) . "', '" . add_escape_custom($broken_bones) . "', 
                    '" . add_escape_custom($neck_problems) . "', '" . add_escape_custom($back_problems) . "', '" . add_escape_custom($back_surgery) . "', '" . add_escape_custom($scoliosis) . "', '" . add_escape_custom($herniated_disc) . "', '" . add_escape_custom($shoulder_problems) . "', 
                    '" . add_escape_custom($elbow_problems) . "', '" . add_escape_custom($wrist_problems) . "', '" . add_escape_custom($hand_problems) . "', '" . add_escape_custom($hip_problems) . "', '" . add_escape_custom($knee_problems) . "', '" . add_escape_custom($ankle_problems) . "', 
                    '" . add_escape_custom($foot_problems) . "', '" . add_escape_custom($insulin_dependent_diabetes) . "', '" . add_escape_custom($noninsulin_dependent_diabetes) . "', '" . add_escape_custom($hypothyroidism) . "', '" . add_escape_custom($hyperthyroidism) . "', 
                    '" . add_escape_custom($cushing_syndrom) . "', '" . add_escape_custom($addison_syndrom) . "', '" . add_escape_custom($additional_notes) . "')
";
        $result = sqlInsert($strQuery);
        $last_inserted_id = $result;

        if ($result) {
            addForm($visit_id, $form_name = 'Review of Systems Checks', $last_inserted_id, $formdir = 'reviewofs', $pid, $authorized = "1", $date = "NOW()", $user, $group = "Default");

            $xml_string .= "<status>0</status>";
            $xml_string .= "<reason>The Review of System Checks has been added</reason>";
            $xml_string .= "<roscheckid>{$last_inserted_id}</roscheckid>";
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