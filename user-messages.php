<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-wishlist.css", "./css/user-messages.css");
$templateParams["js"] = array("./js/user-profile.js");
$templateParams["main"] = "./templates/user-messages-template.php";



if(isset($_GET['deleteMessage'])) {
    $dbh->deleteMessage($_GET['deleteMessage']);
}

$templateParams['message'] = $dbh->readMessage($_SESSION['userId']);

require 'templates/base.php';
?>