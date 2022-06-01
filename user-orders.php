<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-orders.css");
$templateParams["js"] = array();
$templateParams["main"] = "./templates/user-orders-template.php";

require 'templates/base.php';
?>