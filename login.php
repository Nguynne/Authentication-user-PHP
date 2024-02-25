<?php
    require "config.php";
    require "classes/database.php";
    require "classes/user.php";
    require "classes/fieldvalidator.php";
    require "classes/auth.php";
    $conn = require "inc/db.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $email = $_POST["email"];
           $password = $_POST["password"];
           $checkField = new FieldValidator();
           $errors = $checkField->checkLogin($email, $password);
           if (count($errors)>0) {
                foreach ($errors as  $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
           else {
                try{
                    if (User::authenticate($conn, $email, $password)) {
                        Auth::login();
                        Header('Location: welcome.php');
                    } 
                    else {
                        echo"<div class='alert alert-danger'>Incorrect user or password</div>"; 
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                    // Có thể gọi trang xử lí lỗi
                    // Header('Location: error.php');
                }
           }
    }
    include_once "vendor/autoload.php";



    if(isset($_GET["code"]))
    {
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

        if(!isset($token["error"]))
        {
            $google_client->setAccessToken($token['access_token']);

            $_SESSION['access_token']=$token['access_token'];

            $google_service = new Google_Service_Oauth2($google_client);

            $data = $google_service->userinfo->get();

            $current_datetime = date('Y-m-d H:i:s');

            $_SESSION['first_name']=$data['given_name'];
            $_SESSION['last_name']=$data['family_name'];
            $_SESSION['email_address']=$data['email'];
            $_SESSION['profile_picture']=$data['picture'];
        }
    }
    
    
    $login_button = '';
    
    // echo $_SESSION['access_token'];
    
    if(!$_SESSION['access_token'])
    {
        //  echo 'test';
        
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="img/sign-in-google.png" /></a>';
    
    }

    // if($login_button != ''){
    //     Auth::login();
    //     header('Location: welcome.php');
    // }

?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="container">
            <h2 style="color: black; margin-bottom: 1.5rem">Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="email" placeholder="Enter Email:" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Password:" name="password" class="form-control">
                </div>
                <div class="form-btn">
                    <div >
                        <input type="submit" value="Login" name="login" class="btn btn-primary">
                    </div>
                    <p>Not registered yet? <a style="text-decoration: none;" href="registration.php">Register here</a></p>
                </div>
            </form>

            <br />
            <div class="panel panel-default">
            <?php
                if(!empty($_SESSION['access_token']))
                {
                    Auth::login();
                    header('Location: welcome.php');
                }
                else
                {
                 echo '<div align="center">'.$login_button . '</div>';
                }
            ?>
            </div>
        </div>

    </body>
</html> 
