<?php

include_once 'curl.php';
$loadrecords = new droroscopeAdmin();
$home_url = $loadrecords::HOMEURL;
$is_admin = base64_decode($_SESSION['is_admin']); //dr_admin_yes
if (isset($_SESSION['user_sess']) && $is_admin == "dr_admin_yes" . date('dmY') . "dr") {
    echo "<center><h3>Successfully Logout!</h4></center>";
    session_destroy();
    echo "<center>Login in again <a href='" . $home_url . "'>Login</a></center>";
} else {
    $loadrecords->header_direct();
}
?>
