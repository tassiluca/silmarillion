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

    function logout() {
        $_SESSION = array();    // delete all session values
        session_destroy();      // destroy the session
        // delete actual cookies
        // $params = session_get_cookie_params();
        // setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        header('Location: ./');
    }

    function isUserLoggedIn(){
        return !empty($_SESSION['userId']);
    }

?>