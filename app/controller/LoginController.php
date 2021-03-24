<?php 
    class LoginController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('LoginModel');
        }

        
        // login validation
        public function login() {
            $infoData = [
                'userId' => '', 'userName' => '', 'userPass' => '', 'userEmail' => '', 'userRoll' => '', 'userSalt' => '', 'errorMess' => ''
            ];
            $this->view('pages/login', $infoData);
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                // Validate user name
                if(empty($_POST['userName'])) {
                    $infoData['errorMess'] = "Please enter your user name.";
                } else {
                    $_POST['userName'] = filterName($_POST['userName']);
                    if($_POST['userName'] == false) {
                        $infoData['ErrorMess'] = "Please enter a valid user name.";
                    } else {
                        $infoData['userName'] = trim($_POST['userName']);
                    }
                }
                
                // Validate password
                if(empty($_POST["userPassword"])) {
                    $emailErr = "Please enter your password.";     
                } else {
                    $email = filterString($_POST['userPassword']);
                    if($email == false){
                    } else {
                        $infoData['errorMess'] = "Please enter a valid password.";
                        $infoData['userPass'] = trim($_POST['userPassword']);
                    } 
                }
                if (!$this->loginModel->checkLoginModel($infoData['userPass'], $infoData['userPass']) === false) {
                    $this->setSession($this->loginModel->checkLoginModel($infoData['userPass'], $infoData['userPass']));
                } else {
                    $infoData = [
                        'userId' => '', 'userName' => '', 'userPass' => '', 'userEmail' => '', 'userRoll' => '', 'userSalt' => '', 'errorMess' => ''
                    ];
                }
            } else {
                $this->view('login', $infoData);
            };
        }

        private function setSession($user) {
            $_SESSION['userId'] = $user->userId;
            $_SESSION['userName'] = $user->userName;
            $_SESSION['userEmail'] = $user->userEmail;
            $_SESSION['userPass'] = $user->userPass;
            $_SESSION['userSalt'] = $user->userSalt;
            header('location: ' . URLROOT . '/pages/dashboard');
        }
    }