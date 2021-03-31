<?php
    class IndexController extends AutoLoader {
        public function __construct() {
            $this->indexModel = $this->model('IndexModel');
        }
        // check if userid is set, if not send to login page
        public function index() {
            if(isset($_SESSION['userId'])) {
                $data = [];
                $this->view('pages/dashboard', $data);
            } else {
                header('location: ' . URLROOT . '/LoginController/login');
                exit();
            }
        }
    }