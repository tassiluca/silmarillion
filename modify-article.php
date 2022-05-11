<?php
    require_once __DIR__ . '/bootstrap.php';
    /** @var DatabaseHelper $dbh */

    /* [NOTE] For more details about select2: [https://select2.org/] */
    $templateParams["css"] = array("./css/modify-article.css", 
        /* includes select2 compiled css for select box with support for searching */
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css");
    $templateParams["js"] = array("./js/modify-article.js", 
        /* includes select2 compiled js for select box with support for searching */
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js");
    $templateParams["main"] = "./templates/modify-article-page.php";
    $templateParams["categories"] = $dbh->getCategories();
    $templateParams["publishers"] = $dbh->getPublishers();

    /**
     * [NOTES]
     * In order to add a new product must be get-requested "action=insert" with "article=?" 
     * where ? is 'funko' or 'comic' depending on wich type of product want to insert.
     * In order to modify or delete a product must be get-requested "action=modify&id=?"
     * where ? is the product's id to modify.
     */
    // if the seller is not logged in or get request is not complete as described above
    // redirect the user to the login page
    if (!isSellerLoggedIn() || !isset($_GET['action']) ||
        ($_GET['action'] !== 'insert' && $_GET['action'] !== 'modify' && $_GET['action'] !== 'delete') ||
        ($_GET['action'] === 'insert' && (!isset($_GET['article']) || 
        ($_GET['article'] !== 'funko' && $_GET['article'] !== 'comic')) ||
        ($_GET['action'] !== 'insert' && !isset($_GET['id'])))) {
            header("location: login.php");
    }

    if ($_GET["action"] !== 'insert') {
        $templateParams['article'] = $dbh->isFunko($_GET['id']) ? 'funko' : 'comic';
        $productInfo = $dbh->getProduct($_GET['id']);
        if (count($productInfo) == 0) { // no product found in the database
            header("location: not-found.php");
        } else { // product found in the database
            $templateParams["product"] = $productInfo[0];
            $templateParams["product"]["Quantity"] = $dbh->getAvaiableCopiesOfProd($_GET['id']);
        }
    } else {
        $templateParams['article'] = $_GET['article'];
        $templateParams['product'] = getEmptyFormData();
    }
    $templateParams["action"] = $_GET["action"];

    /**
     * Creates an associative array with all fields of the form blank.
     * @return array with all blank-initialized fields
     */
    function getEmptyFormData(): array
    {
        $fields = array("Name", "Title", "Author", "Lang", "PublishDate", "ISBN", "ProductId", "PublisherId", 
        "Price", "DiscountedPrice", "Description", "CategoryName", "PublisherName", "CoverImg", "Quantity");
        return array_fill_keys($fields, '');
    }

    require 'templates/base.php';
?>