<?php
    class IndexController extends AutoLoader {
        public function __construct() {
            $this->indexModel = $this->model('IndexModel');
        }
        
        public function index() {
            $infoData = [
                
            ];
            $this->view('pages/dashboard', $infoData);
        }
    }