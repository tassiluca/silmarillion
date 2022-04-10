<?php
    require_once __DIR__ . '/bootstrap.php';
    require_once 'utils/functions.php';
    global $dbh;
    const cookie = 0;
    const db_customer = 1;

    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/cart.css","./css/cart-payment.css");
    $templateParams["main"] = "./templates/cart-page.php";
    $templateParams["js"] = array("./js/utils.js","./js/product-actions.js");

    $prodsInCart = array();

    if(isCustomerLoggedIn()){
        $prodsInCart = getInfoProdsInCart($dbh->getUserCart($_SESSION['userId']),db_customer);
    }
    else if(isset($_COOKIE['cart'])){
        $prodsInCart = getInfoProdsInCart(json_decode($_COOKIE['cart']),cookie);
    }

    $templateParams["cart"] = $prodsInCart;
    
    function getInfoProdsInCart($prodsIdCart,$dataSource){
        global $dbh;
        $prods = array();
        foreach($prodsIdCart as $prod){
            if($dataSource == cookie){
                $elem = $dbh -> getProduct($prod[0]);
                $elem["Quantity"] = $prod[1];
                array_push($prods,$elem);
            }
            else if($dataSource == db_customer){
                $elem = $dbh -> getProduct($prod['ProductId']);
                $elem['Quantity'] = $prod['Quantity'];
                array_push($prods,$elem);
            }
        }
        return $prods;
    }

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
 