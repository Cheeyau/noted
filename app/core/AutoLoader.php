<?php

class AutoLoader {
    //load model and view
    public function model($incModel) {
        // Require model file else error message 
        
        require_once '../app/model/'. $incModel . '.php';
        // initiate model 
         return new $incModel;
    }

    // load view and data for in the view
    public function view($nameView, $infoData = []) {

        if (file_exists('../view/pages/' . $nameView . '.php')) {
            require_once '../view/pages/' . $nameView . '.php';
        } else {
             die("404 - The view has not been found yet");
        }
    }
}