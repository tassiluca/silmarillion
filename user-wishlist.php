<?php
require_once __DIR__ . '/bootstrap.php';

global $dbh;

$templateParams["css"] = array("./css/user-wishlist.css");
$templateParams["js"] = array("./js/product-actions.js");
$templateParams["main"] = "./templates/user-wishlist-template.php";


$templateParams["fav-elem"] = getFavourites($_SESSION["userId"], $dbh);

require 'templates/base.php';
?>