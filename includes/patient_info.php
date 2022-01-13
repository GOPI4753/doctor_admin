<?php

//patician info
include_once 'curl.php';
$loadrecords = new droroscopeAdmin();
$is_admin = base64_decode($_SESSION['is_admin']); //dr_admin_yes
if (isset($_SESSION['user_sess']) && $is_admin == "dr_admin_yes" . date('dmY') . "dr") {

    $rest_url = $loadrecords::RESTAPI;
    $decode_sess_id = base64_decode($_SESSION['user_sess']);

    $tech_id = $_REQUEST['tech_id'];
    $single_patient_url = $rest_url . '/api/v2/mysqldb/_table/patient_info?filter=techid=' . $tech_id;
    $patient_records = $loadrecords->getRecords($decode_sess_id, $single_patient_url); //Patient Records
    echo $patient_records;
} else {
    $loadrecords->header_direct();
}
exit();
