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
        public function addUser($username, $password, $salt, $name, $surname, $birthday, $mail) {
            $query = "INSERT INTO Users(Username, Password, Salt, Name, Surname, DateBirth, Mail, IsActive)
                      VALUES(?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssssss', $username, $password, $salt, $name, $surname, $birthday, $mail);
            $stmt->execute();
            return $stmt->insert_id;
        }

        /**
         * Insert into table `Customers` a new customer user. 
         * [IMPORTANT] The user given in input must be present into the `Users` table!
         * @param int $userId the user
         * @return bool true on success or false on failure
         */
        public function addCustomer($userId) {
            $query = "INSERT INTO Customers(UserId)
                      VALUES(?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $userId);
            return $stmt->execute();
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

    }

?>