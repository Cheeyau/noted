<?php

    class Url {
        protected $currentControl = 'IndexController';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();
            if(isset($url[1])) {
                if(file_exists('../app/controller/'. ucwords($url[0]) . '.php')) {
                    $this->currentControl = ucwords($url[0]);
                    unset($url[0]);
                }
            }
            require_once '../app/controller/' . $this->currentControl . '.php';
            $this->currentControl = new $this->currentControl;
            if(isset($url[1])) {
                if(method_exists($this->currentControl, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }
            // Callback of controller with method
            $this->params = $url ? array_values($url) : [];
            call_user_func_array([$this->currentControl, $this->currentMethod], $this->params);
        }
        // Sanitize url and return clean url
        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = trim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }