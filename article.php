<?php
    require_once 'bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("./css/article.css");
    $templateParams["main"] = "./templates/single-article.php";
    $templateParams["js"] = array("./js/utils.js","./js/product-actions.js");

    $idprodotto = -1;
    if(isset($_GET["id"]) && $dbh -> isComic($_GET["id"])){
        $templateParams["product"] = $dbh -> getComicById($_GET["id"])[0];
    }
    else if(isset($_GET["id"]) && $dbh -> isFunko($_GET["id"])){
        $templateParams["product"] = $dbh -> getFunkoById($_GET["id"])[0];
    }
    
    $templateParams["copies"] = $dbh -> getAvaiableCopiesOfProd($idprodotto);
    $templateParams["logged"] = isCustomerLoggedIn();

    require 'templates/base.php';
?>