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
        echo '<img src="'.$_SESSION['profile_picture'].'" class="img-responsive img-circle img-thumbnail" />';
        echo '<h3><b>Name : </b>'.$_SESSION["first_name"].' '.$_SESSION['last_name']. '</h3>';
        echo '<h3><b>Email :</b> '.$_SESSION['email_address'].'</h3>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1> WelCome to our Blog</h1>
    <form method="POST">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>
</html>