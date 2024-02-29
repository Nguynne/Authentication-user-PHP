<?php
    require "classes/auth.php";
        Auth::logout();
        unset($_SESSION['facebook_access_token']);
        unset($_SESSION['fb_id']);
        unset($_SESSION['fb_name']) ;
        unset($_SESSION['fb_email']);
        unset($_SESSION['fb_pic']);
        // Redirect the user to the login page
        header('Location: login.php');
        exit();
?>