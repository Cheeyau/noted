<?php 
    require_once APPROOT . '/lib/mailer.php';    
    class LoginController extends AutoLoader {
        public function __construct() {
            $this->loginModel = $this->model('LoginModel');
            $data = $this->emptyData();
            
        }
        // page for loginpage
        public function index() {
            $data = $this->emptyData();
            $this->view('/pages/login', $data);
        }
        // page for resetpassword
        public function resetPasswordPage() {
            $data = $this->emptyData();
            $this->view('/pages/resetPassword', $data);
        }
        // page for register
        public function registerUserPage() {
            $data = $this->emptyData();
            $this->view('/pages/registerUser', $data);
        }
        // Empty array 
        private function emptyData() {
            $data = [
                'userId' => '', 'userName' => '', 'userPass' => '', 'userEmail' => '', 'userRoll' => '', 'userSalt' => '', 'errorMess' => ''
            ];
            return $data;
        }
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
            $data = $this->emptyData();
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
                // check recaptcha
                $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
                if(isset($recaptchaCheck->score)) {
                    if($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
                        // Validate inlog
                        if(empty($_POST['userName'])) {
                            $data['errorMess'] = "Please enter your user name.";
                        } else {
                            $_POST['userName'] = filterName($_POST['userName']);
                            // check sanitize of name
                            if($_POST['userName'] == false) {
                                $data['ErrorMess'] = "Please enter a valid user name.";
                            } else {
                                $data['userName'] = trim($_POST['userName']);
                                // empty field
                                if(empty($_POST["userPassword"])) {
                                    $data['errorMess'] = "Please enter your password.";
                                } else {
                                    $_POST['userPassword'] = filterString($_POST['userPassword']);
                                    // check sanitize password
                                    if($_POST['userPassword'] == false){
                                        $data['errorMess'] = "Please enter a valid password.";
                                    } else {
                                        // push user to db layer 
                                        $data['userPass'] = trim($_POST['userPassword']);
                                        $tempUser = $this->loginModel->checkLoginModel($data['userName'], $data['userPass']);
                                        if (!$tempUser == false) {
                                            $this->setSession($tempUser);
                                        } else {
                                            $data['errorMess'] = "The password and user combination is not valid.";
                                        }
                                    } 
                                }
                            }
                        }
                    } else {
                        $data['errorMess'] = "The captcha failed, please try again.";
                    }
                }
            } 
            $this->view('/pages/login', $data);
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
            $data = $this->emptyData();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
                // recaptcha check
                $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
                if(isset($recaptchaCheck->score)) {
                    if ($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
                        // Validate inlog
                        if(empty($_POST['userName'])) {
                            $data['errorMess'] = "Please enter your user name.";
                        } else {
                            $_POST['userName'] = filterName($_POST['userName']);
                            // check sanitize of name
                            if($_POST['userName'] === false) {
                                $data['ErrorMess'] = "Please enter a valid user name.";
                            } else {
                                $data['userName'] = trim($_POST['userName']);
                                // empty email
                                if(empty($_POST["userEmail"])) {
                                    $data['errorMess'] = "Please enter your email."; 
                                } else {
                                    $_POST['userEmail'] = filterEmail($_POST['userEmail']);
                                        // check sanitize password
                                    if($_POST['userEmail'] === false) { 
                                        $data['errorMess'] = "Please enter a valid email.";
                                    } else {
                                        $data['userEmail'] = trim($_POST['userEmail']);
                                        if(empty($_POST["userPassword"])) {
                                            $data['errorMess'] = "Please enter your password.";
                                        } else {
                                            $_POST['userPassword'] = filterString($_POST['userPassword']);
                                            // check sanitize password
                                            if($_POST['userPassword'] === false) {
                                                $data['errorMess'] = "Please enter a valid password.";
                                            } else {
                                                // push user to db layer 
                                                $data['userPass'] = trim($_POST['userPassword']);
                                                $tempSalt = $this->saltShaker();
                                                $tempUser = $this->loginModel->registerUserModel(
                                                    $data['userName'],
                                                    $data['userEmail'], 
                                                    $data['userPass'],
                                                    $tempSalt
                                                );
                                                if (!$tempUser === false) {
                                                    $this->setSession($tempUser);
                                                } else {
                                                    $data['errorMess'] = "Something went wrong, please try it again";
                                                }
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                        
                    } else {
                        $data['errorMess'] = "The captcha failed, please try again.";
                    }
                }
            $this->view('/pages/registerUser', $data);
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
        $data = $this->emptyData();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
            $recaptchaCheck = checkRecaptcha($_POST['recaptcha_response']);
            if(isset($recaptchaCheck->score)) {
                if ($recaptchaCheck->score >= 0.5 && $recaptchaCheck->success) {
                    // Validate inlog
                    if(empty($_POST["userEmail"])) {
                        $data['errorMess'] = "Please enter your email."; 
                    } else {
                        $_POST['userEmail'] = filterEmail($_POST['userEmail']);
                            // check sanitize password
                        if($_POST['userEmail'] === false) { 
                            $data['errorMess'] = "Please enter a valid email.";
                        } else {
                            $data['userEmail'] = trim($_POST['userEmail']);
                            $token = random_bytes(32);







                            $tempResponse = $this->loginModel->updateUserTokenModel($data['userEmail'], $token);
                            if($tempResponse === true) {
                                $url = sprintf( APPROOT . '/pages/resetPassword', http_build_query([
                                    'validator' => bin2hex($token)
                                ]));
                                $mail = new Mailer();
                                // $mail->SendMail();
                                $data['errorMess'] = "The reset link has been send to the email that is filled in.";
                            } else {
                                $data['errorMess'] = "The email address does not exist.";
                            }
                        }
                    }
                } else {
                    $data['errorMess'] = "The captcha failed, please try again.";
                }
            }
        }
        $this->view('/pages/registerUser', $data);
    } 

    private function mailBody() {

    }

    public function confirmPasswordReset() {
        
    }
}