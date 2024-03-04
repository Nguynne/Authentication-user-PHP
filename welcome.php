<?php
    require "classes/auth.php";

    session_start();
    Auth::requireLogin();

    if (isset($_POST['logout'])) {
        // Call the logout function
        Auth::logout();
        // Redirect the user to the login page
        header('Location: login.php');
        exit();
    }
    if(!empty($_SESSION['access_token']))
    {
        echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
        echo '<img src="'.$_SESSION["user_image"].'" />';
        echo '<h3><b>Name : </b>'.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name']. '</h3>';
        echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
    }
    if(!empty($_SESSION['fb_id']))
    {
        echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
        echo $_SESSION['fb_pic'];
        echo "Facebook Name: ". $_SESSION['fb_name'];
        echo "Facebook ID: ". $_SESSION['fb_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: white;">
    <h1> WelCome to our Blog</h1>
    <form method="POST">
        <input type="submit" name="logout" value="Logout">
    </form>
    
</body>
</html>