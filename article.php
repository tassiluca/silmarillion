<?php
    require_once 'bootstrap.php';
    session_start(); 
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("article.css");
    $templateParams["js"] = array("");
    $templateParams["main"] = "./templates/single-article.php";

    $idprodotto = -1;
    if(isset($_GET["id"])){
        $idprodotto = $_GET["id"];
    }   
    $templateParams["product"] = $dbh -> getProductById($idprodotto)[0];
    $templateParams["copies"] = $dbh -> getCopiesOfProduct($idprodotto);
    

    require 'templates/base.php';
?>