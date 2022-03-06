<?php 
    require_once './bootstrap.php';
    use Respect\Validation\Validator as v;

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
            echo json_encode($msg);
            exit(1);
        }
    }

    function validate($data) {
        $rules = array (
            'compulsory'        => v::stringType()->notEmpty(),
            'date'              => v::date()->notEmpty(),
            'isbn'              => v::stringType()->length(13, 13),
            'price'             => v::numericVal()->not(v::negative())->notEmpty(),
            'discountedPrice'   => v::not(v::numericVal()->negative())
        );

        $dataDic = array (
            'compulsory' => [$data['desc']],
            'price' => [$data['price']],
            'discountedPrice' => [$data['discountedPrice']]
        );
        if (isFunkoInsertion()) {
            array_push($dataDic['compulsory'], $data['funkoName']);
        } else if (isComicInsertion()) {
            array_push($dataDic['compulsory'], $data['title'], $data['author'], $data['language']);
            $dataDic['date'] = [$data['publishDate']];
            $dataDic['isbn'] = [$data['isbn']];
        }

        $tmp = validateInput($rules, $dataDic);
        $tmp = $tmp && 
            ((empty($data['category']) && !empty($data['categoryName']) && !empty($data['categoryDesc'])) ||
             (!empty($data['category']) && empty($data['categoryName']) && empty($data['categoryDesc']))) &&
            ((empty($data['publisher']) && !empty($data['publisherName']) && !$_FILES['publisherLogo']['error']) ||
             (!empty($data['publisher']) && empty($data['publisherName']) && $_FILES['publisherLogo']['error'])) &&
            ((!empty($data['discountedPrice']) && $data['discountedPrice'] < $data['price']) || empty($data['discountedPrice']));
        redirect("ERRORE INSERIMENTO DATI", !$tmp);
    }

    function isFunkoInsertion() {
        return $_POST["articleToInsert"] === "funko";
    }

    function isComicInsertion() {
        return $_POST["articleToInsert"] === "comic";
    }

    function insertCategory(){
        global $dbh, $data;
        // check consistency
        if (empty($data['category'])) {
            $res = $dbh->addCategory($data['categoryName'], $data['categoryDesc']);
            redirect("Errore in inserimento categoria", !$res);
            $data['category'] = $data['categoryName'];
        }
    }

    function insertPublisher() {
        global $dbh, $data;
        // check consistency
        if (empty($data['publisher'])) {
            list($result, $msg) = uploadImage(UPLOAD_DIR_PUBLISHERS, $_FILES["publisherLogo"]);
            redirect($msg, !$result);
            $res = $dbh->addPublisher($data['publisherName'], $msg);
            redirect("Errore in inserimento editore", $res == -1);
            $data['publisher'] = $res;
        }
    }

    function insertFunko($data, $coverImg) {
        global $dbh;
        return $dbh->addFunko($data['funkoName'], $data['price'], $data['discountedPrice'], 
                              $data['desc'], $coverImg, $data['category']);
    }

    function insertComic($data, $coverImg) {
        global $dbh;
        return $dbh->addComic($data['title'], $data['author'], $data['language'], $data['publishDate'], 
                              $data['isbn'], $data['publisher'], $data['price'], 
                              $data['discountedPrice'], $data['desc'], $coverImg, $data['category']);
    }

    function updateFunko($data) {
        global $dbh;
        return $dbh->updateFunko($data['productId'], $data['funkoName'], $data['price'],  
                                 $data['discountedPrice'], $data['desc'], $data['category']);
    }

    function updateComic($data) {
        global $dbh;
        return $dbh->updateComic($data['productId'], $data['title'], $data['author'], $data['language'], 
                                 $data['publishDate'], $data['isbn'], $data['publisher'], $data['price'], 
                                 $data['discountedPrice'], $data['desc'], $data['category']);
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
    validate($data);

    if ($_POST['action'] === 'delete') {

    }

    if ($_POST['action'] === 'insert') {
        list($result, $msg) = uploadImage(UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
        redirect($msg, !$result);
        $coverImg = $msg;
    } 

    insertCategory($data);
    if (isFunkoInsertion()) {
        $res = ($_POST['action'] === 'insert' ? insertFunko($data, $coverImg) : updateFunko($data));
    } else if (isComicInsertion()) {
        insertPublisher($data);
        $res = ($_POST['action'] === 'insert' ? insertComic($data, $coverImg) : updateComic($data));
    }
    $msg = $res ? "Operazione completata correttamente" : "Si è verificato un errore... riprova!";
    redirect($msg);

?>