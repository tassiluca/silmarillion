<?php

    require_once 'db/database.php';
    require_once 'utils/functions.php';

    //secureSessionStart();
    session_start();
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", ""); //TOGLI PASSWORD PRIMA DI PUSHARE
    define("DB_NAME", "silmarillion");
    define("DB_PORT", 3306);

    $dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME, DB_PORT);

?>