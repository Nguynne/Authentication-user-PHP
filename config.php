<?php
    //Thông số của CSDL
    define('DB_HOST', 'localhost:3306');
    define('DB_NAME', 'db_ct06');
    define('DB_USER', 'ad_db_ct06');
    define('DB_PASS', 'dbct06');
    session_start();
    //Include Google Client Library for PHP autoload file
    require_once 'vendor/autoload.php';

    //Make object of Google API Client for call Google API
    $google_client = new Google_Client();

    //Set the OAuth 2.0 Client ID
    $google_client->setClientId('748189981204-9ekhubb8k6romqs5b1gtskhcgoigj6s9.apps.googleusercontent.com');

    //Set the OAuth 2.0 Client Secret key
    $google_client->setClientSecret('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');

    //Set the OAuth 2.0 Redirect URI
    $google_client->setRedirectUri('http://localhost/lab_01/login.php');

    // to get the email and profile 
    $google_client->addScope('email');

    $google_client->addScope('profile');
?>
