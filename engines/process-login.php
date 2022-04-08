<?php
    require_once '../bootstrap.php';
    /** @var DatabaseHelper $dbh */

    const FORCING_MSG = "Negli ultimi 5 minuti hai effettuato 5 tentativi a vuoto. Aspetta!";
    const ERROR_MSG = "Login fallito: ricontrolla i campi!";

    /**
     * Prevents brute force attacks.
     * @param int $userId the user id
     * @return boolean true if in the last period there have been several failed login attempts
     */
    function checkbrute($userId) {
        global $dbh;
        $now = time();
        $validAttempts = $now - (5 * 60);   /* 5 mins */
        return $dbh->getLoginAttempts($userId, $validAttempts) >= MAX_LOGIN_ATTEMPTS;
    }

    /**
     * Register a new logged user into the session variable.
     * @param Array $userData an associative array with all user data
     * @return void
     */
    function registerLoggedUser($userData) {
        $_SESSION['userId'] = $userData['UserId'];
        $_SESSION['username'] = $userData['UserId'];
    }

    /**
     * Make a new login attempt.
     * @param Array $userData an associative array with all user data
     * @param string $password the hashed password to compare
     * @return Array of errors
     */
    function login($userData, $password) {
        global $dbh;
        $result = [];
        if (count($userData)) { // user exists
            $userData = $userData[0];
            if (checkbrute($userData['UserId'])) {
                $result["error"] = FORCING_MSG;
            } else {
                $password = hash('sha512', $password . $userData['Salt']);
                if ($userData['Password'] == $password) {
                    registerLoggedUser($userData);
                } else {
                    $dbh->registerNewLoginAttempt($userData['UserId'], time());
                    $result["error"] = ERROR_MSG;
                }
            }
        } else {
            $result["error"] = ERROR_MSG;
        }
        return $result;
    }

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        /* TODO: input validation */
        $userData = $dbh->getCustomerData($_POST['customerUsr']);
        echo json_encode(login($userData, $_POST['customerPwd']));
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        /* TODO: input validation */
        $userData = $dbh->getSellerData($_POST['sellerUsr']);
        echo json_encode(login($userData, $_POST['sellerPwd']));
    }

?>