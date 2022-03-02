<?php
    require_once 'bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("article.css");
    $templateParams["js"] = array("");
    $templateParams["main"] = "./templates/single-article.php";

    $idprodotto = -1;
    if(isset($_GET["comicId"])){
        $templateParams["product"] = $dbh -> getComicById($_GET["comicId"])[0];
    }
    else if(isset($_GET["funkoId"])){
        $templateParams["product"] = $dbh -> getFunkoById($_GET["funkoId"])[0];
    }
    
    $templateParams["copies"] = $dbh -> getAvaiableCopiesOfProd($idprodotto);
    $templateParams["logged"] = isCustomerLoggedIn();

    require 'templates/base.php';
?>