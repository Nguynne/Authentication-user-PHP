<?php

// Google API configuration
define('GOOGLE_CLIENT_ID', '748189981204-9ekhubb8k6romqs5b1gtskhcgoigj6s9.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'http://localhost/lab_01/login.php');

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId(GOOGLE_CLIENT_ID);

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret(GOOGLE_CLIENT_SECRET);

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_client->addScope('email');
$google_client->addScope('profile');

?>