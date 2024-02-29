<?php

//initialize facebook sdk
require 'auth-providers/facebook/fb/vendor/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1087166925761935',
  'app_secret' => 'af98760ba6e8cf75439e0c4a594c8bdc',
  'default_graph_version' => 'v2.5',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional

try {
    if (isset($_SESSION['facebook_access_token'])) {
      $accessToken = $_SESSION['facebook_access_token'];
    } else {
      $accessToken = $helper->getAccessToken();
    }
  } 
catch (Facebook\Exceptions\facebookResponseException $e) {
    // echo 'Graph returned an error: ' . $e->getMessage();
    
}
catch (Facebook\Exceptions\FacebookSDKException $e) {
    // echo 'Facebook SDK returned an error: ' . $e->getMessage();
    
}

?>