<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("manage-article.css");
    $templateParams["js"] = array("manage-article.js");
    $templateParams["main"] = "./templates/modify-article-page.php";

    require 'templates/base.php';
?>