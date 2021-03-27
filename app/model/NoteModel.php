<?php
    class NoteModel {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getNotes() {
            $this->db->query("SELECT * FROM Note");
            $result = $this->db->resultSet();
            return $result;
        }
        
        
    }