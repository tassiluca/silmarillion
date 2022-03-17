<?php
    /* Reporting all errors */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    define("UPLOAD_DIR", "./upload");
    /** The directory where store the products images. */
    define("UPLOAD_DIR_PRODUCTS", UPLOAD_DIR . "/products/");
    /** The directory where store the publishers logos. */
    define("UPLOAD_DIR_PUBLISHERS", UPLOAD_DIR . "/publishers/");
    /** The directory where store the banners. */
    define("UPLOAD_DIR_BANNER", UPLOAD_DIR."/banner/");
    /** The directory where store the news. */
    define("UPLOAD_DIR_NEWS", UPLOAD_DIR."/news/");

    require_once __DIR__ . '/vendor/autoload.php';
    require_once 'db/database.php';
    require_once 'utils/functions.php';

    // secureSessionStart();    // **TODO**

    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "root";
    const DB_NAME = "silmarillion";
    const DB_PORT = 3306;

    $dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME, DB_PORT);

?>