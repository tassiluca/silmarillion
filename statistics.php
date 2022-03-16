<?php
    require_once 'bootstrap.php';
    require_once 'utils/functions.php';
    global $dbh;
    //$_SESSION['url'] = $_SERVER['REQUEST_URI'];
    
    $templateParams["css"] = array("./css/statistics.css");
    $templateParams["js"] = array("./js/statistics.js", 
        "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js");
    
    $templateParams["ordersYears"] = $dbh -> getYearsWithOrders();

    if(isSellerLoggedIn()){
        $templateParams["main"] = "./templates/statistics-page.php";
    }
    else{
        echo "You not have permissions";
        $templateParams["main"] = "./templates/error-page.php";
    }

    require 'templates/base.php';
    
?>