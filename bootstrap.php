<?php

    require_once("db/database.php");
    require_once("utils/functions.php");

    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DB_NAME", "silmarillion");
    define("DB_PORT", 3306);

    $dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME, DB_PORT);

?>