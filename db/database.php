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

        public function getHomeBanner(){
            $query = "SELECT NewsId, Title, Description, Img, UserId
                    FROM News";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getNewArrival($n=10){
            $query = "SELECT C.Title,C.Author,C.Lang,C.PublishDate,C.ISBN,C.ProductId,C.PublisherId,P.Price,P.DiscountedPrice,P.Description,P.CoverImg,P.CategoryName
                    FROM Comics as C, Products as P
                    WHERE C.ProductId = P.ProductId
                    AND DATEDIFF(CURRENT_DATE(),C.PublishDate) <= 30
                    LIMIT ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $n);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

    }

?>