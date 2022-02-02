<?php
    require_once 'bootstrap.php';
    session_start(); 
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("catalog.css","products-catalog.css");
    $templateParams["js"] = array("home.js");
    $templateParams["main"] = "./templates/catalog-page.php";

    $templateParams["logged"] = true;
    require 'templates/base.php';
?>