<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login-forms.css", "registration.css");
    $templateParams["js"] = array();
    $templateParams["main"] = "./templates/recovery-page.php";

    require 'templates/base.php';
?>