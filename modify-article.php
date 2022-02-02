<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("manage-article.css");
    $templateParams["js"] = array("manage-article.js");
    $templateParams["main"] = "./templates/modify-article-page.php";

    $templateParams["categories"] = $dbh->getCategories();
    $templateParams["publishers"] = $dbh->getPublishers();

    if (isset($_GET['formMsg'])) {
        $templateParams["formMsg"] = $_GET['formMsg'];
    }

    require 'templates/base.php';
?>