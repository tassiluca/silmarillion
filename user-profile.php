<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/user-profile.css");
    $templateParams["js"] = array("./js/user-profile.js");
    $templateParams["main"] = "./templates/user-profile-template.php";

    $templateParams["type-user"] = isCustomerLoggedIn()?"Utente":"Venditore";


    if(isset($_POST["confirmData"]))  {
        $_SESSION["name"] = $_POST['nomeUtente'];
        $_SESSION["surname"] = $_POST['cognomeUtente'];
        $_SESSION["datebirth"] = $_POST['compleannoUtente'];
        $dbh->changeUser($_SESSION["userId"], $_POST['nomeUtente'], $_POST['cognomeUtente'] , $_POST["compleannoUtente"]);
    }

    if(isset($_POST["confirmLog"]))  {
        //var_dump($_SESSION['mail']);
        $_SESSION['mail'] = $_POST['emailUtente'];
        $dbh->changeEmail($_SESSION["userId"], $_POST['emailUtente']);
    }

    if(isset($_POST["id1"])){
        if(isset($_POST["saved"])){
            $templateParams['pay'] = $dbh->addPay("PayPal", $_POST["id1"]);
            $dbh->addUserPay($dbh->getLastPayMethod()[0]["MethodId"], $_SESSION["userId"]);
        }
        elseif (isset($_POST["deleted"])){
            $allEmail = $dbh->getAllIdPayPal($_POST["id1"]);
            foreach ($allEmail as $mail){
                $dbh->removeHolder($mail["MethodId"]);
            }
            $templateParams['pay'] = $dbh->removePay($_POST["id1"]);
        }
    }

    if(isset($_POST["id2"])){
        if(isset($_POST["saved"])){
            $templateParams['pay'] = $dbh->addPay("PayPal", $_POST["id2"]);
            $dbh->addUserPay($dbh->getLastPayMethod()[0]["MethodId"], $_SESSION["userId"]);
        }
        elseif (isset($_POST["deleted"])){
            $allEmail = $dbh->getAllIdPayPal($_POST["id2"]);
            foreach ($allEmail as $mail){
                $dbh->removeHolder($mail["MethodId"]);
            }
            $templateParams['pay'] = $dbh->removePay($_POST["id2"]);
        }
    }

    if(isset($_POST["id3"])){
        if(isset($_POST["saved"])){
            $templateParams['pay'] = $dbh->addPay("PayPal", $_POST["id3"]);
            $dbh->addUserPay($dbh->getLastPayMethod()[0]["MethodId"], $_SESSION["userId"]);
        }
        elseif (isset($_POST["deleted"])){
            $allEmail = $dbh->getAllIdPayPal($_POST["id3"]);
            foreach ($allEmail as $mail){
                $dbh->removeHolder($mail["MethodId"]);
            }
            $templateParams['pay'] = $dbh->removePay($_POST["id3"]);
        }
    }

    if(isset($_POST["id4"])){
        if(isset($_POST["saved"])){
            $templateParams['pay'] = $dbh->addPay("PayPal", $_POST["id4"]);
            $dbh->addUserPay($dbh->getLastPayMethod()[0]["MethodId"], $_SESSION["userId"]);
        }
        elseif (isset($_POST["deleted"])){
            $allEmail = $dbh->getAllIdPayPal($_POST["id4"]);
            foreach ($allEmail as $mail){
                $dbh->removeHolder($mail["MethodId"]);
            }
            $templateParams['pay'] = $dbh->removePay($_POST["id4"]);
        }
    }



    require 'templates/base.php';
?>
