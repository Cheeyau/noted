<?php
    class IndexController extends AutoLoader {
        public function __construct() {
            $this->indexModel = $this->model('IndexModel');
        }
        
        public function index() {
            if(isset($_SESSION['userId'])) {
                $infoData = [];
                $this->view('pages/dashboard', $infoData);
            } else {
                header('location: ' . URLROOT . '/LoginController/login');
                exit();
            }
        }
    }