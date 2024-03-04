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

    require "auth-providers/google/index.php";
    require "auth-providers/facebook/index.php";
                
                


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
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Welcome to Login</h2>
								<p>Don't have an account?</p>
								<a href="registration.php" class="btn btn-white btn-outline-white">Sign Up</a>
							</div>
			      		</div>
						<div class="login-wrap p-4 p-lg-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4" style="margin-top: -5px; font-weight: 500;">Sign In</h3>
								</div>
								<div class="social-media d-flex justify-content-end">
									<?php	
									if ($loginUrl == '') {
										Auth::login();
										header('Location: welcome.php');
									} else {
										echo $loginUrl;
									}
									if ($login_button == '') {
										Auth::login();
										header('Location: welcome.php');
									} else {
										echo $login_button;
									}
									?>
								</div>
							</div>
							<form action="login.php" class="signin-form" method="post">
								<div class="form-group mb-3">
									<label class="label" for="name">Email</label>
									<input type="Email" class="form-control" placeholder="Email" name="email" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" class="form-control" placeholder="Password" name="password" required>
								</div>
								<div class="form-group">
									<input type="submit" value="Login" name="login" class="form-control btn btn-primary submit px-3">
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

