<?php

    define("MAX_LOGIN_ATTEMPTS", 5);

    function secureSessionStart(){
        $sessionName = 'secSessionId';
        $secure = true;     // true => https
        $httponly = true;   // Prevent a javascript to access the session id
        ini_set('session.use_only_cookied', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        session_name($sessionName);
        session_start();
        session_regenerate_id();
    }

    /** 
     * Prevents brute force attacks.
     */
    function checkbrute($userId) {
        global $dbh;
        $now = time();
        $validAttempts = $now - (2 * 60 * 60);
        return $dbh->getLoginAttempts($userId, $validAttempts) > MAX_LOGIN_ATTEMPTS;
    }

    function login($userData, $password) {
        if (count($userData)) { // user exists
            $userData = $userData[0];
            if ( checkbrute($userData['id']) ) {
                return false;
            } else {
                $password = hash('sha512', $password . $userData['Salt']);
                if ($userData['Password'] == $password) {
                    $_SESSION['userId'] = $userData['UserId'];
                    return true;
                } else {
                    /* TODO: register new failed attempt */
                }
            }
        }
        return false;
    }

    function customerLogin($username, $password) {
        global $dbh;
        $userData = $dbh->getCustomerData($username);
        return login($userData, $password);
    }

    function sellerLogin($username, $password) {
        global $dbh;
        $userData = $dbh->getSellerData($username);
        return login($userData, $password);
    }

    function isUserLoggedIn(){
        return !empty($_SESSION['userId']);
    }

?>