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
    }