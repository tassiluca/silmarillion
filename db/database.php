<?php

    class DatabaseHelper {
        private $db;
        private $MYSQLI_CODE_DUPLICATE_KEY = 1062;

        public function __construct($servername, $username, $password, $dbname, $port) {
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        /**
         * Get customer infos.
         * @param string $username the username string
         * @return void an associative array with all data
         */
        public function getCustomerData($username) {
            $query = "SELECT U.*
                      FROM Users AS U, Customers AS C
                      WHERE C.UserId = U.UserId
                      AND U.Username = ?
                      AND U.IsActive = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get seller infos.
         * @param string $username the username string
         * @return array an associative array with all data
         */
        public function getSellerData($username) {
            $query = "SELECT U.*
                      FROM Users AS U, Sellers AS S
                      WHERE S.UserId = U.UserId
                      AND U.Username = ?
                      AND U.IsActive = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get the number of failed login attempts made by an user
         * in the last period of time.
         * @param int $userId the user id
         * @param int $validAttempts the lower bound of time to check attempts
         * @return int the number of attempts between [validAttempts, now]
         */
        public function getLoginAttempts($userId, $validAttempts) {
            /* Please note validAttempts is generated from the system. */
            $query = "SELECT TimeLog
                      FROM LoginAttempts 
                      WHERE UserId = ?
                      AND TimeLog > '$validAttempts'";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->num_rows;
        }

        /**
         * Insert into table `LoginAttempts` a new failed login attempt.
         * @param int $userId the user id
         * @param int $time timestamp of attempt
         * @return bool true on success or false on failure.
         */
        public function registerNewLoginAttempt($userId, $time) {
            $query = "INSERT INTO LoginAttempts(UserId, TimeLog)
                      VALUES(?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $userId, $time);
            return $stmt->execute();
        }

        /**
         * Insert into table `Users` a new user.
         * @param string $username the username
         * @param string $password the password
         * @param string $salt the salt
         * @param string $name the name
         * @param string $surname the surname
         * @param string $birthday the birth date 
         * @param string $mail the e-mail
         * @return int the UserId associated with the just inserted user
         */
        private function addUser($username, $password, $salt, $name, $surname, $birthday, $mail) {
            $query = "INSERT INTO Users(Username, Password, Salt, Name, Surname, DateBirth, Mail, IsActive)
                      VALUES(?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssssss', $username, $password, $salt, $name, $surname, $birthday, $mail);
            try {
                $res = $stmt->execute();
            } catch(Exception $e) {
                // if a user with given username already exists in db
                if ($e->getCode() == $this->MYSQLI_CODE_DUPLICATE_KEY) {
                    return -1;
                }
            }
            return $stmt->insert_id;
        }

        /**
         * Insert into table `Customers` a new customer user. 
         * [IMPORTANT] The user given in input must be present into the `Users` table!
         * @param int $userId the user
         * @return Array the success element a `boolean` to describe success or failure,
         * the second a `boolean` to describe if there was duplicateKey error.
         */
        public function addCustomer($username, $password, $salt, $name, $surname, $birthday, $mail) {
            // `res` contains the UserId associated with the just inserted user or -1 if there was an error.
            $res = $this->addUser($username, $password, $salt, $name, $surname, $birthday, $mail);
            if ($res != -1) {
                $query = "INSERT INTO Customers(UserId)
                          VALUES(?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $res);
                return array('success' => $stmt->execute(), 'duplicateKey' => false);
            } else {
                return array('success' => false, 'duplicateKey' => true);
            }
        }

        /**
         * Checks if the user given in input is a customer or not.
         * @param int $userId the user id
         * @return boolean true if is a customer, false otherwise
         */
        public function isCustomer($userId) {
            $query = "SELECT Customers.UserId
                      FROM Customers
                      WHERE UserId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->num_rows > 0;
        }

//---------------------------HOMEPAGE------------------------------//
        public function getHomeBanner(){
            $query = "SELECT NewsId, Title, Description, Img, UserId
                    FROM News";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getNewArrival($n=15){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName
                    FROM Comics as C, Products as P
                    WHERE C.ProductId = P.ProductId
                    ORDER BY C.PublishDate DESC
                    LIMIT ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $n);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getComicsOfCategory($category){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName
                    FROM Comics as C, Products as P
                    WHERE C.ProductId = P.ProductId
                    AND P.CategoryName = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $category);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getReviews(){
            $query = "SELECT ReviewId,Vote,Description, R.UserId,U.Username
                    FROM Reviews as R, Users as U
                    WHERE R.UserId = U.UserId";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPartners(){
            $query = "SELECT `PublisherId`, `Name`, `ImgLogo`
                    FROM Publisher";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getProductById($id){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName,PB.Name as PublisherName
                    FROM Comics as C, Products as P, Publisher as PB
                    WHERE C.ProductId = P.ProductId
                    AND PB.PublisherId = C.PublisherId
                    AND P.ProductId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }


        public function addProductToWish($usrId,$idprod){
            $query = "INSERT INTO `Favourites`(`UserId`, `ProductId`) 
                        VALUES (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $usrId,$idprod);
            $stmt->execute();
            return $stmt->insert_id;
        }
        public function addProductAlert($usrId,$idprod){
            $query = "INSERT INTO `Alerts`(`UserId`, `ProductId`) 
                        VALUES (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $usrId,$idprod);
            $stmt->execute();
            return $stmt->insert_id;
        }

        //-----------------------------ADD----TO---CART------------------------------//
        public function addProductToCart($usrId,$idprod,$quantity){
            $matchInCart = $this->alreadyInCart($idprod,$usrId); //to understand if update or insert quantity in cart
            $avaiableCopies = $this -> getAvaiableCopiesOfProd($idprod); //to check if article can be added to cart

            if($avaiableCopies > 0){
                if(count($matchInCart) <= 0){ //if first time to be added in cart
                    $query = "INSERT INTO `Carts`(`ProductId`, `UserId`, `Quantity`)
                        VALUES (?,?,?)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('iii',$idprod,$usrId,$quantity);
                    $stmt->execute();
                    return $stmt->insert_id;
                }
                else{ //in case of update quantity prod in cart 
                    $quantity += $matchInCart[0]['Quantity'];
                    $query = "UPDATE Carts SET ProductId=?,UserId=?,Quantity=?";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('iii',$idprod,$usrId,$quantity);
                    $stmt->execute();
                    return $stmt->insert_id;
                }
            }
        }

        private function alreadyInCart($idProd,$usrId){ //return quantity of the idProd if present in user cart
            $query = "SELECT `ProductId`, `UserId`, `Quantity` FROM `Carts` 
                        WHERE ProductId = ? AND UserId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $idProd,$usrId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAvaiableCopiesOfProd($id){
            //article copies in users cart - not avaiable for others users
            $inCarts = $this -> getCopiesNotAvaiable($id);
            $inCarts = count($inCarts)>0? intval($inCarts[0]['total']):0;

            $copiesInStock = count($this -> getCopiesInStock($id));
            return $copiesInStock - $inCarts;
        }

        private function getCopiesInStock($id){
            $query = "SELECT `CopyId`, `ProductId` FROM `ProductCopies` WHERE ProductId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        private function getCopiesNotAvaiable($id){
            $query = "SELECT ProductId,sum(Quantity) as total
                        FROM Carts
                        where ProductId = ?
                        group by `ProductId`";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

//-----------------------CATALOG-----------------------------//
        public function getLanguages(){
            return $this -> getListOfFromComics('Lang');
        }

        public function getAllAuthors(){
            return $this -> getListOfFromComics('Author');
        }

        private function getListOfFromComics($attribute){ //NOTE: be sure the param is an attributo of Comics
            $query = "SELECT ".$attribute." FROM Comics Group by ". $attribute;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAllCategories(){
            $query = "SELECT * FROM `Categories`";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
//---------------------------------------------------
        public function getAllComics($query){
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
        }

    }
    
?>