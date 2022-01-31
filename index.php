<?php
    //require_once 'bootstrap.php';

    $templateParams["css"] = array("homepage.css","product.css");
    $templateParams["js"] = array("home.js");
    $templateParams["main"] = "./templates/home-page.php";
    //$templateParams["homeBanner"] = getHomeBanner(); //array di nomi immagini banner, è scontato che si torvino in /img/banner

    //---------------------------------------------------//
    $templateParams["sectionTitle"] = array("newArrival"=>"Nuovi Arrivi","manga" => "manga","hero" => "Supereroi","funko" => "Funko Pop");
    $templateParams["sections"] =array_keys($templateParams["sectionTitle"]);/*i nomi di classi in questo array devono essere rispettati
    nei rispettivi templateParams per il corretto funzionamento*/
    var_dump( $templateParams["sectionTitle"]["newArrival"]);
    /*
    $templateParams["newArrival"] = getNewArrival();
    $templateParams["manga"] = getManga(); //ci si passa un numero in modo da poter decidere un limite di fumetti nella home,
                                                // se non specificato allora no limite
    $templateParams["hero"] = getHeros();
    $templateParams["funko"] = getFunko();
*/
    require 'templates/base.php';
?>

