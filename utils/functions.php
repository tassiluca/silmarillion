<?php

    define("MAX_LOGIN_ATTEMPTS", 5);

    /**
     * Implements a secure session_start() function.
     * @return void
     */
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
     * Logout the current user. Redirect to the home.
     * @return void
     */
    function logout() {
        $_SESSION = array();    // delete all session values
        session_destroy();      // destroy the session
        // delete actual cookies
        // $params = session_get_cookie_params();
        // setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        header('Location: ./');
    }

    /**
     * Check if an user **BOTH CUSTOMER OR SELLER** is logged in.
     * @return boolean true if a user is logged, false otherwise
     */
    function isUserLoggedIn() {
        return !empty($_SESSION['userId']);
    }

    /**
     * Check if a customer is logged in.
     * @return boolean true if a customer is logged, false otherwise
     */
    function isCustomerLoggedIn() {
        global $dbh;
        return isUserLoggedIn() && $dbh->isCustomer($_SESSION['userId']);
    }

    /**
     * Check if a seller is logged in.
     * @return boolean true if a seller is logged, false otherwise
     */
    function isSellerLoggedIn() {
        global $dbh;
        return isUserLoggedIn() && !$dbh->isCustomer($_SESSION['userId']);
    }
    
    function checkInputs($inputs){
        foreach ($inputs as $i) {
            if (empty($i)) {
                return false;
            }
        }
        return true;
    }

?>