<?php 
    class UserModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getUsers() {
            $this->db->query("SELECT * FROM User");

            $result = $this->db->resultSet();
            
            return $result;
        }

        public function updateUserModel(int $userId, string $userName, string $userEmail, string $userPassword) {
            $this->db->query("UPDATE `User` SET `Name` = :userName, `EmailAddress` = :userEmail, `Password` = :userPassword
            WHERE `userId` = :userId");
            $this->db->bindInt(':userId', $userId);
            $this->db->bindString(':userName', $userName);
            $this->db->bindString(':userEmail', $userEmail);
            $this->db->bindString(':userPassword', $userPassword);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        
    }