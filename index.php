<?php
    require_once __DIR__ . 'bootstrap.php';
    const DEFAULT_HOME_QUANTITY = 20;
    global $dbh;
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

    $templateParams["css"] = array("./css/homepage.css","./css/products.css");
    $templateParams["js"] = array("./js/home.js","./js/utils.js","./js/product-actions.js");
    $templateParams["main"] = "./templates/home-page.php";
    $templateParams["newsBanner"] = $dbh->getHomeBanner();

    //---------------------------------------------------//
    $templateParams["sectionTitle"] = array("newArrival"=>"Nuovi Arrivi","manga" => "Manga","hero" => "Supereroi","funko" => "Funko Pop");
    $templateParams["sections"] =array_keys($templateParams["sectionTitle"]);
    /*i nomi di classi in questo array devono essere rispettati nei rispettivi templateParams per il corretto funzionamento*/
    
    $templateParams["newArrival"] = $dbh -> getNewArrival(); //default amount of new comics is 10, specify as param desired quantity
    $templateParams["manga"] = $dbh -> getComicsOfCategory('manga',DEFAULT_HOME_QUANTITY);
    $templateParams["hero"] = $dbh -> getComicsOfCategory('hero',DEFAULT_HOME_QUANTITY);
    $templateParams["funko"] = $dbh -> getFunkos(DEFAULT_HOME_QUANTITY);
    
    $templateParams["reviews"] = $dbh-> getReviews();
    $templateParams["publisher"] = $dbh-> getPublishers();

    require 'templates/base.php';
?>
