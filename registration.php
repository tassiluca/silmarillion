<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/login-forms.css", "./css/registration.css");
    $templateParams["js"] = array("./js/registration.js");
    $templateParams["main"] = "./templates/registration-page.php";

    require 'templates/base.php';
?>