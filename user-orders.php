<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-orders.css");
$templateParams["js"] = array();
$templateParams["main"] = "./templates/user-orders-template.php";

if (!isCustomerLoggedIn()) {
    header('location: ./user-area.php');
}

$templateParams['orderDetails'] = $dbh->getOrderById($_SESSION['userId']);
//$templateParams['orderProduct'] = $dbh->detailOrder()


require 'templates/base.php';
?>