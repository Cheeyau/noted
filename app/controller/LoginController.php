<?php 
    class LoginController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('LoginModel');
        }
        
        public function index() {
            require_once APPROOT . '../lib/sessionLogin.php';
            $infoData = [
                'userId' => '', 'userPass' => '', 'userEmail' => '', 'userRoll' => '', 'userSalt' => '', 'errorMess' => ''
            ];
            $this->view('login', $infoData);
        }

        public function getUser() {
            if (is_null()) {
                $users = $this->loginModel->getUsers;
                return true;
            } else {
                return false;
            }
        }
    }