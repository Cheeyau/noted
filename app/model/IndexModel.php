<?php
    class IndexModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function index() {
            $this->db->query("SELECT * FROM Note");

            $result = $this->db->resultSet();
            
            return $result;
        }
        
    }