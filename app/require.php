<?php
    // core load
    require_once '../app/core/Url.php';
    // db connection 
    require_once '../app/core/Datebase.php';
    // autoload
    require_once '../app/core/AutoLoader.php';
    // configuration db
    require_once '../app/config/config.php';
    require_once '../app/lib/sessionLogin.php';
    startSession(); 
    // Start app
    $app = new Url();