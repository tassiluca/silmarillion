<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login.css", "login-forms.css");
    $templateParams["js"] = array("login.js", "sha512.js");
    $templateParams["main"] = "./templates/login-page.php";

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        if (!customerLogin($_POST['customerUsr'], $_POST['customerPwd'])) {
            echo "Login failed";
        } else {
            echo "Login success";
        }
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        if (!sellerLogin($_POST['sellerUsr'], $_POST['sellerPwd'])) {
            echo "Login failed";
        } else {
            echo "Login success";
        }
    }

    require 'templates/base.php';
?>