<?php
    require_once 'bootstrap.php';
    session_start(); 
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    
    $templateParams["css"] = array("catalog.css","products-catalog.css");
    $templateParams["js"] = array("catalog.js");
    $templateParams["main"] = "./templates/catalog-page.php";
    $templateParams["publisher"] = $dbh -> getPartners();
    $templateParams["languages"] = $dbh -> getLanguages();
    $templateParams["authors"] = $dbh -> getAllAuthors();
    $templateParams["logged"] = true;
    require 'templates/base.php';
    
?>