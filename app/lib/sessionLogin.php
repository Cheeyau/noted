
<?php
    // login session
    function isLogin() {
        if (isset($_SESSION['userId'])) {
            return true;
        } else {
            return false;
        }
    }
    function startSession() {
        if (!isset($_SESSION['userId'])) {
            session_start();
        }
    }
    
    