<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'bootstrap.php';

    $templateParams["css"] = array("login.css", "login-forms.css");
    $templateParams["js"] = array("login.js");
    $templateParams["main"] = "./templates/login-page.php";

    function login($userData, $password) {
        global $dbh;
        $errors = [];
        $data = [];
        if (count($userData)) { // user exists
            $userData = $userData[0];
            if (checkbrute($userData['UserId'])) {
                $errors["brute-force"] = "Negli ultimi 5 minuti hai effettuato 5 tentativi a vuoto. Aspetta!";
            } else {
                $password = hash('sha512', $password . $userData['Salt']);
                if ($userData['Password'] == $password) {
                    registerLoggedUser($userData);
                } else {
                    $dbh->registerNewLoginAttempt($userData['UserId'], time());
                    $erros["wrong"] = "Login fallito: ricontrolla i campi!";
                }
            }
        } else {
            $templateParams["wrong"] = "Login fallito: ricontrolla i campi!";
        }
        if (!empty($errors)) {
            $data["success"] = false;
            $data["errors"] = $errors;
        } else {
            $data["success"] = true;
            $data["message"] = "Login effettuato con successo!";
        }
    }

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        $userData = $dbh->getCustomerData($_POST['customerUsr']);
        login($userData, $_POST['customerPwd']);
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        $userData = $dbh->getSellerData($_POST['sellerUsr']);
        login($userData, $_POST['sellerPwd']);
    }

    require 'templates/base.php';
?>