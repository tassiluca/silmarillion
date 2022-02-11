<?php 
    require_once './bootstrap.php';

    function validateInputs() {
        // articleToInsert ?
        $checkCompulsoryFields = checkInputs(array($_POST['category'], $_POST['price'], 
            $_POST['desc'], $_FILES['coverImg']));
        if ($_POST["articleToInsert"] == "Funko") {
            $checkFunkoFields = checkInputs(array($_POST['funkoName']));
            return $checkCompulsoryFields && $checkFunkoFields;
        } else if ($_POST['articleToInsert'] == "Fumetto") {
            $checkComicFields = checkInputs(array($_POST['title'], $_POST['author'], 
                $_POST['language'], $_POST['publishDate'], $_POST['isbn'], $_POST['publisher']));
            return $checkCompulsoryFields && $checkComicFields;
        }
    }

    if (!validateInputs()) {
        header("location: modify-article.php?formMsg=Campi vuoti!");
    }
    list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["coverImg"]);
    if ($result != 0) {
        $coverImg = $msg;
        $price = htmlspecialchars($_POST['price']);
        $desc = htmlspecialchars($_POST['desc']);
        $category = htmlspecialchars($_POST['category']);
        $discountedPrice = htmlspecialchars($_POST['discountedPrice']);
        if ($_POST["articleToInsert"] == "Funko") {
            $funkoName = htmlspecialchars($_POST['funkoName']);
            // insert into db
            $res = $dbh->addFunko($funkoName, 
                                  $price, 
                                  $discountedPrice, 
                                  $desc, 
                                  $coverImg,
                                  $category);
            $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
        } else if ($_POST["articleToInsert"] == "Fumetto") {
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $language = htmlspecialchars($_POST['language']);
            $publishDate = htmlspecialchars($_POST['publishDate']);
            $isbn = htmlspecialchars($_POST['isbn']);
            $publisher = htmlspecialchars($_POST['publisher']);
            // insert into db
            $res = $dbh->addComic($title,
                                  $author,
                                  $language,
                                  $publishDate,
                                  $isbn,
                                  $publisher,
                                  $price,
                                  $discountedPrice,
                                  $desc,
                                  $coverImg, 
                                  $category);
            $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
        }
    }
    
    header("location: modify-article.php?formMsg=" . $msg);

?>