<?php 
    require_once './bootstrap.php';
    use Respect\Validation\Validator as v;

    function isFunkoProcessing() {
        return $_POST["article"] === "funko";
    }

    function isComicProcessing() {
        return $_POST["article"] === "comic";
    }

    function redirect($msg, $condition = true) {
        $res = [];
        if ($condition) {
            $res['error'] = $msg;
            echo json_encode($res);
            exit(1);
        }
    }

    function checkErrors($error, $initMsg) {
        redirect(($error === MYSQLI_CODE_DUPLICATE_KEY ? 
            $initMsg . " già presente nel Data Base!" : 
            "Si è verificato un errore imprevisto (Codice " . $error . ")"), $error);
    }

    function validateCategory($data) {
        return (empty($data['category']) && !empty($data['categoryName']) && !empty($data['categoryDesc'])) ||
            (!empty($data['category']) && empty($data['categoryName']) && empty($data['categoryDesc']));
    }

    function validatePublisher($data) {
        return isFunkoProcessing() ||
            (empty($data['publisher']) && !empty($data['publisherName']) && !$_FILES['publisherLogo']['error']) ||
            (!empty($data['publisher']) && empty($data['publisherName']) && $_FILES['publisherLogo']['error']);
    }

    function validateDiscountedPrice($data) {
        return empty($data['discountedPrice']) || 
            (!empty($data['discountedPrice']) && $data['discountedPrice'] < $data['price']);
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

        if (isFunkoProcessing()) {
            array_push($dataDic['compulsory'], $data['funkoName']);
        } else if (isComicProcessing()) {
            array_push($dataDic['compulsory'], $data['title'], $data['author'], $data['language']);
            $dataDic['date'] = [$data['publishDate']];
            $dataDic['isbn'] = [$data['isbn']];
        }

        list($tmp, $msg) = validateInput($rules, $dataDic);
        redirect("Errore validazione " . $msg, !$tmp);

        $tmp = $tmp && validateCategory($data) && 
            (isFunkoProcessing() ? true : validatePublisher($data)) && 
            validateDiscountedPrice($data);
        redirect("Errore validazione", !$tmp);
    }

    function insertCategory(){
        global $dbh, $data;
        // check consistency
        if (empty($data['category'])) {
            $res = $dbh->addCategory($data['categoryName'], $data['categoryDesc']);
            checkErrors($res, 'Categoria');
            $data['category'] = $data['categoryName'];
        }
    }

    function insertPublisher() {
        global $dbh, $data;
        // check consistency
        if (empty($data['publisher'])) {
            list($result, $msg) = uploadImage(UPLOAD_DIR_PUBLISHERS, $_FILES["publisherLogo"]);
            redirect($msg, !$result);
            list($res, $id) = $dbh->addPublisher($data['publisherName'], $msg);
            checkErrors($res, 'Editore');
            $data['publisher'] = $id;
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
            $data['isbn'], $data['publisher'], $data['price'], $data['discountedPrice'], $data['desc'], 
            $coverImg, $data['category']);
    }

    function updateFunko($data) {
        global $dbh;
        return $dbh->updateFunko($data['productId'], $data['funkoName'], $data['price'],  
            $data['discountedPrice'], $data['desc'], $data['category']);
    }

    function updateComic($data) {
        global $dbh;
        return $dbh->updateComic($data['productId'], $data['title'], $data['author'], $data['language'], 
            $data['publishDate'], $data['isbn'], $data['publisher'], $data['price'], $data['discountedPrice'], 
            $data['desc'], $data['category']);
    }

    /**
     * Puts in an associative array all the inputs inserted in the form.
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
        // TODO
    }

    if ($_POST['action'] === 'insert') {
        list($result, $msg) = uploadImage(UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
        redirect($msg, !$result);
        $coverImg = $msg;
    } 

    insertCategory($data);
    if (isFunkoProcessing()) {
        $res = ($_POST['action'] === 'insert' ? insertFunko($data, $coverImg) : updateFunko($data));
    } else if (isComicProcessing()) {
        insertPublisher($data);
        $res = ($_POST['action'] === 'insert' ? insertComic($data, $coverImg) : updateComic($data));
    }
    checkErrors($res, 'Prodotto');
    $res = [];
    $res['success'] = 'ok';
    echo json_encode($res);
    exit(0);
?>