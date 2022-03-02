<?php
    require_once 'bootstrap.php';
    define("DEFAULT_HOME_QUANTITY",20);
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    $templateParams["css"] = array("homepage.css","products-homepage.css","products.css");
    $templateParams["js"] = array("home.js");
    $templateParams["main"] = "./templates/home-page.php";
    $templateParams["newsBanner"] = $dbh->getHomeBanner();

    //---------------------------------------------------//
    $templateParams["sectionTitle"] = array("newArrival"=>"Nuovi Arrivi","manga" => "Manga","hero" => "Supereroi","funko" => "Funko Pop");
    $templateParams["sections"] =array_keys($templateParams["sectionTitle"]);
    /*i nomi di classi in questo array devono essere rispettati nei rispettivi templateParams per il corretto funzionamento*/
    
    $templateParams["newArrival"] = $dbh -> getNewArrival(); //default amount of new comics is 10, specify as param desired quantity
    $templateParams["manga"] = $dbh -> getComicsOfCategory('manga',DEFAULT_HOME_QUANTITY);
    $templateParams["hero"] = $dbh -> getComicsOfCategory('hero',DEFAULT_HOME_QUANTITY);
    $templateParams["funko"] = $dbh -> getComicsOfCategory('funko',DEFAULT_HOME_QUANTITY);

    $templateParams["reviews"] = $dbh-> getReviews();
    $templateParams["partners"] = $dbh-> getPartners();

    require 'templates/base.php';
?>
