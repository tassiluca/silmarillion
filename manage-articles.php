<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/manage-article.css");
    $templateParams["js"] = array("./js/manage-articles.js");
    $templateParams["main"] = "./templates/manage-article-page.php";
    
    if (!isSellerLoggedIn()) {
        header("location: login.php");
    }

    require 'templates/base.php';
?>