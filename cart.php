<?php
    require_once __DIR__ . '/bootstrap.php';
    global $dbh;
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/cart.css");
    $templateParams["main"] = "./templates/cart-page.php";
    $templateParams["js"] = array("./js/utils.js","./js/product-actions.js");

    
    
    require 'templates/base.php';