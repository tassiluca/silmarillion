<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("registration.css", "login-forms.css");
    $templateParams["js"] = array("registration.js");
    $templateParams["main"] = "./templates/registration-page.php";

    if (isset($_POST["name"]) && isset($_POST["surname"]) && 
        isset($_POST["birthday"]) && isset($_POST["usr"]) &&
        isset($_POST["email"]) && isset($_POST["pwd"])) {
            // generate random salt
            $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $password = hash('sha512', $_POST["pwd"].$salt);
            // add to db new user
            $userId = $dbh->addUser($_POST["usr"], $password, $salt, 
                $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["email"]);
            // add to db the user customer just inserted
            $dbh->addCustomer($userId);
    }

    require 'templates/base.php';
?>