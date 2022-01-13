<?php

/**
 * Dreamfactory  API Client Class
 */
class droroscopeAdmin
{

    /**
     * Base url
     */
    const RESTAPI = 'https://api.droroscope.com';

    /**
     * Home url
     */
    const HOMEURL = 'https://droroscope.com/admin_2019';
    // const HOMEURL = 'http://doctor_admin.com/doctor_admin/';

    /**
     * The Dreamfactory Session id
     * @var Hash
     */
    public $login_session_id;

    function __construct()
    {
        session_start();
    }

    /**
     * loign viabliz
     * @param string  $email   The email id
     * @param string  $password The password
     * @curlurl string  $url       /api/v2/user/session
     */
    public function loginDrapp($username = '', $password = '', $url = '/api/v2/user/session')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, self::RESTAPI . $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        $data = json_encode(array("email" => $username, "password" => $password));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * checkRecords The check the record already exist or not
     * @param string  $session_id   The session id
     * @param string  $url The url of the Record
     */
    public function getRecords($session_id, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-DreamFactory-Api-Key:3b0fc9029fca0e7bd285accf63f88bb5184808fd1b8cc9c5beaa92e475379c48', 'X-DreamFactory-Session-Token:' . $session_id));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            curl_close($curl);
            return $response;
        }
        return false;
    }

    function header_direct($url = '')
    {
        header("Location:" . self::HOMEURL . $url);
        exit();
    }
}
