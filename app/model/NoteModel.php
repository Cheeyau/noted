<?php
    class NoteModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getUsers() {
            $this->db->query("SELECT * FROM Note");

            $result = $this->db->resultSet();
            
            return $result;
        }
    }