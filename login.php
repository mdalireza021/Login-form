<?php

  session_start();
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: homepage.php");
    exit;
  }

  require_once "config.php";

  $username = $password = "";
  $username_err = $password_err = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(empty(trim($_POST['username']))){
      $username_err = 'Please enter username.';
    } else{
      $username = trim($_POST['username']);
    }

    if(empty(trim($_POST['password']))){
      $password_err = 'Please enter your password.';
    } else{
      $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
    
      $sql = 'SELECT id, username, password FROM users WHERE username = ?';

      if ($stmt = $conn->prepare($sql)) {

        $param_username = $username;
        $stmt->bind_param('s', $param_username);

        if ($stmt->execute()) {
          $stmt->store_result();

          if ($stmt->num_rows == 1) {
            
            $stmt->bind_result($id, $username, $hashed_password);
            if ($stmt->fetch()) {
              if (password_verify($password, $hashed_password)) {

                session_start();

                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                
                ///header('location: homepage.php');
                echo "<script>window.location.href='http://localhost/userregistration/homepage.php';</script>";
              
              
              } else {

                $password_err = 'Invalid password';

              }
            }
          } else {

            $username_err = "Username does not exists.";

          }
        } else {
          echo "Oops! Something went wrong please try again";
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
            <h1 class="login-title">Login</h1>
            <form  method="post">

                  
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="" required autofocus>
              </div>

              <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="" required data-eye>
                <a href="#!" class="float-right">Forgot password?</a>
              </div>
              
              
              <div class="form-group">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
                  <label for="agree" class="custom-control-label"  >Remember me</label>
                  
                </div>
              </div>
              <button  id="login" class="btn btn-block login-btn" type="submit"> Login </button>
            </form>
            
            <div class="mt-4 text-center">
               Don't have an account? <a href="register.php">Register here</a>
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