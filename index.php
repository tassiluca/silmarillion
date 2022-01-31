<?php
    //require_once 'bootstrap.php';

    $templateParams["css"] = array("homepage.css","product.css");
    $templateParams["js"] = array("home.js");
    $templateParams["main"] = "./templates/home-page.php";
    $templateParams["homeBanner"] = getHomeBanner(); //array di nomi immagini banner, è scontato che si torvino in /img/banner
    $templateParams["newArrival"] = getNewArrival();
    $templateParams["mangaComics"] = getManga(); //ci si passa un numero in modo da poter decidere un limite di fumetti nella home,
                                                // se non specificato allora no limite
    $templateParams["heroComics"] = getHeros();
    
    require 'templates/base.php';
?>

