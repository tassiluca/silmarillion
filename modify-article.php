<?php
    require_once 'bootstrap.php';

    $templateParams["css"] = array("manage-article.css");
    $templateParams["js"] = array("manage-article.js");
    $templateParams["main"] = "./templates/modify-article-page.php";

    function validateInputs() {
        // articleToInsert ?
        $checkCompulsoryFields = checkInputs(array($_POST['category'], $_POST['price'], 
            $_POST['discountedPrice'], $_POST['desc'], $_POST['img']));
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
            echo "AIUTO!";
        } else {
            echo "ok";
        }
    }

    require 'templates/base.php';
?>