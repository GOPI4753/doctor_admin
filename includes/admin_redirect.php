<?php

include_once 'curl.php';
$loadrecords = new droroscopeAdmin();
$home_url = $loadrecords::HOMEURL;
if (isset($_POST['submitbtn'])) {
    $username = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : '';
    $password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';

    if (!(isset($_SESSION['user_sess'])) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
        $session_arr_str = $loadrecords->loginDrapp($username, $password, '/api/v2/system/admin/session'); //session id
        $session_arr = json_decode($session_arr_str, true);
        if (!$session_arr['error']) {
            $encode_sess_id = base64_encode($session_arr['session_id']);
            $encode_session_token = base64_encode($session_arr['session_token']);

            $_SESSION["user_sess"] = $encode_sess_id;
            $_SESSION["user_sess_tok"] = $encode_session_token;
            $_SESSION["is_admin"] =  base64_encode("dr_admin_yes" . date('dmY') . "dr");

          //Redirect to after successfull
            $loadrecords->header_direct('/includes/login.php');
        } else {

            //Redirect to user credetials wrong.
            $loadrecords->header_direct('/');
        }
    } else {
        //if already logged in user
        $loadrecords->header_direct('/includes/login.php');
    }
} else {
    //Redirect to user when accesss directly.
    $loadrecords->header_direct('/');
}
?>
