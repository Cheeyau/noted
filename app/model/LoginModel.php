<?php 
    class LoginModel {
        private $db;
        public function __construct() {
            $this->$db = new Database;
        }
        
        public function getUsers() {
            $this->db->query("SELECT * FROM User");

            $result = $this->db->resultSet();
            
            return $result;
        }
    }