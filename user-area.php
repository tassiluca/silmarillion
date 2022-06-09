<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/notify.css", "./css/user-page.css" );
    $templateParams["js"] = array("./js/user-profile.js");
    $templateParams["main"] = "./templates/user-page-template.php";

    if (!isCustomerLoggedIn()) {
        header("location: ./login.php");
    }

    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        logout();
    }

    if(isset($_POST['descr'])){
        $dbh->addNewReview($_POST['rating'], $_POST['area'], $_SESSION['userId']);
    }

    require 'templates/base.php';
?>