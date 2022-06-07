<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/user-page.css","./css/ratingStars.css");
    $templateParams["js"] = array("./js/user-profile.js");
    $templateParams["main"] = "./templates/user-page-template.php";

    if (!isCustomerLoggedIn()) {
        header("location: ./login.php");
    }

    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        logout();
    }

    require 'templates/base.php';
?>