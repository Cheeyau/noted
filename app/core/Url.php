<?php

    class Url {
        protected $currentControll = 'LoginController';
        protected $currentMethod = 'login';
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();
            // Look in BLL for first value
            if (isset($url)) {
                $controllerName = ucwords($url[0]);
                if(file_exists('../app/controllers/' . $controllerName . '.php')) {
                    $this->currentController = $controllerName;
                    unset($url[0]);
                }
            }
            // Require the controller
            require_once '../app/controller/' . $this->currentControll . '.php';
            // Instantiate controller class
            $this->currentControll = new $this->currentControll;
            // Check for second part of url
            if(isset($url[1])) {
                // Check to see if method exists in controller 
                if(method_exists($this->currentControll, $url[1])) {
                    $this->currentMethod = $url[1];
                    // Unset 1 index
                    unset($url[1]);
                }
            }
            // Get parameters
            $this->params = $url ? array_values($url) : [];
            // Call a callback with array of params
            call_user_func_array([$this->currentControll, $this->currentMethod], $this->params);
        }

        // sanitize url and remove special characters 
        public function getUrl() {
            if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
            }
        }
    }