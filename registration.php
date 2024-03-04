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







<!doctype html>
<html lang="en">
  <head>
  	<title>Login-Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center">
							<div class="text w-100">
								<h2>Welcome to Sign Up</h2>
								<p>Have an account before?</p>
								<a href="login.php" class="btn btn-white btn-outline-white">Sign In</a>
							</div>
			      		</div>
						<div class="login-wrap p-4 p-lg-5 order-md-last">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4" style=" font-weight: 500;">Sign Up</h3>
								</div>
								
							</div>
							<form action="registration.php" class="signup-form" method="post">
								<div class="form-group mb-3">
									<label class="label" for="name">Email</label>
									<input type="Email" class="form-control" placeholder="Email" name="email" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" class="form-control" placeholder="Password" name="password" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="name">Repeat Password</label>
									<input type="password" class="form-control" placeholder="Repeat Password" name="repeat_password" required>
								</div>
								<div class="form-group">
									<input type="submit" value="Sign Up" name="submit" class="form-control btn btn-primary submit px-3">
								</div>
							</form>
						</div>
		      		</div>
				</div>
			</div>
		</div>
	</section>
	</body>
</html>