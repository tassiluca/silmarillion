<?php
    require_once __DIR__ . '/bootstrap.php';

    $_SESSION["name"] = $_SERVER["SERVER_NAME"];

    $templateParams["css"] = array("./css/user-page.css", "./css/seller.css");
    $templateParams["js"] = array();
    $templateParams["main"] = "./templates/seller-page-template.php";

    if (!isSellerLoggedIn()) {
        header("location: ./login.php");
    }

    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        logout();
    }

    require 'templates/base.php';
?>