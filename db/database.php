<?php

    class DatabaseHelper {
        private $db;

        public function __construct($servername, $username, $password, $dbname, $port) {
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        /**
         * Get correct string containing a sequence of char thats rappresent parameters types to be binded
         * @param Array $parameters array of alla parameters to be binded in query sql
         * @return string Sequence of types of passed params $parameters
         */
        function getSqlStringType($parameters){
            $sequenceTypes = '';
            foreach(array_values($parameters) as $param) {
                if(is_int($param)){
                    $sequenceTypes .= 'i';
                }
                else if(is_double($param)){
                    $sequenceTypes .= 'd';
                }
                else if(is_string($param)){
                    $sequenceTypes .= 's';
                }
                else {
                    $sequenceTypes .= 'b';
                }
            }
            return $sequenceTypes;
        }

        /**
         * A common function to prepare, bind and execute a query.
         * @param string $query the query to be executed
         * @param array $parameters an associative array like [valueType => value].
         * An example: ['i' => 10, 's' => 'Hello World', ...]
         * @return false|mysqli_stmt the statement in order to do other staff like `get_results` and so on...
         */
        private function executeQuery($query, $parameters = []) {
            $stmt = $this->db->prepare($query);
            // bind the parameters in the query if necessary
            if (!empty($parameters)){
                $types = $this->getSqlStringType($parameters);
                $values = array_values($parameters);
                $stmt->bind_param($types, ...$values);
            }
            // execute the query
            $stmt->execute();
            return $stmt;
        }

        /**********************************************************************************
         * Users management functions
         **********************************************************************************/
        /**
         * Get customer infos.
         * @param string $username the username string
         * @return array an associative array with all data.
         */
        public function getCustomerData($username) {
            $query = "SELECT U.*
                      FROM Users AS U, Customers AS C
                      WHERE C.UserId = U.UserId
                      AND U.Username = ?
                      AND U.IsActive = 1";
            return $this->executeQuery($query, [$username])
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get customer infos.
         * @param string $mail the mail
         * @return array an associative array with all data.
         */
        public function getCustomerDataByMail($mail) {
            $query = "SELECT U.*
                      FROM Users AS U, Customers AS C
                      WHERE C.UserId = U.UserId
                      AND U.Mail = ?
                      AND U.IsActive = 1";
            return $this->executeQuery($query, [$mail])
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Reset the user password.
         * @param int $userId the user id
         * @param string $password the new password
         * @param string $salt the new salt
         */
        public function resetUserPassword($userId, $password, $salt) {
            $query = "UPDATE Users
                      SET Password = ?, Salt = ?
                      WHERE UserId = ?";
            $this->executeQuery($query, [$password, $salt, $userId]);
        }

        /**
         * Get seller infos.
         * @param string $username the username string
         * @return array an associative array with all data.
         */
        public function getSellerData($username) {
            $query = "SELECT U.*
                      FROM Users AS U, Sellers AS S
                      WHERE S.UserId = U.UserId
                      AND U.Username = ?
                      AND U.IsActive = 1";
            return $this->executeQuery($query, [$username])
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
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
            return $this->executeQuery($query, [$userId])
                ->get_result()
                ->num_rows;
        }

        /**
         * Insert into table `LoginAttempts` a new failed login attempt.
         * @param int $userId the user id
         * @param int $time timestamp of attempt
         */
        public function registerNewLoginAttempt($userId, $time) {
            $query = "INSERT INTO LoginAttempts(UserId, TimeLog)
                      VALUES(?, ?)";
            $this->executeQuery($query, [$userId, $time]);
        }

        /**
         * Insert into table `Users` a new user.
         * @param string $username the username
         * @param string $password the password
         * @param string $salt the salt
         * @param string $name the user name
         * @param string $surname the user surname
         * @param string $birthday the birth date 
         * @param string $mail the e-mail
         * @return array in the first position a `boolean` to describe if occurred some errors, in the second
         * the inserted user id if no errors occurred, the error code otherwise.
         */
        private function addUser($username, $password, $salt, $name, $surname, $birthday, $mail) {
            $query = "INSERT INTO Users(Username, Password, Salt, Name, Surname, DateBirth, Mail, IsActive)
                      VALUES(?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->executeQuery($query, [$username, $password, $salt, $name, $surname, $birthday, $mail]);
            if ($stmt->errno != 0) {
                return array(false, $stmt->errno);
            }
            return array(true, $stmt->insert_id);
        }

        /**
         * Insert into table `Customers` a new customer user. 
         * [NOTE] An error occured during the insertion of a new customer determine no insert into the 
         * `Customers` table BUT the corresponding user have been already inserted!
         * @param string $username the username
         * @param string $password the password
         * @param string $salt the salt
         * @param string $name the customer name
         * @param string $surname the customer surname
         * @param string $birthday the birth date
         * @param string $mail the e-mail
         * @return int describing the error occurred or 0 if no error occurred.
         */
        public function addCustomer($username, $password, $salt, $name, $surname, $birthday, $mail) {
            list($res, $msg) = $this->addUser($username, $password, $salt, $name, $surname, $birthday, $mail);
            if ($res === true) {
                $query = "INSERT INTO Customers(UserId)
                          VALUES(?)";
                return $this->executeQuery($query, [$msg])->errno;
            } else {
                return $msg;
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
            return $this->executeQuery($query, [$userId])
                ->get_result()
                ->num_rows > 0;
        }

        /**********************************************************************************
         * Products management functions
         **********************************************************************************/

        /**
         * Get product info, regardless if the product is a funko or comic.
         * @param integer $productId the product id
         * @return array an associative array with all data.
         */
        public function getProduct(int $productId) {
            if ($this->isFunko($productId)) {
                return $this->getFunkoById($productId);
            } else {
                return $this->getComicById($productId);
            }
        }

        /**
         * Insert a new product.
         * @param double $price the price of the product
         * @param double $discountedPrice the discounted price of the product
         * @param string $desc the product description
         * @param string $img the product image
         * @param string $category the product category
         * @return int the id of the product just inserted
         */
        private function addProduct($price, $discountedPrice, $desc, $img, $category) {
            $query = "INSERT INTO Products(Price, DiscountedPrice, Description, CoverImg, CategoryName)
                      VALUES(?, ?, ?, ?, ?)";
            $discountedPrice = empty($discountedPrice) ? NULL : $discountedPrice;
            return $this->executeQuery($query, [$price, $discountedPrice, $desc, $img, $category])
                        ->insert_id;
        }

        /**
         * Insert a new funko.
         * [NOTE] An error occured during the insertion of a new funko determine no insert into the 
         * `Funkos` table BUT the corresponding product have been already inserted.
         * @param string $name the funko name
         * @param string $price the funko price
         * @param string $discountedPrice the funko discounted price
         * @param string $desc the funko description
         * @param string $img the funko image
         * @param string $category the funko category
         * @return array in the first position the error code occurred or 0 if no error occurred and
         * in the second position the inserted id
         */
        public function addFunko($name, $price, $discountedPrice, $desc, $img, $category) {
            $productId = $this->addProduct($price, $discountedPrice, $desc, $img, $category);
            $query = "INSERT INTO Funkos(ProductId, Name)
                      VALUES(?, ?)";
            $stmt = $this->executeQuery($query, [$productId, $name]);
            return array($stmt->errno, $productId);
        }

        /**
         * Insert a new comic.
         * [NOTE] An error occured during the insertion of a new comic determine no insert into the 
         * `Funkos` table BUT the corresponding product have been already inserted.
         * @param string $title the comic title
         * @param string $author the comic author
         * @param string $lang the comic lang
         * @param string $date the comic published date
         * @param string $isbn the comic ISBN code
         * @param int $publisherId the publisher id code
         * @param string $price the comic price
         * @param string $discountedPrice the comic discounted price
         * @param string $desc the comic description
         * @param string $img the comic image
         * @param string $category the comic category
         * @return array in the first position the error code occurred or 0 if no error occurred and
         * in the second position the inserted id
         */
        public function addComic($title, $author, $lang, $date, $isbn, $publisherId, 
                                 $price, $discountedPrice, $desc, $img, $category) {
            $productId = $this->addProduct($price, $discountedPrice, $desc, $img, $category);
            $query = "INSERT INTO Comics(Title, Author, Lang, PublishDate, ISBN, ProductId, PublisherId)
                      VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->executeQuery($query, [$title, $author, $lang, $date, $isbn, $productId, $publisherId]);
            return array($stmt->errno, $productId);
        }

        /**
         * Update the product infos.
         * @param int $productId the product id to be modified
         * @param double $price the new price
         * @param double $discountedPrice the new discounted price
         * @param string $desc the new description
         * @param string $category the new category name
         * @return int describing the error occurred or 0 if no error occurred.
         */
        private function updateProduct($productId, $price, $discountedPrice, $desc, $category) {
            $query = "UPDATE Products 
                      SET Price = ?, DiscountedPrice = ?, Description = ?, CategoryName = ?
                      WHERE ProductId = ?";
            return $this->executeQuery($query, [$price, $discountedPrice, $desc, $category, $productId])->errno;
        }

        /**
         * Update the comic infos.
         * @param int $productId the product id to be modified
         * @param string $title the new title
         * @param string $author the new author
         * @param string $lang the new lang
         * @param string $date the new publishing date
         * @param string $isbn the new ISBN
         * @param int $publisherId the new publisher id
         * @param double $price the new price
         * @param double $discountedPrice the new discounted price
         * @param string $desc the new description
         * @param string $category the new category name
         * @return int describing the error occurred or 0 if no error occurred.
         */
        public function updateComic($productId, $title, $author, $lang, $date, $isbn, $publisherId, 
                                    $price, $discountedPrice, $desc, $category) {
            $query = "UPDATE Comics 
                      SET Title = ?, Author = ?, Lang = ?, PublishDate = ?, ISBN = ?, PublisherId = ?
                      WHERE ProductId = ?";
            $discountedPrice = empty($discountedPrice) ? NULL : $discountedPrice;
            $res = $this->executeQuery($query, [$title, $author, $lang, $date, $isbn, $publisherId, $productId])->errno;
            return ($res !== 0 ? $res : $this->updateProduct($productId, $price, $discountedPrice, $desc, $category));
        }

        /**
         * Update the funko infos.
         * @param int $productId the product id to be modified
         * @param string $name the new name
         * @param double $price the new price
         * @param double $discountedPrice the new discounted price
         * @param string $desc the new description
         * @param string $category the new category name
         * @return int describing the error occurred or 0 if no error occurred.
         */
        public function updateFunko($productId, $name, $price, $discountedPrice, $desc, $category) {
            $query = "UPDATE Funkos 
                      SET Name = ?
                      WHERE ProductId = ?";
            $discountedPrice = empty($discountedPrice) ? NULL : $discountedPrice;
            $res = $this->executeQuery($query, [$name, $productId])->errno;
            return ($res !== 0 ? $res : $this->updateProduct($productId, $price, $discountedPrice, $desc, $category));
        }

        /**
         * Deletes a product from `Products` table
         * @param int $productId the product id to delete
         */
        public function deleteProduct($productId) {
            $query = "DELETE FROM Products
                      WHERE ProductId = ?";
            $this->executeQuery($query, [$productId]);
        }

        /**
         * Deletes a funko from `Funkos` table
         * @param int $productId the product id to delete
         */
        public function deleteFunko($productId) {
            $query = "DELETE FROM Funkos
                      WHERE ProductId = ?";
            $this->executeQuery($query, [$productId]);
            // [NOTE] it's important the deletion of the product is done after
            // the deletion of the funko due to the foreign key between them.
            $this->deleteProduct($productId);

        }

        /**
         * Deletes a comic from `Comics` table
         * @param int $productId the product id to delete
         */
        public function deleteComic($productId) {
            $query = "DELETE FROM Comics
                      WHERE ProductId = ?";
            $this->executeQuery($query, [$productId]);
            // [NOTE] it's important the deletion of the product is done after
            // the deletion of the comic due to the foreign key between them.
            $this->deleteProduct($productId);
        }

        /**
         * Get all the categories.
         * @return array an associative array with all categories.
         */
        public function getCategories() {
            $query = "SELECT Name, Description
                      FROM Categories";
            return $this->executeQuery($query)
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get all publishers.
         * @return array an associative array with all publishers.
         */
        public function getPublishers() {
            $query = "SELECT PublisherId, Name, ImgLogo
                      FROM Publisher";
            return $this->executeQuery($query)
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Insert into db a new publisher.
         * @param string $name the publisher name
         * @param string $img the path in which it's stored the publisher logo
         * @return array in first position the error code, 0 if everything ok, and in the second
         * the inserted publisher id or null if some error occurred.
         */
        public function addPublisher($name, $img) {
            $query = "INSERT INTO Publisher(Name, ImgLogo)
                      VALUES(?, ?)";
            $stmt = $this->executeQuery($query, [$name, $img]);
            return array($stmt->errno, $stmt->errno === 0 ? $stmt->insert_id : null);   
        }

        /**
         * Insert into db a new category.
         * @param string $name the category name
         * @param string $description a short category description
         * @return int describing the error occurred or 0 if no error occurred.
         */
        public function addCategory($name, $description) {
            $query = "INSERT INTO Categories(Name, Description)
                      VALUES(?, ?)";
            return $this->executeQuery($query, [$name, $description])->errno;
        }

        public function getHomeBanner(){
            $query = "SELECT NewsId, Title, Description, Img, UserId
                    FROM News";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get newest products added to website
         * @param int $n amount of product to be loaded, default value is 15
         * @return array associative array containing new added products
         */
        public function getNewArrival($n=15){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName
                    FROM Comics as C, Products as P
                    WHERE C.ProductId = P.ProductId
                    ORDER BY C.PublishDate DESC
                    LIMIT ?";

            $stmt = $this -> executeQuery($query,[$n]);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        /**
         * Get all products of a specific category
         * @param string $category
         * @param int $quantity, max number of prods returned, default value is infinite (-1)
         * @return array associative array containing all prods of a category
         */
        public function getComicsOfCategory($category,$quantity=-1){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName
                    FROM Comics as C, Products as P
                    WHERE C.ProductId = P.ProductId
                    AND P.CategoryName = ? ";

            $params = array();
            if($quantity > 0){
                $query .= " LIMIT ?";
                $params = array($category,$quantity);
            }
            $stmt = $this -> executeQuery($query,$params);

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get `quantity` funkos
         * @param int $quantity, max number of prods returned, default value is infinite (-1)
         * @return array associative array containing all funkos
         */
        public function getFunkos($quantity = -1) {
            $query = "SELECT F.FunkoId, F.ProductId, F.Name as Title, 
                             P.Price, P.DiscountedPrice, P.Description, P.CoverImg, P.CategoryName
                      FROM  Funkos as F, Products as P
                      WHERE F.ProductId = P.ProductId";

            $params = array();
            if($quantity > 0){
                $query .= " LIMIT ?";
                $params = array($quantity);
            }
            $stmt = $this -> executeQuery($query,$params);
            
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get `quantity` comics data.
         *
         * @param integer $quantity the number of comics to get. If not specified are returned all comics.
         * @return array associative array containing the comics data
         */
        public function getComics($quantity = -1) {
            $query = "SELECT C.Title, C.Author, C.Lang, C.PublishDate, C.ISBN, C.PublisherId,
                             P.ProductId, P.Price, P.DiscountedPrice, P.Description, P.CoverImg, P.CategoryName
                      FROM  Comics C, Products P
                      WHERE C.ProductId = P.ProductId";
            
            if ($quantity > 0) {
                $query .= " LIMIT ?";
            }            
            $stmt = $this->db->prepare($query);
            if ($quantity > 0){
                $stmt->bind_param('i', $quantity);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);        
        }

        public function getProducts($offset = -1, $limit = -1, $expression = '') {
            $expression = '%' . $expression . '%';
            $query = "SELECT P.ProductId, C.Title as Title, P.CoverImg
                      FROM Products P JOIN Comics C ON P.ProductId = C.ProductId
                      WHERE C.Title LIKE ?
                      UNION 
                      SELECT P.ProductId, F.Name as Title, P.CoverImg
                      FROM Products P JOIN Funkos F ON P.ProductId = F.ProductId
                      WHERE F.Name LIKE ?";
            $params = [$expression, $expression];
            if ($offset !== -1 && $limit !== -1) {
                $query .= " LIMIT ?, ?";
                array_push($params, $offset, $limit);
            }
            return $this->executeQuery($query, $params)
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get all reviews about website
         * @return array associative array with all reviews
         */
        public function getReviews(){
            $query = "SELECT ReviewId,Vote,Description, R.UserId,U.Username
                    FROM Reviews as R, Users as U
                    WHERE R.UserId = U.UserId";
            
            $stmt = $this -> executeQuery($query,[]);
            return $stmt->get_result()
                        ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get all infos about a specific COMIC by productId
         * @param int $id unique id of product
         * @return array containig a single element, if $id is not present in db
         * array is empty
         */
        public function getComicById($id){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName,PB.Name as PublisherName
                    FROM Comics as C, Products as P, Publisher as PB
                    WHERE C.ProductId = P.ProductId
                    AND PB.PublisherId = C.PublisherId
                    AND P.ProductId = ?";

            $stmt = $this -> executeQuery($query,[$id]);
            return $stmt->get_result()
                        ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * GLIet all infos about a specific funko by ProductId
         * @param int $id unique id of product
         * @return array containing a single element, if $id is not present in db
         * array is empty
         */
        public function getFunkoById($id){
            $query = "SELECT F.FunkoId, F.ProductId, F.Name as Title, P.Price, P.DiscountedPrice, P.Description, P.CoverImg, P.CategoryName
                    FROM Funkos as F, Products as P
                    WHERE F.ProductId = P.ProductId
                    AND P.ProductId = ?";

            $stmt = $this -> executeQuery($query,[$id]);
            return $stmt->get_result()
                        ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * TODO: to document -- added by Luca
         */
        public function isFunko($id) {
            $query = "SELECT P.ProductId
                      FROM Products as P, Funkos as F
                      WHERE P.ProductId = F.ProductId
                      AND P.ProductId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->num_rows > 0;
        }

        /**
         * TODO: to document -- added by Luca
         */
        public function isComic($id) {
            $query = "SELECT P.ProductId
                      FROM Products as P, Comics as C
                      WHERE P.ProductId = C.ProductId
                      AND P.ProductId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->num_rows > 0;
        }
        //------------------------FAVOURITE/WISHLIST---------------------//
        /**
         * Get all customer's favourite products
         * @param int $usrId unique id of consumer user
         * @return array Associative array with all product-id of prods favourite to customer
         */
        public function getCustomerWishlist($usrId){
            $query = "SELECT `ProductId` FROM `Favourites` WHERE `UserId`= ?";
            $stmt = $this->db->prepare($query);

            $stmt = $this -> executeQuery($query,[$usrId]);
            return $stmt->get_result()
                        ->fetch_all(MYSQLI_ASSOC);
        }
        /**
         * Add $idprod product to the $usrId personal wish/favourite list
         * @param int $usrId unique id of consumer user
         * @param int $idprod unique id of product
         * @return boolean false if action failed, true if all done
         */
        public function addProductToWish($usrId,$idprod){
            $query = "INSERT INTO `Favourites`(`UserId`, `ProductId`) 
                        VALUES (?,?)";
            return !$this -> executeQuery($query,[$usrId,$idprod])->errno;
        }

        /**
         * Remove $idprod product to the $usrId personal wish/favourite list
         * @param int $usrId unique id of consumer user
         * @param int $idprod unique id of product
         * @return boolean false if action failed, true if all done
         */
        public function removeProductToWish($usrId,$idprod){
            $query = "DELETE FROM `Favourites` WHERE `UserId` = ? and `ProductId`= ?";
            return !$this -> executeQuery($query,[$usrId,$idprod])->errno;
        }

        //---------------------ALERT-PRODUCT-------------------//
        public function addProductAlert($usrId,$idprod){
            $query = "INSERT INTO `Alerts`(`UserId`, `ProductId`) 
                        VALUES (?,?)";
            return !$this -> executeQuery($query,[$usrId,$idprod])->errno;
        }

        public function isAlertActive($usrId,$idprodotto){
            $query = "SELECT * FROM `Alerts` WHERE `UserId` = ? AND `ProductId` = ?";
            $resultCount = count($this -> executeQuery($query,[$usrId,$idprodotto])
                         ->get_result()
                         ->fetch_all(MYSQLI_ASSOC));
            return $resultCount > 0;
        }

        public function removeAlertOnProd($usrId,$idprod){
            $query = "DELETE FROM `Alerts` WHERE `UserId` = ? and `ProductId` = ?";
            return !$this -> executeQuery($query,[$usrId,$idprod])->errno;
        }

        //-----------------------------CART------------------------------//

        public function getUserCart($customerId){
            $query = "SELECT `ProductId`, `UserId`, `Quantity` FROM `Carts` WHERE `UserId` = ?";
            return $this -> executeQuery($query,[$customerId])
                         ->get_result()
                         ->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Add $idprod product to the $usrId personal cart
         * @param int $usrId unique id of consumer user
         * @param int $idprod unique id of product
         * @return boolean false if action failed, true if all done
         */
        public function addProductToCart($usrId,$idprod,$quantity){
            $matchInCart = $this->alreadyInCart($idprod,$usrId); //to understand if update or insert quantity in cart
            $avaiableCopies = $this -> getAvaiableCopiesOfProd($idprod); //to check if article can be added to cart

            if($avaiableCopies > 0){
                if(count($matchInCart) <= 0){ //if first time to be added in cart
                    $query = "INSERT INTO `Carts`(`ProductId`, `UserId`, `Quantity`)
                        VALUES (?,?,?)";

                    $stmt = $this -> executeQuery($query,array($idprod,$usrId,$quantity));
                    //TODO FARE IL CONTROLLO SE PRESENTE UN ERRORE
                    return $stmt->insert_id;
                }
                else{ //in case of update quantity prod in cart 
                    $quantity += $matchInCart[0]['Quantity'];
                    $query = "UPDATE Carts SET ProductId=?,UserId=?,Quantity=?";

                    $stmt = $this -> executeQuery($query,array($idprod,$usrId,$quantity));
                    //TODO FARE IL CONTROLLO SE PRESENTE UN ERRORE
                    return $stmt->insert_id;
                }
            }
        }
        /**
         * Return all match of $idProd in a costumer's cart who has $usrId
         * @param int $idProd unique id of product
         * @param int $usrId unique id of user-costumer
         * @return array associative array containing quantity of product in user's cart 
         */
        private function alreadyInCart($idProd,$usrId){ //return quantity of the idProd if present in user cart
            $query = "SELECT `ProductId`, `UserId`, `Quantity` FROM `Carts` 
                        WHERE ProductId = ? AND UserId = ?";
            
            $stmt = $this -> executeQuery($query,array($idProd,$usrId));
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Insert a new copy of the product given in input.
         * @param int $productId the product id of the copy
         */
        public function addProductCopy($productId) {
            $query = "INSERT INTO ProductCopies(ProductId)
                      VALUES(?)";
            return $this->executeQuery($query, [$productId])->errno;
        }

        /**
         * Deletes all copies of a given product which are not associated to an existing order.
         * @param int $productId the id of the product to be deleted
         * @return void
         */
        public function deleteProductCopies($productId) {
            $query = "DELETE FROM ProductCopies
                      WHERE ProductId = ?
                      AND CopyId NOT IN (SELECT CopyId 
                                         FROM OrderDetails)";
            $this->executeQuery($query, [$productId]);
        }

        /**
         * Get all avaiable copies that can be bought from customer
         * @param int $idProd unique id of product 
         * @return int avaialble copies of specific product with $prodId
         */
        public function getAvaiableCopiesOfProd($idProd){
            //article copies in users cart - not avaiable for others users
            $copiesSold = count($this -> getCopiesSold($idProd));
            $copiesInStock = count($this -> getCopiesInStock($idProd));
            return $copiesInStock - $copiesSold;
        }
        /**
         * Get all copies in stock of a specific product with $idProd
         * @param int $idProd unique id of product 
         * @return array associative array containing all copies of product
         */
        private function getCopiesInStock($idProd){
            $query = "SELECT `CopyId`, `ProductId` FROM `ProductCopies` WHERE ProductId = ?";
            $stmt = $this->executeQuery($query, [$idProd]);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        /**
         * Get all copies not available to be bought, all copies in users carts
         * @param int $idProd unique id of product
         * @return array associative array containing amount of copies of specified prodcut $idProd
         */
        private function getCopiesSold($idProd){
            $query = "SELECT Od.CopyId
                        FROM `ProductCopies` as Pc, `OrderDetails` as Od
                        where Pc.CopyId = Od.CopyId
                        and Pc.ProductId = ?";
            $stmt = $this->executeQuery($query, [$idProd]);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        //-----------------------CATALOG-----------------------------//
        public function getLanguages(){
            return $this -> getListOfFromComics('Lang');
        }

        public function getAllAuthors(){
            return $this -> getListOfFromComics('Author');
        }
        /**
         * NOTE: be sure the param is an attributo of Comics
         * @param string $attribute String that is an attribute of comics
         * @return array associative array with all value that attribute can assume
         */
        private function getListOfFromComics($attribute){
            $query = "SELECT ".$attribute." FROM Comics Group by ". $attribute;
            $stmt = $this->executeQuery($query, []);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        /**
         * Get all categories available and saved in db
         * @return array Associative array like a list of categories
         */
        public function getAllCategories(){
            $query = "SELECT * FROM `Categories`";
            $stmt = $this->executeQuery($query, []);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function isFavourite($usrId,$prodId){
            $query = "SELECT count(*) as 'Count' 
            FROM `Favourites` WHERE `UserId` = ? and `ProductId` = ?";

            $stmt = $this->executeQuery($query, [$usrId,$prodId]);
            $result = $stmt->get_result();
            $isFav = $result->fetch_assoc()['Count'] > 0 ? true : false;
            return $isFav;
        }

        //------------------APPLY FILTERS CATALOG---------------------------------/

        /**
         * Get all comics and bind all params passed
         * @param string SQL query to be executed on db
         * @return array associative array with all product that match query
         */
        public function getAllComicsMatch($params,$filter=''){
            $query = "SELECT * 
                FROM Products as P, Comics as C, Publisher as PB 
                WHERE C.ProductId = P.ProductId and PB.PublisherId = C.PublisherId";
            
            if($filter != '' && count($params)){
                $query .= $filter;
            }
            //print_r($query);
            $stmt = $this -> executeQuery($query, $params);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * 
         * @param string SQL query to be executed on db
         * @return array associative array with all funkos that match query
         */
        public function getAllFunkosMatch($params,$filter=''){
            $query = "SELECT F.FunkoId, F.ProductId, F.Name as Title, P.Price, P.DiscountedPrice, P.Description, P.CoverImg, P.CategoryName
                    FROM Funkos as F, Products as P
                    WHERE F.ProductId = P.ProductId ";
                
            if($filter != '' && count($params)){
                $query .= $filter;
            }
            //print_r($query);
            $stmt = $this -> executeQuery($query, $params);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        //------------------STATISTIC-PAGE-----------------//
        /**
         * Get correct string of Period by integer
         * @param int $period
         * @return string period string
         */
        private function getStringPeriod($period){
            if($period == 0){
                return "Day";
            }
            else if($period == 1){
                return "Month";
            }
            else if($period == 2){
                return "Year";
            }
            else{ //default value
                return "Month";
            }
        }
        //OrderId	Address	OrderDate	Price	UserId
        public function getStatsPerPeriod($period, $year){
            $p = $this -> getStringPeriod($period);
            $funct = $p ."(O.OrderDate)";
            $query = "SELECT ". $funct ." AS ".$p.", count(*) as 'Count', sum(Price) as 'Total'
                    FROM Orders as O ";
            
            $params =[];
            if($period != YEAR){
                $query .= " WHERE Year(O.OrderDate) = ? ";
                $params = array($year);
            }
            $query .= " group by ".$p." order by ".$p." Asc";
            
            //var_dump($query);
            /*
            $stmt = $this->db->prepare($query);
            if($period != YEAR){
                $stmt->bind_param('i', $year);
            }
            $stmt->execute();*/

            $stmt = $this->executeQuery($query, $params);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getYearsWithOrders(){
            $query = "SELECT Year(OrderDate) as 'Year' FROM Orders GROUP by Year(OrderDate)";
            
            $stmt = $this->executeQuery($query, []);
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

    }

?>