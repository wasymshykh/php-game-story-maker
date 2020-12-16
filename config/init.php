<?php

    session_start();
    define('DIR', dirname(__DIR__).'/');
    define('URL', "http://localhost/game-story-maker");

    // Either: development/production
    define('PROJECT_MODE', 'development'); 

    if (PROJECT_MODE !== 'development') {
        error_reporting(0);
    } else {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // Database connection details
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'wp_game_db');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    // Timezone setting
    define('TIMEZONE', 'Asia/Karachi');
    date_default_timezone_set(TIMEZONE);
    
    // Auto load classes
    require_once DIR . 'config/auto_loader.php';

    // Functions
    include DIR . 'includes/functions.php';
    
    // Get db handle
    $db = (new DB())->connect();

