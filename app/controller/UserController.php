<?php
    class UserController extends AutoLoader {

        // search model with para User
        public function __construct() {
            $this->userModel = $this->model('UserModel');            
        }

        // initiate user view with data
        public function index() {
            $infoData = [
                
            ];
            $this->view('pages/index', $infoData);
        }
        
        public function getUser() {
            if (true) {
                $users = $this->userModel->getUser();
                return true;
            } else {
                return false;
            }
        }
        
        public function editUser() {
            $infoData = [];
            $this->view('pages/editUser', $infoData);
        }
    }