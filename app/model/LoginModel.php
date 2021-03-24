<?php 
    class LoginModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        // verify password with db
        public function checkLoginModel(string $userName, string $password){
            $this->db->query("SELECT * FROM `user` WHERE `name` = :userName;");
            $this->db->bindString(':userName', $userName);
            $row = $this->db->single();
            if($this->db->rowCount() > 0){
                $tempPassword = hash('sha256', $password.$row->Salt);
                if (password_verify($tempPassword, $row->Password)) {
                    return $row;
                } else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        
    }