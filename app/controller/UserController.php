<?php
    class UserController extends AutoLoader {

        // search model with para User
        public function __construct() {
            $this->userModel = $this->model('UserModel');            
        }

        // initiate user view with data
        public function index() {
            $infoData = [];
            $this->view('pages/index', $infoData);
        }
        
        public function getUserCon() {
            $users = $this->userModel->getUsersModel();
            $infoData = ['users' => $users, 'errorMess' =>''];
            $this->view('/pages/users', $infoData);
        }
        
        public function editUser() {
            $infoData = [
                'userId' => $_SESSION['userId'],
                'userRoll' => $_SESSION['userRoll'],
                'userName' => $_SESSION['userName'],
                'userEmail' => $_SESSION['userEmail'],
                'errorMess' => ''
            ];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(empty($_POST['inputName'])) {
                    $infoData['errorMess'] = "Please enter a new name to change.";
                } else {
                    $_POST['inputName'] = filterString($_POST['inputName']);
                    if($_POST['inputName']=== false) {
                        $infoData['errorMess'] = "Please enter a valid new name to change.";
                    } else {
                        $infoData['userName'] = trim($_POST['inputName']);
                        
                        if(empty($_POST['inputEmail'])) {
                            $infoData['errorMess'] = "Please enter a new name to change.";
                        } else {
                            $_POST['inputEmail'] = filterEmail($_POST['inputEmail']);
                            if($_POST['inputEmail']=== false) {
                                $infoData['errorMess'] = "Please enter a valid new name to change.";
                            } else {
                                $infoData['userEmail'] = trim($_POST['inputEmail']);

                                if(empty($_POST['inputPassword'])) {
                                    $infoData['errorMess'] = "Please enter a new password to change.";
                                } else {
                                    $_POST['inputPassword'] = filterString($_POST['inputPassword']);
                                    if($_POST['inputPassword']=== false) {
                                        $infoData['errorMess'] = "Please enter a valid new password to change.";
                                    } else {
                                        $tempPassword = trim($_POST['inputPassword']);
                                        $hashPassword = $this->hashPassword($tempPassword.$_SESSION['userSalt']);
                                        
                                        $tempEditUser = $this->userModel->updateUserModel($infoData['userId'], $infoData['userName'], $infoData['userEmail'], $hashPassword);
                                        if($tempEditUser === true) {
                                            $infoData['errorMess'] = "The changes is saved.";
                                            $this->setSession($infoData, $hashPassword);
                                        } else {
                                            $infoData['errorMess'] = 'Something went wrong, please try again.';
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            }
            $this->view('pages/editUser', $infoData);
        }
        // Set user session
        private function setSession($user, string $hashPassword) {
            $_SESSION["userName"] = $user['userName'];
            $_SESSION["userEmail"] = $user['userEmail'];
            $_SESSION["userPass"] = $hashPassword;
        }
        // hash password and salt with sha512
        public function hashPassword(string $passwordAndSalt) {
            return hash('sha512', $passwordAndSalt);
        }

        public function searchUserCon() {
            $infoData = [ 'users' => '', 'errorMess'=> ''];
            if($_SERVER['REQUEST_METHOD'] === 'GET') { 
                if(
                    !empty($_GET['inputDay']) && 
                    !empty($_GET['inputDay']) && 
                    !empty($_GET['inputYear']) 
                    ) {
                    $tempMonth = str_pad($_GET['inputMonth'], 2, "0", STR_PAD_LEFT);
                    $tempDay = str_pad($_GET['inputDay'], 2, "0", STR_PAD_LEFT);
                    $tempDate = $_GET['inputYear'] . '-' . $tempMonth . '-' . $tempDay;
                    $tempDate = filterString($tempDate);
                    if($tempDate === false) {
                        $infoData['errorMess'] = "Please enter a valid date.";
                    } else {
                        $infoData['users'] = $this->userModel->searchUserRegistrationModel($tempDate);
                        if($infoData['users'] === false) {
                            $infoData['errorMess'] = 'There are no users found.';
                            $infoData['users'] = '';
                        }
                    }
                }
                if(
                    !empty($_GET['inputName']) &&
                    empty($_GET['inputDay']) && 
                    empty($_GET['inputDay']) && 
                    empty($_GET['inputYear']) &&
                    empty($_GET['inputEmail'])
                ) {
                    $tempName = $_GET['inputName'];
                    $tempName = filterString($tempName);
                    if($tempName === false) {
                        $infoData['errorMess'] = "Please enter a valid name.";
                    } else {
                        $infoData['users'] = $this->userModel->searchUserNameModel($tempName);
                        if($infoData['users'] === false) {
                            $infoData['errorMess'] = 'There are no users found.';
                            $infoData['users'] = '';
                        }
                    }
                }
                if(
                    !empty($_GET['inputEmail']) && 
                    empty($_GET['inputDay']) && 
                    empty($_GET['inputDay']) && 
                    empty($_GET['inputYear']) &&
                    empty($_GET['inputName'])
                ) {
                    $tempEmail = $_GET['inputEmail'];
                    $tempEmail = filterString($tempEmail);
                    if($tempEmail === false) {
                        $infoData['errorMess'] = "Please enter a valid Email.";
                    } else {
                        $infoData['users'] = $this->userModel->searchUserEmailModel($tempEmail);
                        if($infoData['users'] === false) {
                            $infoData['errorMess'] = 'There are no users found.';
                            $infoData['users'] = '';
                        }
                    }
                }
                
             }
            
            $this->view('/pages/users', $infoData);
        }
    }