<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/login-forms.css", "css/login.css");
    $templateParams["js"] = array("./js/login.js");
    $templateParams["main"] = "./templates/login-page.php";

    /* if the user is already logged, redirect him into his personal area */
    if (isCustomerLoggedIn()) {
        header('location: ./userArea.php');
    } else if (isSellerLoggedIn()) {
        header('location: ./sellerArea.php');
    }

    require 'templates/base.php';
?>