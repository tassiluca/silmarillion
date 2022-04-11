<?php

    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"]  = array("./css/payment.css", "./css/cart-payment.css");
    $templateParams["js"]   = array();
    $templateParams["main"] = "./templates/payment-page.php";

    if (!isCustomerLoggedIn()) {
        // TODO better
        header("location: ./not-found.php");
    }

    require "./templates/base.php";
?>