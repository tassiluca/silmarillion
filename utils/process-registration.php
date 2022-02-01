<?php
    require_once '../bootstrap.php';

    if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["birthday"]) 
    && isset($_POST["usr"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
        $result = [];
        // generate random salt
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $_POST["pwd"].$salt);
        // add to db new user
        $userId = $dbh->addUser($_POST["usr"], $password, $salt, 
            $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["email"]);
        if ($userId == -1) { // username already present in db
            $result["error"] = "Username già presente nel sistema";
        } else { // add to db the user customer just inserted
            $res = $dbh->addCustomer($userId);
            $result["ok"] = "ok!";
        }
        echo json_encode($result);
    }

?>