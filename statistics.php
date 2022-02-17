<?php
    require_once 'bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("");
    $templateParams["js"] = array("statistics.js");
    $templateParams["jsExt"] = array("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js");
    
    $templateParams["main"] = "./templates/statistics-page.php";

    //$templateParams["logged"] = isCustomerLoggedIn();

    require 'templates/base.php';
    
?>