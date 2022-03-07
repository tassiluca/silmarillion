<?php

    /* Reporting all errors */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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

    // secureSessionStart();    // **TODO**

    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");     // Remove it before pushing
    define("DB_NAME", "silmarillion");
    define("DB_PORT", 3306);

    $dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME, DB_PORT);

    define("UPLOAD_DIR", "./upload");
    define("PRODUCTS_DIR", UPLOAD_DIR."/products/");
    define("PUBLISHER_DIR", UPLOAD_DIR."/publishers/");
    define("BANNER_DIR", UPLOAD_DIR."/banner/");
?>