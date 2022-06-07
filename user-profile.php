<?php
    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"] = array("./css/user-profile.css");
    $templateParams["js"] = array("./js/user-profile.js");
    $templateParams["main"] = "./templates/user-profile-template.php";

    $templateParams["type-user"] = isCustomerLoggedIn()?"Utente":"Venditore";


    if(isset($_POST["confirmData"]))  {
        $dbh->changeUser($_SESSION["userId"], "okok", "provacog", $_SESSION["datebirth"]);
    }

    if(isset($_POST["confirmLog"]))  {
        //var_dump($_SESSION['mail']);
        $dbh->changeEmail($_SESSION["userId"], "okok@okok");
    }






    require 'templates/base.php';
?>