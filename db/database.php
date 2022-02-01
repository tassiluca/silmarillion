<?php

    class DatabaseHelper {
        private $db;

        public function __construct($servername, $username, $password, $dbname, $port) {
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        public function getUserData($username) {
            $query = "SELECT UserId, Password, Salt, IsActive
                      FROM Users 
                      WHERE Username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getLoginAttempts($userId, $validAttempts) {
            /* Please note validAttempts is generated from the system. */
            $query = "SELECT TimeLog
                      FROM LoginAttemps 
                      WHERE UserId = ?
                      AND TimeLog > '$validAttempts'";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->num_rows;
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
            return getListOfFromComics('Lang');
        }

        public function getAllAuthors(){
            return getListOfFromComics('Author');
        }

        private function getListOfFromComics($attribute){ //NOTE: be sure the param is an attributo of Comics
            $query = "SELECT ? FROM Comics Group by ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $attribute, $attribute);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

    }
?>