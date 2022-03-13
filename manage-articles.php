<?php
    require_once 'bootstrap.php';
    
    define("COMICS_NUM", 5);
    define("FUNKOS_NUM", 5);

    $templateParams["css"] = array("./css/manage-article.css");
    $templateParams["js"] = array("./js/manage-articles.js");
    $templateParams["main"] = "./templates/manage-article-page.php";

    require 'templates/base.php';
?>