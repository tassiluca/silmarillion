<?php
    require_once 'bootstrap.php';
    $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
    
    $templateParams["css"] = array("catalog.css","products-catalog.css");
    $templateParams["js"] = array("catalog.js");
    $templateParams["main"] = "./templates/catalog-page.php";

    $templateParams["publisher"] = $dbh -> getPartners();
    $templateParams["languages"] = $dbh -> getLanguages();
    $templateParams["authors"] = $dbh -> getAllAuthors();
    $templateParams["categories"] = $dbh -> getAllCategories();
    $templateParams["logged"] = isCustomerLoggedIn();
    $templateParams["products"] = $dbh -> getAllComics();

    if(isset($_GET) && !empty($_GET)){
        $category = $_GET['category'];
        $prodOfCategory = $dbh-> getComicsOfCategory($category);
        if(count($prodOfCategory ) > 1){
            $templateParams["filter"] = $category;
            $templateParams["products"] = $prodOfCategory;
        }
    }
    require 'templates/base.php';
    
?>