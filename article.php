<?php
    require_once __DIR__ . '/bootstrap.php';
    global $dbh;
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/article.css");
    $templateParams["main"] = "./templates/single-article.php";
    $templateParams["js"] = array("./js/utils.js","./js/product-actions.js");

    $idprodotto = -1;
    
    if(isset($_GET["id"])){
        $idprodotto = $_GET["id"];

        if($dbh -> isComic($idprodotto)){
            $templateParams["product"] = $dbh -> getComicById($idprodotto)[0];
        }
        else if($dbh -> isFunko( $idprodotto)){
            $templateParams["product"] = $dbh -> getFunkoById($idprodotto)[0];
        }
    }
    
    $templateParams["copies"] = $dbh -> getAvaiableCopiesOfProd($idprodotto);
    $templateParams["logged"] = isCustomerLoggedIn();
    $templateParams["isAlertActive"] = true; // button disabled

    if(isCustomerLoggedIn()){
        $templateParams["isAlertActive"] = !$dbh -> isAlertActive($_SESSION['userId'],$idprodotto);
    }
    
    require 'templates/base.php';
?>