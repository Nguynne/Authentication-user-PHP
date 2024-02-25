<?php
    require "config.php";
    require "classes/database.php";
    require "classes/user.php";
    require "classes/fieldvalidator.php";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST["repeat_password"];
        $checkField = new FieldValidator();
        $errors = $checkField->checkRegistration($email, $password, $passwordRepeat);
        if (count($errors)>0) {
            foreach ($errors as  $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        else {
            $conn = require "inc/db.php";
            $user = new User($email, $password);
            try{
                if($user->addUser($conn)){
                    echo"<div class='alert alert-success'>Add User Successfully!</div>";
                }
                else{
                     echo"Cannot Add User!";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
                // Có thể gọi trang xử lí lỗi
                // Header('Location: error.php');
            }
        }
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <div class="container">
            <h2 style="color: black; margin-bottom: 1.5rem">Registration</h2>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Register" name="submit">
                    <p>Have an account <a style="text-decoration: none;" href="login.php">Login Now</a></p>
                </div>
            </form>
        </div>
</body>
</html>