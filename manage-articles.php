<?php
    require_once __DIR__ . '/bootstrap.php';

    define("PRODUCTS_PER_PAGE", 4);

    $templateParams["css"] = array("./css/manage-article.css");
    $templateParams["js"] = array("./js/manage-articles.js");
    $templateParams["main"] = "./templates/manage-article-page.php";
    
    if (!isCustomerLoggedIn()) {
        header("location: login.php");
    }

    require 'templates/base.php';
?>