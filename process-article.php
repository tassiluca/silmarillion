<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once './bootstrap.php';
    // require_once __DIR__ . '/vendor/autoload.php';
    use Respect\Validation\Validator as v;

    /** 
     * [NOTES] Expecting these params:
     * - articleToInsert: could be only Fumetto or Funk (TODO: change Fumetto in Comic)
     * - (ok) funkoName: non-empty
     * - (ok) title: non-empty
     * - (ok) author: non-empty
     * - (ok) language: non-empty
     * - (ok) publishDate: must be a date
     * - (ok) isbn: must be an integer of 13 digits
     * - (ok) publisher: non-empty
     * - (ok) publisherName, publisherLogo: non-empty
     * - (ok) category: non-empty
     * - (ok) categoryName, categoryDesc: non-empty
     * - (ok) price, discountedPrice: must be a price non-negative
     * - (ok) desc: non-empty
     * - (ok) coverImg: non-empty
     */

    function isFunkoInsertion() {
        return $_POST["articleToInsert"] == "Funko";
    }

    function isComicInsertion() {
        return $_POST["articleToInsert"] == "Fumetto";
    }

    function validate($data) {
        if (isFunkoInsertion()) {
            // validate funko fields
        } else if (isComicInsertion()) {
            // validate comic fields
        }
    }

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
            header("location: modify-article.php?action=insert&formMsg=" . $msg);
            exit(1);
        }
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

    // list($result, $msg) = uploadImage(UPLOAD_DIR_PRODUCTS, $_FILES["coverImg"]);
    // redirect($msg, !$result);
    // $coverImg = $msg;

    // insertCategory($data);

    // if (isFunkoInsertion()) { // funko insert
    //     // insert into db
    //     $res = $dbh->addFunko($data['funkoName'], $data['price'], $data['discountedPrice'], 
    //                           $data['desc'], $coverImg, $data['category']);
    //     $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
    // } else if (isComicInsertion()) { // comic insert
    //     insertPublisher($data);
    //     // insert into db
    //     $res = $dbh->addComic($data['title'], $data['author'], $data['language'], $data['publishDate'], 
    //                           $data['isbn'], $data['publisher'], $data['price'], 
    //                           $data['discountedPrice'], $data['desc'], $coverImg, $data['category']);
    //     $msg = $res ? "Inserimento completato correttamente" : "Errore in inserimento";
    // }
    
    // redirect($msg);
    
?>