<?php 
    require_once './bootstrap.php';

    /**
     * Make a get request with the message to display if a condition 
     * is evaluated true.
     *
     * @param string $msg the message
     * @param boolean $condition if true the request is handled, otherwise not
     * @return void
     */
    function redirect($msg, $condition = true) {
        if ($condition) {
            echo "ERROR: REDIRECTION";
            header("location: modify-article.php?action=insert&formMsg=" . $msg);
            exit(1);
        }
    }

    function insertCategory($data){
        global $dbh;
        // check consistency
        if (empty($data['category'])) {
            $res = $dbh->addCategory($data['categoryName'], $data['categoryDesc']);
            redirect("Errore in inserimento categoria", !$res);
            $data['category'] = $data['categoryName'];
        }
    }

    function insertPublisher($data) {
        global $dbh;
        // check consistency
        if (empty($data['publisher'])) {
            list($result, $msg) = uploadImage(UPLOAD_DIR_PUBLISHERS, $_FILES["publisherLogo"]);
            redirect($msg, !$result);
            $res = ($dbh->addPublisher($data['publisherName'], $msg) == -1 ? false : true);
            redirect("Errore in inserimento editore", !$res);
            $data['publisher'] = $res;
        }
    }

    /**
     * Puts in an associative array all the inputs inserted in the form.
     *
     * @return array an associative array with [propertyName => value]
     */
    function getInputData() {
        $data = array();
        foreach (array_keys($_POST) as $property) {
            $data[$property] = htmlspecialchars($_POST[$property]);
        }
        return $data;
    }

    $data = getInputData();

    /* TODO: input validation */

    list($result, $msg) = uploadImage(UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
    redirect($msg, !$result);
    $coverImg = $msg;

    insertCategory($data);

    if ($_POST["articleToInsert"] == "Funko") { // funko insert
        // insert into db
        $res = $dbh->addFunko($data['funkoName'], $data['price'], $data['discountedPrice'], 
                              $data['desc'], $coverImg, $data['category']);
        $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
    } else if ($_POST["articleToInsert"] == "Fumetto") { // comic insert
        insertPublisher($data);
        // insert into db
        $res = $dbh->addComic($data['title'], $data['author'], $data['language'], $data['publishDate'], 
                              $data['isbn'], $data['publisher'], $data['price'], 
                              $data['discountedPrice'], $data['desc'], $coverImg, $data['category']);
        $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
    }
    
    redirect($msg);

?>