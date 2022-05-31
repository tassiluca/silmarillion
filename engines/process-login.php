<?php
    require_once '../bootstrap.php';
    /** @var DatabaseHelper $dbh */

    /** Max number of login wrong attempts before the system imposes a pause. */
    const MAX_LOGIN_ATTEMPTS = 5;
    /** Minutes which must pass after MAX_LOGIN_ATTEMPTS wrong attempts in order to consider a new one. */
    const STOP_TIME_MIN = 5;
    const FORCING_MSG = "Mhhh... Si sono verificati troppi tentativi. Aspetta " . STOP_TIME_MIN . " minuti!";
    const ERROR_MSG = "Login fallito: ricontrolla i campi!";

    /* customer login */
    if (isset($_POST['customerUsr']) && isset($_POST['customerPwd'])) {
        $userData = $dbh->getCustomerData($_POST['customerUsr']);
        echo json_encode(login($userData, $_POST['customerPwd']));
    }

    /* seller login */
    if (isset($_POST['sellerUsr']) && isset($_POST['sellerPwd'])) {
        $userData = $dbh->getSellerData($_POST['sellerUsr']);
        echo json_encode(login($userData, $_POST['sellerPwd']));
    }

    /**
     * Make a new login attempt.
     * @param Array $userData an associative array with all user data
     * @param string $password the hashed password to compare
     * @return Array of errors
     */
    function login($userData, $password) {
        global $dbh;
        $result = [];
        if (count($userData)) { // user exists
            $userData = $userData[0];
            if (checkbrute($userData['UserId'])) {
                $result["error"] = FORCING_MSG;
            } else {
                $password = hash('sha512', $password . $userData['Salt']);
                if ($userData['Password'] == $password) {
                    registerLoggedUser($userData);
                    moveCookieDataToDb();
                } else {
                    $dbh->registerNewLoginAttempt($userData['UserId'], time());
                    $result["error"] = ERROR_MSG;
                }
            }
        } else {
            $result["error"] = ERROR_MSG;
        }
        return $result;
    }

    /**
     * Prevents brute force attacks.
     * @param int $userId the user id
     * @return boolean true if in the last period there have been several failed login attempts
     */
    function checkbrute($userId) {
        global $dbh;
        $now = time();
        $validAttempts = $now - (STOP_TIME_MIN * 60);
        return $dbh->getLoginAttempts($userId, $validAttempts) >= MAX_LOGIN_ATTEMPTS;
    }

    /**
     * Register a new logged user into the session variable.
     * @param Array $userData an associative array with all user data
     * @return void
     */
    function registerLoggedUser($userData) {
        $_SESSION['userId'] = $userData['UserId'];
        $_SESSION['username'] = $userData['Username'];
        $_SESSION['name'] = $userData['Name'];
        $_SESSION['surname'] = $userData['Surname'];
        $_SESSION['datebirth'] = $userData['DateBirth'];
        $_SESSION['mail'] = $userData['Mail'];
    }

    /**
     * Move favorite and in-cart products from cookie to customer profile in database
     * The insertion of prods in cart/wishlist from cookie to db could return an error from db
     * but is not handled here actually, maybe in the next version
     */
    function moveCookieDataToDb(){
        global $dbh;
        if (isCustomerLoggedIn()) {
            $cookieCart = isset($_COOKIE["cart"]) ? json_decode(stripslashes($_COOKIE["cart"]), true) : [];
            $cookieFav  = isset($_COOKIE["favs"]) ? json_decode(stripslashes($_COOKIE['favs']), true) : [];
            $customerId = $_SESSION["userId"];
            
            foreach ($cookieFav as $prodId) {
                if (!isProdFavourite($dbh,$prodId)) {
                    $dbh->addProductToWish($customerId,$prodId);
                }
            }
            
            foreach($cookieCart as $prod) {
                $dbh->insertProdCart($customerId, $prod[0], $prod[1]);
            }
        }
    }

?>