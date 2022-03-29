<?php
    require_once __DIR__ . 'bootstrap.php';
    
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

    $templateParams["css"] = array("./css/not-found.css",);
    $templateParams["js"] = array("./js/home.js");
    $templateParams["main"] = "./templates/not-found-page.php";

    require 'templates/base.php';
?>