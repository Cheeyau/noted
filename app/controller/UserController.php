<?php
    class UserController extends AutoLoader {

        // search model with para User
        public function __construct() {
            $this->userModel = $this->model('UserModel');            
        }

        // initiate user view with data
        public function index() {
            // $infoData = [
                
            // ];
            $this->view('index', $infoData);
        }
    }