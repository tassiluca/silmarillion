<?php
    require_once __DIR__ . '/bootstrap.php';
    require_once 'utils/functions.php';
    global $dbh;

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/cart.css","./css/cart-payment.css");
    $templateParams["main"] = "./templates/cart-page.php";
    $templateParams["js"] = array("./js/product-actions.js","./js/cart.js");

    $templateParams["cart"] =  getCart();
    
    require 'templates/base.php';
?>