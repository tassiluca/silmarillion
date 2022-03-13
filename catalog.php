<?php
    require_once 'bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    define("CATALOG_PROD_QUANTITY",25);
    
    $templateParams["css"] = array("./css/catalog.css","./css/products.css");
    $templateParams["js"] = array("./js/catalog.js","./js/utils.js");
    $templateParams["main"] = "./templates/catalog-page.php";

    $templateParams["publisher"] = $dbh -> getPublishers();
    $templateParams["languages"] = $dbh -> getLanguages();
    $templateParams["authors"] = $dbh -> getAllAuthors();
    $templateParams["categories"] = $dbh -> getAllCategories();

    require 'templates/base.php';
?>