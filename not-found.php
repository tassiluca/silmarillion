<?php
    require_once 'bootstrap.php';
    
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 

    $templateParams["css"] = array("./css/homepage.css","./css/products.css");
    $templateParams["js"] = array("./js/home.js");
    $templateParams["main"] = "./templates/home-page.php";

?>