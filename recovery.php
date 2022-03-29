<?php
    require_once __DIR__ . 'bootstrap.php';
    /** @var DatabaseHelper $dbh */

    $templateParams["css"] = array("./css/login-forms.css", "./css/registration.css");
    $templateParams["main"] = "./templates/recovery-page.php";

    if (isset($_POST['email'])) {
        // TODO: implement logic to reset password
        print_r($dbh->getCustomerDataByMail($_POST['email']));
    }

    require 'templates/base.php';
?>