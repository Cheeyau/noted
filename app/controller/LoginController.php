<?php 
    class LoginController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('LoginModel');
        }
        
        public function index() {
            $infoData = [
                
            ];
            $this->view('login', $infoData);
        }
    }