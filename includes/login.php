<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'curl.php';
$loadrecords = new droroscopeAdmin();
$is_admin = base64_decode($_SESSION['is_admin']); //dr_admin_yes
$rest_url = $loadrecords::RESTAPI;
if (true || isset($_SESSION['user_sess']) && $is_admin == "dr_admin_yes" . date('dmY') . "dr") {
    $decode_sess_id = base64_decode($_SESSION['user_sess']);
    $user_sess_tok = base64_decode($_SESSION['user_sess_tok']);
    $api_key = '3b0fc9029fca0e7bd285accf63f88bb5184808fd1b8cc9c5beaa92e475379c48'; //'b5cb82af7b5d4130f36149f90aa2746782e59a872ac70454ac188743cb55b0ba';
    $patient_id = isset($_REQUEST['patient_id']) ? $_REQUEST['patient_id'] : '';
    $tech_id = isset($_REQUEST['tech_id']) ? $_REQUEST['tech_id'] : '';
    $rest_file = $rest_url . '/api/v2/files';
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Dr App Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    </head>

    <body>
        <div class="login-main" data-api-key="<?php echo $api_key; ?>" data-sess-kot="<?php echo $user_sess_tok; ?>">
            <div class="container">
                <a href="logout.php">Logout</a>
                <?php
                //technicians info
                $single_tech_url = $rest_url . '/api/v2/system/user';

                $tech_all_records = $loadrecords->getRecords($decode_sess_id, $single_tech_url); //technicians all Records
                $tech_records_data = json_decode($tech_all_records, true);

                if (is_array($tech_records_data)) {
                    $tech_records_arr = $tech_records_data['resource'];
                ?>
                    <div class="tech_records_wrap">
                        <h4 class="tech_records"><label for="tech_records">Technician : </label></h4>
                        <select id="tech_records" class="tech_records" name="tech_records" onchange>
                            <option value="-1">---Select Technician---</option>
                            <?php
                            foreach ($tech_records_arr as $tech) {
                                $select_tech = ($tech_id == $tech["id"]) ? 'selected' : '';
                                echo '<option value="' . $tech["id"] . '" ' . $select_tech . '>' . $tech["name"] . '  :  ' . $tech["email"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php } ?>

                <!-- patient records stating-->
                <h4 class="patient_record_label"><label for="patient_records">Patient:</label></h4>
                <select id="patient_records" class="patient_records" name="patient_records">
                    <option value="-1">---Select patient---</option>
                    <?php
                    $single_pat_url = $rest_url . '/api/v2/mysqldb/_table/patient_info?filter=techid=' . $tech_id;
                    $patient_records = $loadrecords->getRecords($session_id, $single_pat_url); //Patient Records
                    $patient_records_data = json_decode($patient_records, true);
                    $patient_records_resource = $patient_records_data['resource'];
                    foreach ($patient_records_resource as $value) {
                        $select_patient = ($patient_id == $value["id"]) ? 'selected' : '';
                        echo '<option data-url = "' . $loadrecords::HOMEURL . '/includes/login.php?patient_id=' . $value["id"] . '&tech_id=' . $tech_id . '" value="' . $value["id"] . '" ' . $select_patient . '>' . $value["name"] . '</option>';
                    }
                    ?>
                </select>
                <h3>Patient Information</h3>

                <?php
                $single_patient_url = $rest_url . '/api/v2/mysqldb/_table/patient_info/' . $patient_id . '?fields=*&related=patient_record_by_id%2Cimageurls_by_patient_id';
                $patient_info_json = $loadrecords->getRecords($decode_sess_id, $single_patient_url); //Patient Records
                $patient_info_arr = json_decode($patient_info_json);
                // print_r($patient_info_arr);
                // exit;
                $patient_records_by_id = (isset($patient_info_arr->patient_record_by_id)) ? $patient_info_arr->patient_record_by_id : '';
                $patient_images = (isset($patient_info_arr->imageurls_by_patient_id)) ? $patient_info_arr->imageurls_by_patient_id : '';

                if (isset($patient_info_arr->id) && $patient_info_arr->techid == $tech_id) {
                ?>

                    <div class="patient-information-main-wrap">
                        <div class="card card-body bg-light">
                            <form method="POST">
                                <div class="card card-body bg-light">
                                    <h4>Patient Metadata</h4>
                                    <div class="patient-information-wrap">
                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div>
                                                    <b>Technician Id :</b>
                                                    <span class="dr_tech_id" data-tech_id="<?php print $tech_id; ?>"><?php print ($patient_info_arr->techid) ? $patient_info_arr->techid : ''; ?></span>
                                                </div>

                                                <div>
                                                    <b>Name :</b>
                                                    <input type="text" class="dr_name" value="<?php print ($patient_info_arr->name) ? $patient_info_arr->name : ''; ?>">
                                                </div>


                                                <div>
                                                    <b>Email Id :</b>
                                                    <input type="text" class="dr_email" value="<?php print ($patient_info_arr->email) ? $patient_info_arr->email : ''; ?>">
                                                </div>


                                                <div>
                                                    <b>Phone :</b>
                                                    <input type="text" class="dr_phone" value="<?php print ($patient_info_arr->phone) ? $patient_info_arr->phone : ''; ?>">
                                                </div>

                                            </div>
                                            <div class="col-sm-6">


                                                <div>
                                                    <b>Patient Id :</b>
                                                    <span class="dr_id" data-id="<?php print $patient_info_arr->id; ?>"><?php print ($patient_info_arr->id) ? $patient_info_arr->id : ''; ?></span>
                                                </div>


                                                <div>
                                                    <b>Is Any Previous History :</b>
                                                    <input type="radio" name="dr_isAnyPreviousHistory" class="dr_isAnyPreviousHistory" value="1" <?php print ($patient_info_arr->isAnyPreviousHistory == 1) ? 'checked' : ''; ?>>Yes
                                                    <input type="radio" name="dr_isAnyPreviousHistory" class="dr_isAnyPreviousHistory" value="0" <?php print ($patient_info_arr->isAnyPreviousHistory == 0) ? 'checked' : ''; ?>>No
                                                </div>


                                                <div>
                                                    <b>Address :</b>
                                                    <input type="text" class="dr_address" value="<?php print ($patient_info_arr->address) ? $patient_info_arr->address : ''; ?>">
                                                </div>

                                                <div>
                                                    <b>Habit of smoking :</b>
                                                    <input type="checkbox" name="dr_isHabitOfSmoking" class="dr_isHabitOfSmoking" <?php print ($patient_info_arr->isHabitOfSmoking == 1) ? 'checked' : ''; ?>>

                                                    <input type="text" name="dr_durationSmoking" class="dr_durationSmoking" value="<?php print ($patient_info_arr->durationSmoking != '') ? explode(' ', $patient_info_arr->durationSmoking)[0] : ''; ?>">

                                                    <select class="dr_durationSmoking_span">
                                                        <option value="Days" <?php print ($patient_info_arr->durationSmoking != '' && explode(' ', $patient_info_arr->durationSmoking)[1] == 'Days') ? 'selected' : ''; ?>>Days</option>
                                                        <option value="Months" <?php print ($patient_info_arr->durationSmoking != '' && explode(' ', $patient_info_arr->durationSmoking)[1] == 'Months') ? 'selected' : ''; ?>>Months</option>
                                                        <option value="Years" <?php print ($patient_info_arr->durationSmoking != '' && explode(' ', $patient_info_arr->durationSmoking)[1] == 'Years') ? 'selected' : ''; ?>>Years</option>
                                                    </select>
                                                </div>


                                                <div>
                                                    <b>Habit of Tobacco Chewing :</b>
                                                    <input type="checkbox" name="dr_isHabitOfTobacco" class="dr_isHabitOfTobacco" <?php print ($patient_info_arr->isHabitOfTobacco == 1) ? 'checked' : ''; ?>>

                                                    <input type="text" name="dr_durationTobacco" class="dr_durationTobacco" value="<?php print ($patient_info_arr->durationTobacco != '') ? explode(' ', $patient_info_arr->durationTobacco)[0] : ''; ?>">

                                                    <select class="dr_durationTobacco_span">
                                                        <option value="Days" <?php print ($patient_info_arr->durationTobacco != '' && explode(' ', $patient_info_arr->durationTobacco)[1] == 'Days') ? 'selected' : ''; ?>>Days</option>
                                                        <option value="Months" <?php print ($patient_info_arr->durationTobacco != '' && explode(' ', $patient_info_arr->durationTobacco)[1] == 'Months') ? 'selected' : ''; ?>>Months</option>
                                                        <option value="Years" <?php print ($patient_info_arr->durationTobacco != '' && explode(' ', $patient_info_arr->durationTobacco)[1] == 'Years') ? 'selected' : ''; ?>>Years</option>
                                                    </select>
                                                </div>


                                                <div>
                                                    <b>Habit of Alchohol :</b>
                                                    <input type="checkbox" name="dr_isHabitOfAlcohol" class="dr_isHabitOfAlcohol" <?php print ($patient_info_arr->isHabitOfAlcohol == 1) ? 'checked' : ''; ?>>
                                                    <input type="text" name="dr_durationAlcohol" class="dr_durationAlcohol" value="<?php print ($patient_info_arr->durationAlcohol != '') ? explode(' ', $patient_info_arr->durationAlcohol)[0] : ''; ?>">
                                                    <select class="dr_durationAlcohol_span">
                                                        <option value="Days" <?php print ($patient_info_arr->durationAlcohol != '' && explode(' ', $patient_info_arr->durationAlcohol)[1] == 'Days') ? 'selected' : ''; ?>>Days</option>
                                                        <option value="Months" <?php print ($patient_info_arr->durationAlcohol != '' && explode(' ', $patient_info_arr->durationAlcohol)[1] == 'Months') ? 'selected' : ''; ?>>Months</option>
                                                        <option value="Years" <?php print ($patient_info_arr->durationAlcohol != '' && explode(' ', $patient_info_arr->durationAlcohol)[1] == 'Years') ? 'selected' : ''; ?>>Years</option>
                                                    </select>
                                                </div>


                                                <div>
                                                    <b>Description :</b>
                                                    <textarea class="dr_description" rows="3" cols="30"><?php print ($patient_info_arr->description) ? $patient_info_arr->description : ''; ?>
                                                        </textarea>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body bg-light">
                                    <h4>Patients Symptoms</h4>
                                    <div class="patient-symptoms-wrap">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div><input type="checkbox" class="dr_pain" <?php print (isset($patient_records_by_id->pain) && ($patient_records_by_id->pain)) ? 'checked' : ''; ?>> <b>Pain</b></div>
                                                <div><input type="checkbox" class="dr_redness" <?php print (isset($patient_records_by_id->redness) && $patient_records_by_id->redness) ? 'checked' : ''; ?>> <b>Redness</b></div>
                                                <div><input type="checkbox" class="dr_white_patch" <?php print (isset($patient_records_by_id->whitepatch) && $patient_records_by_id->whitepatch) ? 'checked' : ''; ?>> <b>White Patch</b></div>
                                                <div><input type="checkbox" class="dr_red_and_white_patch" <?php print (isset($patient_records_by_id->redandwhitepatch) && $patient_records_by_id->redandwhitepatch) ? 'checked' : ''; ?>> <b>Red and white patch</b></div>
                                                <div><input type="checkbox" class="dr_growth" <?php print (isset($patient_records_by_id->growth) && $patient_records_by_id->growth) ? 'checked' : ''; ?>> <b>Growth</b></div>
                                                <div><input type="checkbox" class="dr_swelling" <?php print (isset($patient_records_by_id->swelling) && $patient_records_by_id->swelling) ? 'checked' : ''; ?>> <b>Swelling</b></div>
                                                <div><input type="checkbox" class="dr_ulcers" <?php print (isset($patient_records_by_id->ulcers) && $patient_records_by_id->ulcers) ? 'checked' : ''; ?>> <b>Ulcers</b></div>
                                                <div><input type="checkbox" class="dr_unable_to_open_the_mouth" <?php print (isset($patient_records_by_id->unable_to_open_the_mouth) && $patient_records_by_id->unable_to_open_the_mouth) ? 'checked' : ''; ?>> <b>Unable to open the mouth</b></div>
                                                <div><input type="checkbox" class="dr_pigmentation_dark_area" <?php print (isset($patient_records_by_id->pigmentation) && $patient_records_by_id->pigmentation) ? 'checked' : ''; ?>> <b>Pigmentation/Dark area</b></div>
                                                <div><input type="checkbox" class="dr_blanching_diascopy" <?php print (isset($patient_records_by_id->blanching) && $patient_records_by_id->blanching) ? 'checked' : ''; ?>> <b>Blanching/Diascopy</b></div>
                                                <div><input type="checkbox" class="dr_burning" <?php print (isset($patient_records_by_id->burning) && $patient_records_by_id->burning) ? 'checked' : ''; ?>> <b>Burning</b></div>
                                                <div><input type="checkbox" class="dr_anterior_front_region" <?php print (isset($patient_records_by_id->anterior) && $patient_records_by_id->anterior) ? 'checked' : ''; ?>> <b>anterior/front region</b></div>
                                                <div><input type="checkbox" class="dr_posterior_back_region" <?php print (isset($patient_records_by_id->posterior) && $patient_records_by_id->posterior) ? 'checked' : ''; ?>> <b>Posterior/back region</b></div>
                                            </div>


                                            <div class="col-sm-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Site</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_site_right" <?php print (isset($patient_records_by_id->site) && ($patient_records_by_id->site == 1 || $patient_records_by_id->site == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_site_left" <?php print (isset($patient_records_by_id->site) && ($patient_records_by_id->site == 2 || $patient_records_by_id->site == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tongue</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_tongue_right" <?php print (isset($patient_records_by_id->tongue) && ($patient_records_by_id->tongue == 1 || $patient_records_by_id->tongue == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_tongue_left" <?php print (isset($patient_records_by_id->tongue) && ($patient_records_by_id->tongue == 2 || $patient_records_by_id->tongue == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Cheek</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_cheek_right" <?php print (isset($patient_records_by_id->cheek) && ($patient_records_by_id->cheek == 1 || $patient_records_by_id->cheek == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_cheek_left" <?php print (isset($patient_records_by_id->cheek) && ($patient_records_by_id->cheek == 2 || $patient_records_by_id->cheek == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Palate</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_palate_right" <?php print (isset($patient_records_by_id->palate) && ($patient_records_by_id->palate == 1 || $patient_records_by_id->palate == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_palate_left" <?php print (isset($patient_records_by_id->palate) && ($patient_records_by_id->palate == 2 || $patient_records_by_id->palate == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Gums/Gingiva</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_gums_right" <?php print (isset($patient_records_by_id->gums) && ($patient_records_by_id->gums == 1 || $patient_records_by_id->gums == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_gums_left" <?php print (isset($patient_records_by_id->gums) && ($patient_records_by_id->gums == 2 || $patient_records_by_id->gums == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Lips</b></td>
                                                        <td>
                                                            <input type="checkbox" class="dr_lips_right" <?php print (isset($patient_records_by_id->lips) && ($patient_records_by_id->lips == 1 || $patient_records_by_id->lips == 3)) ? 'checked' : ''; ?>>Right
                                                            <input type="checkbox" class="dr_lips_left" <?php print (isset($patient_records_by_id->lips) && ($patient_records_by_id->lips == 2 || $patient_records_by_id->lips == 3)) ? 'checked' : ''; ?>> Left
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-body bg-light">
                                    <h4>Patient Attachments</h4>
                                    <div class="patient-attachments-wrap">
                                        <?php
                                        if (is_array($patient_images)) {
                                            foreach ($patient_images as $img) {
                                                $url = substr($img->url, 1, strlen($img->url));
                                                $name = substr($img->url, 2, strlen($img->url));
                                                $img_link = $rest_url . '/api/v2/files/' . $url . '?api_key=' . $api_key . '&session_token=' . $user_sess_tok;
                                                echo '<div class="dr_old_image"><a href="' . $loadrecords::HOMEURL . '/includes/image_download.php?url=' . $img_link . '"><img src = "' . $img_link . '" class = "img-thumbnail" width = "300" height = "300"></a><span class="">' . $name . '</span></div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php

                                // $url = $rest_url . '/api/v2/mysqldb/_table/patient_info/' . $patient_id . '?fields=*&related=patient_record_by_id%2Cimageurls_by_patient_id';
                                // $query_str = parse_url($url, PHP_URL_QUERY);
                                // parse_str($query_str, $query_params);
                                // print_r($query_params); 

                                ?>

                                <?php
                                // echo $patient_info_arr->teethData;
                                // exit;
                                // JSON.stringify($patient_info_arr->teethData,null,'\t')                                    
                                ?>
                                <div class="card card-body bg-light">
                                    <h4>Cancer Form</h4>
                                    <iframe id="imdb" src='login_params.php?teethdata=<?php print_r(json_encode($patient_info_arr->teethData)) ?>&mouthData=<?php print_r(json_encode($patient_info_arr->mouthdata)) ?>' style="height:600px;"></iframe>
                                </div>

                                <input type="file" name="dr_uploadfile" id="dr_uploadfile" accept="image/x-png,image/jpeg" multiple />
                        </div>
                        <div class="dr-upload-image-wrap"></div>
                        <div class="dr-webcan-image-wrap"></div>
                        <img src="../assets/images/camera.png" alt="cameraicon" class="dr-takephoto">
                        <input id="capturebtn" class="dr-snap btn btn-success" style="display:none;" value="Take a Photo">
                        <div class="sumit_form_wrap"><a href="javascript:void(0)" class="sumit_form">Submit</a></div>

                        </form>
                    </div>
            </div>
        <?php } else { ?>
            <div>Select patient</div>
        <?php } ?>
        </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
        <script src="../assets/js/global.js" type="text/javascript"></script>
    </body>

    </html>
<?php
} else {
    $loadrecords->header_direct();
}
