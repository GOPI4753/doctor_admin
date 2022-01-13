<?php

include_once 'curl.php';
$loadrecords = new droroscopeAdmin();
$is_admin = base64_decode($_SESSION['is_admin']); //dr_admin_yes
if (isset($_SESSION['user_sess']) && $is_admin == "dr_admin_yes" . date('dmY') . "dr") {
    $imageURL = $_GET['url'];
    $date = date("d_m_Y_H_i_s");
    $data = file_get_contents($imageURL);
    header('Content-Type: "image/jpeg"');
    header('Content-Disposition: attachment; filename="' . $date . '.jpg"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
    header("Content-Length: " . strlen($data));
    exit($data);
} else {
    $loadrecords->header_direct();
}
