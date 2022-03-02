<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("modify-article.css");
    $templateParams["js"] = array("modify-article.js");
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

    // if the seller is not logged in or get request is not complete as descripted above
    // redirect the user to the login page
    if (!isSellerLoggedIn() || !isset($_GET['action']) ||
        ($_GET['action'] !== 'insert' && $_GET['action'] !== 'modify') ||
        ($_GET['action'] === 'insert' && (!isset($_GET['article']) || 
        ($_GET['article'] !== 'funko' && $_GET['article'] !== 'comic')) ||
        ($_GET['action'] !== 'insert' && !isset($_GET['id'])))) {
            header("location: login.php");
    } else {
        $templateParams['article'] = $_GET['article'];
    }

    if ($_GET["action"] !== 'insert') {
        $templateParams['article'] = $dbh->isFunko($_GET['id']) ? 'funko' : 'comic';
        $productInfo = $dbh->getProduct($_GET['id']);
        if (count($productInfo) == 0) {
            $templateParams["product"] = null;
        } else {
            $templateParams["product"] = $productInfo[0];
        }
    } else {
        $templateParams['product'] = getEmptyFormData();
    }

    function getEmptyFormData(){
        $fields = array("Name", "Title", "Author", "Lang", "PublishDate", "ISBN", "ProductId", "PublisherId", 
        "Price", "DiscountedPrice", "Description", "CategoryName", "PublisherName", "CoverImg");
        return array_map(function() { return ""; }, $fields);
    }

    require 'templates/base.php';
?>