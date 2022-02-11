<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("login-forms.css", "registration.css");
    $templateParams["main"] = "./templates/recovery-page.php";

    if (isset($_POST['email'])) {
        // TODO: implement logic to reset password
        print_r($dbh->getCustomerDataByMail($_POST['email']));
    }

    require 'templates/base.php';
?>