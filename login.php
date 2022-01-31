<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login.css", "login-forms.css");
    $templateParams["js"] = array("login.js", "sha512.js");
    $templateParams["main"] = "./templates/login-page.php";

    if (isset($_POST['usr']) && isset($_POST['userPwd'])) {
        if (!login($_POST['usr'], $_POST['userPwd'])) {
            echo "Login failed";
        } else {
            echo "Login success";
        }
    }

    require 'templates/base.php';
?>