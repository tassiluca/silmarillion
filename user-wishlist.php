<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-wishlist.css");
$templateParams["js"] = array();
$templateParams["main"] = "./templates/user-wishlist-template.php";


$templateParams["fav-elem"] = getFavourites($_SESSION["userId"], $dbh);


if(isset($_GET)) {

// print_r($_GET);
    if($_GET['action'] === 'addtoCart' && isset($_GET['id']) ){
        $dbh->insertProdCart($_SESSION['userId'], $_GET['id'], 1);
    }

}



require 'templates/base.php';
?>