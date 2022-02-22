<?php
    require_once 'bootstrap.php';
    require_once 'utils/functions.php';
    //$_SESSION['url'] = $_SERVER['REQUEST_URI'];
    
    $templateParams["css"] = array("statistics.css");
    $templateParams["js"] = array("statistics.js");
    $templateParams["jsExt"] = array("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js");
    
    $templateParams["ordersYears"] = $dbh -> getYearsWithOrders();

    $templateParams["main"] = "./templates/statistics-page.php";

    /*TODO: decomment that when all in fine
    if(isSellerLoggedIn()){
        $templateParams["main"] = "./templates/statistics-page.php";
    }
    else{
        echo "You not have permissions";
        //$templateParams["main"] = ; //error page or message 
    }*/

    require 'templates/base.php';
    
?>