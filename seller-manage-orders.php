<?php
require_once __DIR__ . '/bootstrap.php';

global $dbh;

$templateParams["css"] = array( "./css/seller-manage-orders.css");
$templateParams["js"] = array("");
$templateParams["main"] = "./templates/seller-manage-orders-template.php";


$templateParams["order"] = $dbh->getOrder();

require 'templates/base.php';
?>