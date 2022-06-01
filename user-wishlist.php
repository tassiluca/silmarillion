<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-wishlist.css");
$templateParams["js"] = array();
$templateParams["main"] = "./templates/user-wishlist-template.php";


$templateParams["fav-elem"] = getFavourites($_SESSION["userId"], $dbh);


require 'templates/base.php';
?>