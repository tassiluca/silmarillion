<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("registration.css", "login-forms.css");
    $templateParams["js"] = array("registration.js");
    $templateParams["main"] = "./templates/registration-page.php";

    require 'templates/base.php';
?>