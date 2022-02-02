<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("manage-article.css");
    $templateParams["js"] = array("manage-article.js");
    $templateParams["main"] = "./templates/modify-article-page.php";

    $templateParams["categories"] = $dbh->getCategories();
    $templateParams["publishers"] = $dbh->getPublishers();

    function validateInputs() {
        // articleToInsert ?
        $checkCompulsoryFields = checkInputs(array($_POST['category'], $_POST['price'], 
            $_POST['desc'], $_POST['img']));
        if ($_POST["articleToInsert"] == "Funko") {
            $checkFunkoFields = checkInputs(array($_POST["funkoName"]));
            return $checkCompulsoryFields && $checkFunkoFields;
        } else {
            $checkComicFields = checkInputs(array($_POST['title'], $_POST['author'], 
                $_POST['language'], $_POST['publishDate'], $_POST['isbn'], $_POST['publisher']));
            return $checkCompulsoryFields && $checkComicFields;
        }
    }

    if (isset($_POST["articleToInsert"])) {
        if (!validateInputs()){
            $templateParams["error"] = "Alcuni campi sono vuoti!";
        } else {
            print_r($_POST);
        }
    }

    require 'templates/base.php';
?>