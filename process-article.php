<?php 
    require_once './bootstrap.php';
    use Respect\Validation\Validator as v;

    /**
     * Returns if the processing involves a funko.
     * @return boolean true if the user is processing a funko, false otherwise.
     */
    function isFunkoProcessing() {
        return $_POST["article"] === "funko";
    }

    /**
     * Returns if the processing involves a comic.
     * @return boolean true if the user is processing a comic, false otherwise.
     */
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

    /**
     * Checks if some db errors occurred.
     * @param int $error the error variable
     * @param string $initMsg the field which generates the error
     */
    function checkErrors($error, $initMsg) {
        redirect(($error === MYSQLI_CODE_DUPLICATE_KEY ? 
            $initMsg . " già presente nel Data Base!" : 
            "Si è verificato un errore imprevisto (Codice " . $error . ")"), $error);
    }

    /**
     * Validates the category inserted:
     * - if the category is selected from the select menu, its name and description fields must be empty
     * - if the category is not selected from the select menu, its name and description must be present
     * @param array $data an associative array with all data to validate
     */
    function validateCategory($data) {
        return (empty($data['category']) && !empty($data['categoryName']) && !empty($data['categoryDesc'])) ||
            (!empty($data['category']) && empty($data['categoryName']) && empty($data['categoryDesc']));
    }

    /**
     * Validates the publisher inserted:
     * - if the publisher is selected from the select menu, his name and logo must be empty
     * - if the publisher is not selected from the select menu, his name and description must be present
     * @param array $data an associative array with all data to validate
     */
    function validatePublisher($data) {
        return isFunkoProcessing() ||
            (empty($data['publisher']) && !empty($data['publisherName']) && !$_FILES['publisherLogo']['error']) ||
            (!empty($data['publisher']) && empty($data['publisherName']) && $_FILES['publisherLogo']['error']);
    }

    /**
     * Validates the discounted price: if is present must be lower than price.
     * @param array $data an associative array with all data to validate
     */
    function validateDiscountedPrice($data) {
        return empty($data['discountedPrice']) || 
            (!empty($data['discountedPrice']) && $data['discountedPrice'] < $data['price']);
    }

    /**
     * Validates input.
     * @param array $data an associative array with all data to validate
     */
    function validate($data) {
        $rules = array (
            'compulsory'        => v::stringType()->notEmpty(),
            'date'              => v::date()->notEmpty(),
            'isbn'              => v::stringType()->length(13, 13),
            'price'             => v::numericVal()->not(v::negative())->notEmpty(),
            'discountedPrice'   => v::not(v::numericVal()->negative()),
            'quantity'          => v::intVal()->not(v::negative())->notEmpty()
        );

        $dataDic = array (
            'compulsory' => [$data['desc']],
            'price' => [$data['price']],
            'discountedPrice' => [$data['discountedPrice']],
            'quantity' => [$data['quantity']]
        );

        if (isFunkoProcessing()) {
            array_push($dataDic['compulsory'], $data['funkoName']);
        } else if (isComicProcessing()) {
            array_push($dataDic['compulsory'], $data['title'], $data['author'], $data['language']);
            $dataDic['date'] = [$data['publishDate']];
            $dataDic['isbn'] = [$data['isbn']];
        }

        list($tmp, $msg) = validateInput($rules, $dataDic);
        $tmp = $tmp && validateCategory($data) && 
            (isFunkoProcessing() ? true : validatePublisher($data)) && 
            validateDiscountedPrice($data);
        redirect("Errore inserimento dati. Ricontrolla i campi!", !$tmp);
    }

    /**
     * Inserts a new category into the database if the category select input is empty. 
     */
    function insertCategory(){
        global $dbh, $data;
        // check consistency
        if (empty($data['category'])) {
            $res = $dbh->addCategory($data['categoryName'], $data['categoryDesc']);
            checkErrors($res, 'Categoria');
            $data['category'] = $data['categoryName'];
        }
    }

    /**
     * Inserts a new publisher into the database if the publisher select input is empty.
     */
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

    /**
     * Inserts a new funko into the database.
     */
    function insertFunko($data, $coverImg) {
        global $dbh;
        return $dbh->addFunko($data['funkoName'], $data['price'], $data['discountedPrice'], 
            $data['desc'], $coverImg, $data['category']);
    }

    /**
     * Inserts a new comic into the database.
     */
    function insertComic($data, $coverImg) {
        global $dbh;
        return $dbh->addComic($data['title'], $data['author'], $data['language'], $data['publishDate'], 
            $data['isbn'], $data['publisher'], $data['price'], $data['discountedPrice'], $data['desc'], 
            $coverImg, $data['category']);
    }

    /**
     * Updates the funko into the database.
     * @param array $data the array with all funkos data.
     */
    function updateFunko($data) {
        global $dbh;
        return $dbh->updateFunko($data['productId'], $data['funkoName'], $data['price'],  
            $data['discountedPrice'], $data['desc'], $data['category']);
    }

    /**
     * Updates the comic into the database.
     * @param array $data the array with all comic data.
     */
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

    for ($i = 0; $i < $data['quantity'] - $dbh->getAvaiableCopiesOfProd($data['productId']); $i++) {
        $dbh->addProductCopy($data['productId']);
    }

    $res = [];
    $res['success'] = 'ok';
    echo json_encode($res);
    exit(0);
?>