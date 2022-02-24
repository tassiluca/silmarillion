<?php
    require_once 'bootstrap.php';
    define('USE_COOKIE',true);
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    $templateParams["css"] = array("homepage.css","product.css");
    $templateParams["js"] = array("home.js");
    $templateParams["main"] = "./templates/home-page.php";
    $templateParams["newsBanner"] = $dbh->getHomeBanner();

    //---------------------------------------------------//
    $templateParams["sectionTitle"] = array("newArrival"=>"Nuovi Arrivi","manga" => "Manga","hero" => "Supereroi","funko" => "Funko Pop");
    $templateParams["sections"] =array_keys($templateParams["sectionTitle"]);
    /*i nomi di classi in questo array devono essere rispettati nei rispettivi templateParams per il corretto funzionamento*/
    $templateParams["newArrival"] = $dbh -> getNewArrival(); //default amount of new comics is 10, specify as param desired quantity
    $templateParams["manga"] = $dbh -> getComicsOfCategory('manga'); //ci si passa un numero in modo da poter decidere un limite di fumetti nella home,
                                                // se non specificato allora no limite
    $templateParams["hero"] = $dbh -> getComicsOfCategory('hero');
    $templateParams["funko"] = $dbh -> getComicsOfCategory('funko');

    $templateParams["reviews"] = $dbh-> getReviews();
    $templateParams["partners"] = $dbh-> getPartners();

    $templateParams["logged"] = isCustomerLoggedIn() || USE_COOKIE;
    require 'templates/base.php';
?>
