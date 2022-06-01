<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-messages.css");
$templateParams["js"] = array();
$templateParams["main"] = "./templates/user-messages-template.php";

require 'templates/base.php';
?>