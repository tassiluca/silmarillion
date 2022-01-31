<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login.css", "login-forms.css");
    $templateParams["js"] = array("login.js", "sha512.js");
    $templateParams["main"] = "./templates/login-page.php";

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        if (!customerLogin($_POST['customerUsr'], $_POST['customerPwd'])) {
            $templateParams["loginError"] = "Login fallito: ricontrolla i campi!";
        } else {
            /* TODO header(location: user-page.php) */
            echo "Login success";
        }
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        if (!sellerLogin($_POST['sellerUsr'], $_POST['sellerPwd'])) {
            $templateParams["loginError"] = "Login fallito: ricontrolla i campi!";
        } else {
            /* TODO header(location: seller-page.php) */
            echo "Login success";
        }
    }

    require 'templates/base.php';
?>