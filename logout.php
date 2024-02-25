<?php
    require "classes/auth.php";
        Auth::logout();
        // Redirect the user to the login page
        header('Location: login.php');
        exit();
?>