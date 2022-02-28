<?php
    session_start();

    define("UPLOAD_DIR_NEWS", "./upload/news/");
    /**
     * The directory in which store the products images.
     */
    define("UPLOAD_DIR_PRODUCTS", "./upload/products/");
    define("UPLOAD_DIR_PUBLISHERS", "./upload/publishers/");    

    require_once __DIR__ . '/vendor/autoload.php';
    require_once 'db/database.php';
    require_once 'utils/functions.php';
    require_once 'utils/validator.php';

    // secureSessionStart();

    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", ""); //TOGLI PASSWORD PRIMA DI PUSHARE
    define("DB_NAME", "silmarillion");
    define("DB_PORT", 3306);

    $dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME, DB_PORT);

?>