<?php

    use Respect\Validation\Exceptions\NestedValidationException;
    global $dbh;

    define("MYSQLI_CODE_DUPLICATE_KEY", 1062);
    define("MAX_LOGIN_ATTEMPTS", 5);

    const COOKIE_SOURCE = 0;
    const DB_SOURCE = 1;

    /**
     * Implements a secure session_start() function.
     * @return void
     */
    function secureSessionStart(){
        $sessionName = 'secSessionId';
        $secure = true;     // true => https
        $httponly = true;   // Prevent a javascript to access the session id
        ini_set('session.use_only_cookied', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        session_name($sessionName);
        session_start();
        session_regenerate_id();
    }

    /**
     * Logout the current user. Redirect to the home.
     * @return void
     */
    function logout() {
        $_SESSION = array();    // delete all session values
        session_destroy();      // destroy the session
        // delete actual cookies
        // $params = session_get_cookie_params();
        // setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        header('Location: ./');
    }

    /**
     * Check if an user **BOTH CUSTOMER OR SELLER** is logged in.
     * @return boolean true if a user is logged, false otherwise
     */
    function isUserLoggedIn() {
        return !empty($_SESSION['userId']);
    }

    /**
     * Check if a customer is logged in.
     * @return boolean true if a customer is logged, false otherwise
     */
    function isCustomerLoggedIn() {
        global $dbh;
        return isUserLoggedIn() && $dbh->isCustomer($_SESSION['userId']);
    }

    /**
     * Check if a seller is logged in.
     * @return boolean true if a seller is logged, false otherwise
     */
    function isSellerLoggedIn() {
        global $dbh;
        return isUserLoggedIn() && !$dbh->isCustomer($_SESSION['userId']);
    }

    function getIdFromName($name){
        return preg_replace("/[^a-z]/", '', strtolower($name));
    }
    
    function validateInput($rules, $data) {
        foreach($data as $rule => $attributes) {
            foreach($attributes as $attr) {
                try {
                    $rules[$rule]->assert($attr);
                } catch (NestedValidationException $exc) {
                    return array(false, implode(", ", $exc->getMessages()));
                }
            }
        }
        return array(true, '');
    }
    
    /**
     * Move the given image inside the path.
     * [NOTE] Please, remember `$path` MUST have all permissions.
     * @param string $path the folder in which move the image
     * @param string $image the image to move
     * @return array in the first pos 1 if ok, 0 otherwise, in the second the error msg if any
     */
    function uploadImage($path, $image){
        $imageName = basename($image["name"]);
        $fullPath = $path.$imageName;
        
        $maxKB = 500;
        $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
        $result = 0;
        $msg = "";
        //Controllo se immagine è veramente un'immagine
        $imageSize = getimagesize($image["tmp_name"]);
        if($imageSize === false) {
            $msg .= "File caricato non è un'immagine! ";
        }
        //Controllo dimensione dell'immagine < 500KB
        if ($image["size"] > $maxKB * 1024) {
            $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
        }
    
        //Controllo estensione del file
        $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
        if(!in_array($imageFileType, $acceptedExtensions)){
            $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
        }
    
        //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
        if (file_exists($fullPath)) {
            $i = 1;
            do{
                $i++;
                $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME)."_$i.".$imageFileType;
            }
            while(file_exists($path.$imageName));
            $fullPath = $path.$imageName;
        }
    
        //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
        if(strlen($msg)==0){
            if(!move_uploaded_file($image["tmp_name"], $fullPath)){
                $msg.= "Errore nel caricamento dell'immagine.";
            }
            else{
                $result = 1;
                $msg = $imageName;
            }
        }
        return array($result, $msg);
    }
    /**
     * Append isFavourite param to associative array of products/comics/funko,
     * if customer is logged-in and has product in favourite list return true then false,
     * if customer is not logged are used cookiess
     * @param $prods associative array where add to each element favourite flag
     * @param $dbh Database hepler, in order to call mehtod that check each product
     * @return associative Associative array like the input one $prods but each element has boolean value
     * to know if is a favourite product
     */
    function addIsFavouriteInfo($prods,$dbh){
        $allProd = $prods;
        for($i=0; $i < count($prods);$i++){
            $allProd[$i]["isFavourite"] = isProdFavourite($dbh,$allProd[$i]['ProductId']);
        }
        return $allProd;
    }

    /**
     * That method tell you if product is a customer's favourite one, it is considered both cases:
     * Customer is logged and customer isn't logged but cookie are setted
     * @param DatabaseHelper $dbh Database helper object to check on db if customer is logged
     * @param int $idProd Porduct id to be checked if in customer's favourites
     * @return boolean True if in db or cookie $idProd is present
     */
    function isProdFavourite($dbh,$idProd){
        if(isCustomerLoggedIn()){
            return $dbh -> isFavourite($_SESSION['userId'],$idProd);
        }
        else if(!isCustomerLoggedIn() && isset($_COOKIE['favs'])){
            $favs = json_decode(stripslashes($_COOKIE['favs']), true);
            return in_array(strval($idProd), $favs);
        }
        else return false;
    }

    /**
     * Append quantity info to $prodsIdcart cart saved in cookie or db
     * @param array $prodsIdCart associative array with all prods id in customer's cart
     * @param int $dataTypeSource datatype of source where are from $prodsIdcart datas
     */
    function getInfoProdsInCart($prodsIdCart,$dataTypeSource){
        global $dbh;
        $prods = array();
        foreach($prodsIdCart as $prod){
            if($dataTypeSource == COOKIE_SOURCE){
                $elem = $dbh -> getProduct($prod[0]);
                $elem["Quantity"] = $prod[1];
                array_push($prods,$elem);
            }
            else if($dataTypeSource == DB_SOURCE){
                $elem = $dbh -> getProduct($prod['ProductId']);
                $elem['Quantity'] = $prod['Quantity'];
                array_push($prods,$elem);
            }
        }
        return $prods;
    }

    /**
     * return products in customer's cart if logged-in else return cookie-cart
     * @param int $limit if is need not all cart list
     * @return array associative array containing products ()
     */
    function getCart(){
        global $dbh;
        if(isCustomerLoggedIn()){
            return getInfoProdsInCart($dbh->getUserCart($_SESSION['userId']),DB_SOURCE);
        }
        else if(isset($_COOKIE['cart'])){
            return getInfoProdsInCart(json_decode($_COOKIE['cart']),COOKIE_SOURCE);
        }
    }

    /**
     * Converts the given price in comma-notation (es. 10,91 instead of 10.91).
     * @param float $price the price in dot-notation
     * @return array|string|string[] the price in comma-notation
     */
    function formatPrice($price) {
        return str_replace(".", ",", $price);
    }

?>