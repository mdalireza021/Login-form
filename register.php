<?php
	
	require_once 'config.php';



	$username = $email= $password =  "";

	$username_err = $email_err= $password_err =  "";

	

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		
		if (empty(trim($_POST['username']))) {
			$username_err = "Please enter a username.";

			
		} else {

			
			$sql = 'SELECT id FROM users WHERE username = ?';

			if ($stmt = $conn->prepare($sql)) {
				
				$param_username = trim($_POST['username']);


				// Bind param variable to prepares statement
				$stmt->bind_param('s', $param_username);

				
				if ($stmt->execute()) {
					
					
					$stmt->store_result();

					if ($stmt->num_rows == 1) {
						$username_err = 'This username is already taken.';

						echo '<h5>This username is already taken.</h5>';

					} else {
						$username = trim($_POST['username']);
					}
				} else {
					echo "Oops! ${$username}, something went wrong. Please try again later.";
				}

				
				$stmt->close();
			} else {

				
				$conn->close();
			}
		}




		//for email
		if(empty(trim($_POST['email'])))
		{
			$email_err="Please enter an email.";
		}
		else
		{
			$email=trim($_POST['email']);
		}


		// for password
	    if(empty(trim($_POST["password"]))){
	        $password_err = "Please enter a password.";     
	    } 
		elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "Password must have atleast 6 characters.";

			echo '<h5>Password must have atleast 6 characters.</h5>';

	    } else{
	        $password = trim($_POST["password"]);
	    }
    
	    

	    // Check input error before inserting into database

	    if (empty($username_err) &&  empty($email_err) && empty($password_err) ) {

	    	// Prepare insert statement
			$sql = 'INSERT INTO users (username,email, password) VALUES (?,?,?)';

			if ($stmt = $conn->prepare($sql)) {

				// Set parmater
				$param_username = $username;
				$param_email= $email;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Created a password

				// Bind param variable to prepares statement
				$stmt->bind_param("sss",$param_username,$param_email, $param_password);

				// Attempt to execute
				if ($stmt->execute()) {
					// Redirect to login page
					header('location: ./login.php');
					// echo "Will  redirect to login page";
				} else {
					echo "Something went wrong. Try signing in again.";
				}

				// Close statement
				$stmt->close();	
			}

			// Close connection
			$conn->close();
	    }
	}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						
					</div>
					<div class="card fat">
						<div class="card-body">
							<h3 class="card-title">Register</h3>
							<form method="post" class="my-login-validation">
								<div class="form-group">
									<label for="name">Username</label>
									<input id="name" type="text" class="form-control" name="username" required autofocus>
									<div class="invalid-feedback">
										What's your name?
									</div>
								</div>

								<div class="form-group">
									<label for="email">Email</label>
									<input id="email" type="email" class="form-control" name="email" required>
									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
										<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
										<div class="invalid-feedback">
											You must agree with our Terms and Conditions
										</div>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="login.php">Login</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2021 __ K Poxoul
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>








</body>
</html>
