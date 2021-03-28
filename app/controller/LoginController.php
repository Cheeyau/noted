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
                if(isset($_SESSION['userId'])) {
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
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
                // check recaptcha
                $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
                if(isset($recaptchaCheck->score)) {
                    if($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
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
                    } else {
                        $infoData['errorMess'] = "The captcha failed, please try again.";
                    }
                }
            } 
            $this->view('/pages/login', $infoData);
        }

        // Set user session
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
                $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
                if ($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
                    // Validate inlog
                    if(empty($_POST['userName'])) {
                        $infoData['errorMess'] = "Please enter your user name.";
                    } else {
                        $_POST['userName'] = filterName($_POST['userName']);
                        // check sanitize of name
                        if($_POST['userName'] === false) {
                            $infoData['ErrorMess'] = "Please enter a valid user name.";
                        } else {
                            $infoData['userName'] = trim($_POST['userName']);
                            // empty email
                            if(empty($_POST["userEmail"])) {
                                $infoData['errorMess'] = "Please enter your email."; 
                            } else {
                                $_POST['userEmail'] = filterEmail($_POST['userEmail']);
                                    // check sanitize password
                                if($_POST['userEmail'] === false) { 
                                    $infoData['errorMess'] = "Please enter a valid email.";
                                } else {
                                    $infoData['userEmail'] = trim($_POST['userEmail']);
                                    if(empty($_POST["userPassword"])) {
                                        $infoData['errorMess'] = "Please enter your password.";
                                    } else {
                                        $_POST['userPassword'] = filterString($_POST['userPassword']);
                                        // check sanitize password
                                        if($_POST['userPassword'] === false) {
                                            $infoData['errorMess'] = "Please enter a valid password.";
                                        } else {
                                            // push user to db layer 
                                            $infoData['userPass'] = trim($_POST['userPassword']);
                                            $tempSalt = $this->saltShaker();
                                            $tempUser = $this->loginModel->registerUserModel(
                                                $infoData['userName'],
                                                $infoData['userEmail'], 
                                                $infoData['userPass'],
                                                $tempSalt
                                            );
                                            if (!$tempUser === false) {
                                                $this->setSession($tempUser);
                                            } else {
                                                $infoData['errorMess'] = "Something went wrong, please try it again";
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
    // generate random salt
    private function saltShaker() {
        $rnd = rand(0, 10);
        $salt = "";
        switch ($rnd) {
            case 1:
                $salt =  "mango";
                break;
            case 2:
                $salt =  "banana";
                break;
            case 3:
                $salt = "apple";
                break;
            case 4:
                $salt = "lemon";
                break;
            case 5:
                $salt = "hotdog";
                break;
            case 6:
                $salt = "pizza";
                break;
            case 7:
                $salt = "candy";
                break;
            case 8:
                $salt = "hamburger";
                break;
            case 9:
                $salt = "watermelon";
                break;
            case 10:
                $salt = "chips";
                break;
        }
        return $salt;
    }
    // send reset link by mail
    public function resetPassword() {
        require_once APPROOT . '/lib/mailer.php';
        $infoData = $this->emptyData();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
            $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
            if(isset($recaptchaCheck->score)) {
                if ($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
                    // Validate inlog
                    if(empty($_POST["userEmail"])) {
                        $infoData['errorMess'] = "Please enter your email."; 
                    } else {
                        $_POST['userEmail'] = filterEmail($_POST['userEmail']);
                            // check sanitize password
                        if($_POST['userEmail'] === false) { 
                            $infoData['errorMess'] = "Please enter a valid email.";
                        } else {
                            $infoData['userEmail'] = trim($_POST['userEmail']);
                            $token = random_bytes(32);

                            $tempResponse = $this->loginModel->updateUserTokenModel($infoData['userEmail'], $token);
                            if($tempResponse === true) {
                                $url = sprintf( APPROOT . '/pages/resetPassword', http_build_query([
                                    'validator' => bin2hex($token)
                                ]));
                                $mail = new Mailer();
                                $mail->SendMail();
                                $infoData['errorMess'] = "The reset link has been send to the email that is filled in.";
                            } else {
                                $infoData['errorMess'] = "The email address does not exist.";
                            }
                        }
                    }
                } else {
                    $infoData['errorMess'] = "The captcha failed, please try again.";
                }
            }
        }
        $this->view('/pages/registerUser', $infoData);
    } 

    private function mailBody() {
        
    }

    public function confirmPasswordReset() {
        
    }
}