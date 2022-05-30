<?php
    require_once __DIR__ . '/bootstrap.php';

    $_SESSION["name"] = $_SERVER["SERVER_NAME"];

    $templateParams["css"] = array("./css/user-page.css");
    $templateParams["js"] = array();
    $templateParams["main"] = "./templates/user-page.php";

    if (!isCustomerLoggedIn()) {
        header("location: ./login.php");
    }

    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        logout();
    }

    require 'templates/base.php';
?>