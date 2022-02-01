<?php
    require_once '../bootstrap.php';

    define("FORCING_MSG", "Negli ultimi 5 minuti hai effettuato 5 tentativi a vuoto. Aspetta!");
    define("ERROR_MSG", "Login fallito: ricontrolla i campi!");

    /** 
     * Prevents brute force attacks.
     */
    function checkbrute($userId) {
        global $dbh;
        $now = time();
        $validAttempts = $now - (5 * 60);   /* 5 mins */
        return $dbh->getLoginAttempts($userId, $validAttempts) >= MAX_LOGIN_ATTEMPTS;
    }

    function registerLoggedUser($userData) {
        $_SESSION['userId'] = $userData['UserId'];
        $_SESSION['username'] = $userData['UserId'];
    }

    function login($userData, $password) {
        global $dbh;
        $errors = [];
        $data = [];
        if (count($userData)) { // user exists
            $userData = $userData[0];
            if (checkbrute($userData['UserId'])) {
                $errors["forcing"] = FORCING_MSG;
            } else {
                $password = hash('sha512', $password . $userData['Salt']);
                if ($userData['Password'] == $password) {
                    registerLoggedUser($userData);
                } else {
                    $dbh->registerNewLoginAttempt($userData['UserId'], time());
                    $errors["wrong"] = ERROR_MSG;
                }
            }
        } else {
            $errors["wrong"] = ERROR_MSG;
        }
        if (!empty($errors)) {
            $data["success"] = false;
            $data["errors"] = $errors;
        } else {
            $data["success"] = true;
            $data["message"] = "Login effettuato con successo!";
        }
        return $data;
    }

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        $userData = $dbh->getCustomerData($_POST['customerUsr']);
        echo json_encode(login($userData, $_POST['customerPwd']));
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        $userData = $dbh->getSellerData($_POST['sellerUsr']);
        echo json_encode(login($userData, $_POST['sellerPwd']));
    }

?>