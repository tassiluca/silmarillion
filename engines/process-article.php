<?php 
    require_once '../bootstrap.php';
    /** @var DatabaseHelper $dbh */
    use Respect\Validation\Validator as v;

    /**
     * Returns if the processing involves a funko.
     * @return boolean true if the user is processing a funko, false otherwise.
     */
    function isFunkoProcessing() {
        global $data;
        return $data["article"] === "funko";
    }

    /**
     * Returns if the processing involves a comic.
     * @return boolean true if the user is processing a comic, false otherwise.
     */
    function isComicProcessing() {
        global $data;
        return $data["article"] === "comic";
    }

    /**
     * Send to the client a message.
     * @param string $msgType the type of the message, generally success or error
     * @param string $msg the message to send
     */
    function redirect($msgType, $msg) {
        $res[$msgType] = $msg;
        echo json_encode($res);
    }

    /**
     * Send to the client a message error if a given condition is true.
     * [NOTE] This function terminate the current script.
     * @param string $msg the message to send
     * @param boolean $condError teh condition to evaluate
     */
    function redirectOnFailure($msg, $condError = true) {
        if ($condError) {
            redirect('error', $msg);
            exit(1);
        }
    }

    /**
     * Send to the client a message of success if a given condition is true.
     * [NOTE] This function terminate the current script.
     * @param string $msg the message to send
     * @param boolean $condError teh condition to evaluate
     */
    function redirectOnSuccess($msg, $condSuccess = true) {
        if ($condSuccess) {
            redirect('success', $msg);
            exit(0);
        }
    }

    /**
     * Checks if some db errors occurred.
     * @param int $error the error variable
     * @param string $initMsg the field which generates the error
     */
    function checkErrors($error, $initMsg) {
        redirectOnFailure(($error === MYSQLI_CODE_DUPLICATE_KEY ? 
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
        return empty($data['discountedPrice']) || $data['discountedPrice'] < $data['price'];
    }

    /**
     * Validates input.
     * @param array $data an associative array with all data to validate
     */
    function validate($data) {
        $rules = array (
            'compulsory'        => v::stringType()->notEmpty(),
            'date'              => v::date()->notEmpty(),
            'isbn'              => v::numericVal()->length(13, 13),
            'price'             => v::numericVal()->not(v::negative())->notEmpty(),
            'discountedPrice'   => v::not(v::numericVal()->negative()),
            'quantity'          => v::intVal()->not(v::negative())
        );

        $dataDic = array (
            'compulsory' => [$data['desc']],
            'price' => [$data['price']],
            'discountedPrice' => [$data['discountedPrice']],
            'quantity' => [$data['quantity']]
        );

        if (isFunkoProcessing()) {
            $dataDic['compulsory'][] = $data['funkoName'];
        } else if (isComicProcessing()) {
            array_push($dataDic['compulsory'], $data['title'], $data['author'], $data['language']);
            $dataDic['date'] = [$data['publishDate']];
            $dataDic['isbn'] = [$data['isbn']];
        }

        list($tmp, $msg) = validateInput($rules, $dataDic);
        $tmp = $tmp && validateCategory($data) && 
            (isFunkoProcessing() || validatePublisher($data)) &&
            validateDiscountedPrice($data);
        redirectOnFailure("Errore inserimento dati. Ricontrolla i campi! " . $msg, !$tmp);
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
            list($result, $msg) = uploadImage("../" . UPLOAD_DIR_PUBLISHERS, $_FILES["publisherLogo"]);
            redirectOnFailure($msg, !$result);
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

    if ($data['action'] === 'delete') {
        if (isFunkoProcessing()) {
            $dbh->deleteFunko($data['productId']);
        } else if (isComicProcessing()) {
            $dbh->deleteComic($data['productId']);
        }
        $dbh->deleteProductCopies($data['productId']);
        header('location: manage-articles.php');
    }

    validate($data);
    if ($data['action'] === 'insert') {
        list($result, $msg) = uploadImage("../" . UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
        redirectOnFailure($msg, !$result);
        $coverImg = $msg;
    } 

    insertCategory();
    if (isFunkoProcessing()) {
        if ($data['action'] === 'insert') {
            list($res, $data['productId']) = insertFunko($data, $coverImg);
        } else {
            $res = updateFunko($data);
        }
    } else if (isComicProcessing()) {
        insertPublisher($data);
        if ($data['action'] === 'insert') {
            list($res, $data['productId']) = insertComic($data, $coverImg);
        } else {
            $res = updateComic($data);
        }
    }
    checkErrors($res, 'Prodotto');

    $actualQuantity = $dbh->getAvaiableCopiesOfProd($data['productId']);
    if ($data['quantity'] - $actualQuantity > 0) { // if the user added new product copies insert them
        for ($i = 0; $i < $data['quantity'] - $actualQuantity; $i++) {
            $dbh->addProductCopy($data['productId']);
        }
    } else if ($data['quantity'] - $actualQuantity < 0) { // if the user has deleted some copies
        $dbh->deleteProductCopies($data['productId'], $actualQuantity - $data['quantity']);
    }

    redirectOnSuccess("Operazione avvenuta con successo");
?>