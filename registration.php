<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login-forms.css", "registration.css");
    $templateParams["js"] = array("registration.js");
    $templateParams["main"] = "./templates/registration-page.php";

    require 'templates/base.php';
?>