<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/user-profile.css");
    $templateParams["js"] = array();
    $templateParams["main"] = "./templates/user-profile-template.php";

    $templateParams["type-user"] = isCustomerLoggedIn()?"Utente":"Venditore";

    require 'templates/base.php';
?>