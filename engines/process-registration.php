<?php
    require_once '../bootstrap.php';
    /** @var DatabaseHelper $dbh */

    const ERROR_USERNAME = "Username/Mail già presente nel sistema!";
    const ERROR_DB = "Errore nel sistema! Riprova...";
    const SUCCESS = "Registrazione avvenuta con successo!";

    if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["birthday"]) &&
        isset($_POST["usr"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
        $result = [];
        // generate random salt
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $_POST["pwd"].$salt);
        // add to db new user
        $res = $dbh->addCustomer($_POST["usr"], $password, $salt, 
            $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["email"]);
        if ($res === 0) {
            $result["success"] = SUCCESS;
        } else if ($res === MYSQLI_CODE_DUPLICATE_KEY) {
            $result["error"] = ERROR_USERNAME;
        } else { // other type of error
            $result["error"] = ERROR_DB;
        }
        echo json_encode($result);
    }

?>