<?php
    require_once '../bootstrap.php';

    define("ERROR_USERNAME", "Username già presente nel sistema!");
    define("ERROR_DB", "Errore nel sistema! Riprova...");
    define("SUCCESS", "Registrazione avvenuta con successo!");

    if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["birthday"]) 
    && isset($_POST["usr"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
        $result = [];
        // generate random salt
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $_POST["pwd"].$salt);
        // add to db new user
        $res = $dbh->addCustomer($_POST["usr"], $password, $salt, 
            $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["email"]);
        if (!$res['success'] && $res['duplicateKey']) { // username already present in db
            $result["error"] = ERROR_USERNAME;
        } else if (!$res['success'] && !$res['duplicateKey']) { // other type of error
            $result["error"] = ERROR_DB;
        } else {
            $result["success"] = SUCCESS;
        }
        echo json_encode($result);
    }

?>