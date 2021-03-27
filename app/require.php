<?php
    // core load
    require_once '../app/core/Url.php';
    // db connection 
    require_once '../app/core/Datebase.php';
    // autoload
    require_once '../app/core/AutoLoader.php';
    // configuration and helpers
    require_once '../app/config/config.php';
    require_once '../app/lib/sessionLogin.php';
    require_once '../app/lib/sanitizeInput.php';
    require_once '../app/lib/recaptha.php';
    startSession(); 
    // Start app
    $app = new Url();