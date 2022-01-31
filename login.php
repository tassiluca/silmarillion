<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login.css", "login-forms.css");
    $templateParams["js"] = array("login.js");
    $templateParams["main"] = "./templates/login-page.php";


    require 'templates/base.php';
?>