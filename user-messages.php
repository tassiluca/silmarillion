<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-wishlist.css", "./css/user-messages.css");
$templateParams["js"] = array("./js/user-profile.js");
$templateParams["main"] = "./templates/user-messages-template.php";

require 'templates/base.php';
?>