<?php
  include('auth-providers/facebook/config.php');

  $loginUrl = '';
  if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
      $_SESSION['facebook_access_token'] = (string) $accessToken;
      $oAuth2Client = $fb->getOAuth2Client();
      $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
      $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
      $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    //  // redirect the user to the profile page if it has "code" GET variable
    //  if (isset($_GET['code'])) {
    //      header('Location: ./');
    //  }
    
      try {
        $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
        $requestPicture = $fb->get('/me/picture?redirect=false&height=200'); //getting user picture
        $picture = $requestPicture->getGraphUser();
        $profile = $profile_request->getGraphUser();
        $a = $profile->getField('email');
        $fbid = $profile->getProperty('id');           // To Get Facebook ID
        $fbfullname = $profile->getProperty('name');   // To Get Facebook full name
        $fbemail = $profile->getProperty('email');    //  To Get Facebook email
        $fbpic = "<img src='" . $picture['url'] . "' class='img-rounded'/>";
    
        # save the user information in session variable
        $_SESSION['fb_id'] = $fbid . '</br>';
        $_SESSION['fb_name'] = $fbfullname . '</br>';
        $_SESSION['fb_pic'] = $fbpic . '</br>';
        $_SESSION['profile'] = $picture;
        $_SESSION['ok'] = $profile;
      } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        exit;
      }
  } else {
    // replace your website URL same as added in the developers.Facebook.com/apps e.g. if you used http instead of https and you used            
    $loginUrl = '<a href="' .$helper->getLoginUrl('http://localhost/lab_01/login.php', $permissions).'" style = "display: flex;
    width: 40px;
    height: 40px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    align-items: center;
    justify-content: center;
    border-radius: 50%;"><span class="fa fa-facebook"></span></a>';
  }

?>
