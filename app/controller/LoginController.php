<?php 
    class LoginController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('LoginModel');
            $infoData = $this->emptyData();
        }
        // page for loginpage
        public function index() {
            $infoData = $this->emptyData();
            $this->view('/pages/login', $infoData);
        }
        // page for resetpassword
        public function resetPasswordPage() {
            $infoData = $this->emptyData();
            $this->view('/pages/resetPassword', $infoData);
        }
        // page for register
        public function registerUserPage() {
            $infoData = $this->emptyData();
            $this->view('/pages/registerUser', $infoData);
        }
        
        private function emptyData() {
            $infoData = [
                'userId' => '', 'userName' => '', 'userPass' => '', 'userEmail' => '', 'userRoll' => '', 'userSalt' => '', 'errorMess' => ''
            ];
            return $infoData;
        }
        
        // log out us

        // log out user
        public function logout() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_SESSION['userId'])) {
                    session_destroy();
                    setcookie('userId', null, -1, '/'); 
                    unset($_COOKIE['userId']); 
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header("Content-Type: application/xml; charset=utf-8");
                    header('location: ' . URLROOT . '/LoginController/login');
                    exit();
                } 
            }
        }

        // login validation
        public function login() {
            $infoData = $this->emptyData();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                // Validate inlog
                if(empty($_POST['userName'])) {
                    $infoData['errorMess'] = "Please enter your user name.";
                } else {
                    $_POST['userName'] = filterName($_POST['userName']);
                    // check sanitize of name
                    if($_POST['userName'] == false) {
                        $infoData['ErrorMess'] = "Please enter a valid user name.";
                    } else {
                        $infoData['userName'] = trim($_POST['userName']);
                        // empty field
                        if(empty($_POST["userPassword"])) {
                            $infoData['errorMess'] = "Please enter your password.";
                        } else {
                            $_POST['userPassword'] = filterString($_POST['userPassword']);
                            // check sanitize password
                            if($_POST['userPassword'] == false){
                                $infoData['errorMess'] = "Please enter a valid password.";
                            } else {
                                // push user to db layer 
                                $infoData['userPass'] = trim($_POST['userPassword']);
                                $tempUser = $this->loginModel->checkLoginModel($infoData['userName'], $infoData['userPass']);
                                if (!$tempUser == false) {
                                    $this->setSession($tempUser);
                                } else {
                                    $infoData['errorMess'] = "The password and user combination is not valid.";
                                }
                            } 
                        }
                    }
                }
            } 
            $this->view('/pages/login', $infoData);
        }

        private function setSession($user) {
            $_SESSION["userId"] = $user->UserId;
            $_SESSION["userName"] = $user->Name;
            $_SESSION["userEmail"] = $user->EmailAddress;
            $_SESSION["userPass"] = $user->Password;
            $_SESSION["userSalt"] = $user->Salt;
            $_SESSION["userRoll"] = $user->UserRoll;
            header('location:' . URLROOT . '/IndexController/index');
            exit();
        }

        // register user
        public function registerUser() {
            $infoData = $this->emptyData();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
                // recaptcha check
                $recaptchaCheck = checkRecaptcha();
                if ($recaptchaCheck->success == true) {
                    // Validate inlog
                    if(empty($_POST['userName'])) {
                        $infoData['errorMess'] = "Please enter your user name.";
                    } else {
                        $_POST['userName'] = filterName($_POST['userName']);
                        // check sanitize of name
                        if($_POST['userName'] == false) {
                            $infoData['ErrorMess'] = "Please enter a valid user name.";
                        } else {
                            $infoData['userName'] = trim($_POST['userName']);
                            // empty email
                            if(empty($_POST["userEmail"])) {
                                $infoData['errorMess'] = "Please enter your email."; 
                            } else {
                                $_POST['userEmail'] = filterEmail($_POST['userEmail']);
                                    // check sanitize password
                                if($_POST['userEmail'] == false) { 
                                    $infoData['errorMess'] = "Please enter a valid email.";
                                } else {
                                    if(empty($_POST["userPassword"])) {
                                        $infoData['errorMess'] = "Please enter your password.";
                                    } else {
                                        $_POST['userPassword'] = filterString($_POST['userPassword']);
                                        // check sanitize password
                                        if($_POST['userPassword'] == false) {
                                            $infoData['errorMess'] = "Please enter a valid password.";
                                        } else {
                                            // push user to db layer 
                                            $infoData['userPass'] = trim($_POST['userPassword']);
                                            $tempUser = $this->loginModel->checkLoginModel($infoData['userName'], $infoData['userPass']);
                                            if (!$tempUser == false) {
                                                $this->setSession($tempUser);
                                            } else {
                                                $infoData['errorMess'] = "The password and user combination is not valid.";
                                            }
                                        } 
                                    }
                                }
                            }
                        }
                    }
                    
                } else {
                    $infoData['errorMess'] = "The captcha failed, please try again.";
                }
            $this->view('/pages/registerUser', $infoData);
        }

        
    }
}