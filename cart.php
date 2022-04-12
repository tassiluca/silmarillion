<?php
    require_once __DIR__ . '/bootstrap.php';
    require_once 'utils/functions.php';
    global $dbh;

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/cart.css","./css/cart-payment.css");
    $templateParams["main"] = "./templates/cart-page.php";
    $templateParams["js"] = array("./js/utils.js","./js/product-actions.js","./js/cart.js");

    $templateParams["cart"] =  getCart();
    
    require 'templates/base.php';

/* COOKIE
    array(2) { 
        [0]=> array(2) { [0]=> int(18) [1]=> int(2) }
        [1]=> array(2) { [0]=> int(12) [1]=> int(1) } 
    } 

    array(3) { [0]=> array(3) { ["ProductId"]=> int(2) ["UserId"]=> int(7) ["Quantity"]=> int(1) }
               [1]=> array(3) { ["ProductId"]=> int(12) ["UserId"]=> int(7) ["Quantity"]=> int(1) }
               [2]=> array(3) { ["ProductId"]=> int(18) ["UserId"]=> int(7) ["Quantity"]=> int(1) } } 
*/
 