<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["css"] = array("./css/user-profile.css", "./css/seller-profile.css");
$templateParams["js"] = array("./js/user-profile.js");
$templateParams["main"] = "./templates/seller-profile-template.php";

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



require 'templates/base.php';
?>
