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

    // require_once "classes/facebook_auth";
    // $fb_auth = new Facebook_Auth();
    // $loginUrl = $fb_auth->getLoginUrl();

    require_once "auth-providers/google/index.php";
    require_once "auth-providers/facebook/index.php";
                
                


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
    <body style="background-color: #387ADF">
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
            <?php
                if($login_button == '')
                {
                     Auth::login();
                     header('Location: welcome.php');
                }
                else
                {
                    echo '<div align="center">'.$login_button . '</div>';
                }
            ?>
            <?php
            if(isset($_SESSION['fb_id']))
            {
                Auth::login();
                header('Location: welcome.php');
            }
            else
            {
                echo '<a href="' . $loginUrl . '"><img src="img/login-facebook-btn.png" alt="Login with Facebook"></a>';
            }    
            ?>
            <br />

            
            <?php
            ?>
        </div>

    </body>
</html> 
