<?php
    require_once __DIR__ . '/bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    global $dbh;
    
    $templateParams["css"] = array("./css/catalog.css","./css/products.css");
    $templateParams["js"] = array("./js/catalog.js","./js/product-actions.js");
    $templateParams["main"] = "./templates/catalog-page.php";

    $templateParams["publisher"] = $dbh -> getPublishers();
    $templateParams["languages"] = $dbh -> getLanguages();
    $templateParams["authors"] = $dbh -> getAllAuthors();
    $templateParams["categories"] = $dbh -> getAllCategories();

    require 'templates/base.php';
?>