<?php 
    require_once './bootstrap.php';

    /* TODO: input validation */

    $price = htmlspecialchars($_POST['price']);
    $desc = htmlspecialchars($_POST['desc']);
    $category = htmlspecialchars($_POST['category']);
    $discountedPrice = htmlspecialchars($_POST['discountedPrice']);
    list($result, $msg) = uploadImage(UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
    if ($result != 0) {
        $coverImg = $msg;

        // TODO: to refactor...
        /*
        if (empty($category)) {
            $categoryName = htmlspecialchars($_POST['categoryName']);
            $categoryDesc = htmlspecialchars($_POST['categoryDesc']);
            $category = $dbh->addCategory($categoryName, $categoryDesc);
            if (!$category) {
                $msg = "Errore inserimento categoria";
            }
        }
        */

        if ($_POST["articleToInsert"] == "Funko") {
            $funkoName = htmlspecialchars($_POST['funkoName']);
            // insert into db
            $res = $dbh->addFunko($funkoName, $price, $discountedPrice, $desc, $coverImg, $category);
            $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
        } else if ($_POST["articleToInsert"] == "Fumetto") {
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $language = htmlspecialchars($_POST['language']);
            $publishDate = htmlspecialchars($_POST['publishDate']);
            $isbn = htmlspecialchars($_POST['isbn']);
            $publisher = htmlspecialchars($_POST['publisher']);
            // insert into db
            $res = $dbh->addComic($title, $author, $language, $publishDate, $isbn, $publisher,
                                  $price, $discountedPrice, $desc, $coverImg, $category);
            $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
        }
    }
    
    header("location: modify-article.php?formMsg=" . $msg);
?>