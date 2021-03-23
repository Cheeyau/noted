<?php
    // Destroy cookie, cache  
    function logout() {
        if (isset($_SESSION['userId'])) {
            session_destroy();
            unset($_COOKIE['userId']); 
            setcookie('userId', null, -1, '/'); 
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Content-Type: application/xml; charset=utf-8");
            session_destroy();
            header('location: ' . URLROOT . '/app/view/pages/login.php');
            return true;
        } else {
            return false;
        }
    }