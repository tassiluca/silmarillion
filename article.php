<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("article.css");
    $templateParams["js"] = array("");
    $templateParams["main"] = "./templates/single-article.php";
    $templateParams["product"] = $dbh -> getProductById(2)[0];
    $templateParams["copies"] = $dbh -> getCopiesOfProduct(2);
    
    require 'templates/base.php';
?>