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

	    if (empty($username_err) &&  empty($email_err) && empty($password_err) ) {

			$sql = 'INSERT INTO users (username,email, password) VALUES (?,?,?)';

			if ($stmt = $conn->prepare($sql)) {

				$param_username = $username;
				$param_email= $email;
				$param_password = password_hash($password, PASSWORD_DEFAULT); 
				$stmt->bind_param("sss",$param_username,$param_email, $param_password);

				if ($stmt->execute())
				 {
					
					header('location: ./login.php');
					
				} else {
					echo "Something went wrong. Try signing in again.";
				}

				$stmt->close();	
			}

			$conn->close();
	    }
	}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title></title>
  </head>
  <body>
    

    <div class="card d-flex align-items-center justify-content-center" >
  
        
          <div class="login-wrapper col-10 mx-auto">
            <h1 class="login-title">Register</h1>
            <form  method="post">

                  
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="" required autofocus>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="" required autofocus>
              </div>


              <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="" required data-eye>
                <a href="#!" class="float-right">Forgot password?</a>
              </div>
              
              
              <div class="form-group">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
                  <label for="agree" class="custom-control-label"  >I agree to the <a href="#">Terms and Conditions</a></label>
                  <div class="invalid-feedback">
                    You must agree with our Terms and Conditions
                  </div>
                </div>
              </div>
              <button  id="login" class="btn btn-block login-btn" type="submit"> Register </button>
            </form>
            
            <div class="mt-4 text-center">
               Already have an account? <a href="login.php">Login</a>
            </div>
          </div>
        
        
      
  </div>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>