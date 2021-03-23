<?php
    class NoteController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('NoteModel');
        }
        
        public function index() {
            $infoData = [
                
            ];
            $this->view('note', $infoData);
        }

        public function getNotes() {
            if (true) {
                $notes = $this->NoteModel->getNotes;
                return true;
            } else {
                return false;
            }
        }
    }