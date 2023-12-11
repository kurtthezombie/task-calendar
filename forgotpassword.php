<?php 
  session_start();
  //if logged in already, redirect to main page.
  if(isset($_SESSION['email'])){
    header("Location: main.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
      .btn-primary {
        background-color: #542BF7;
      }
      .btn-secondary {
        background-color: #E830A9;
      }
      .custom-pink-bg {
        background-color: #E830A9;
      }
      .placeholder-gray::placeholder {
        color: gray;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-4 col-lg-4 col-md-6 col-sm-8 mx-auto mt-5">
          <div class="card shadow-sm">
            <div class="header custom-pink-bg">
              <p class="h3 p-3 text-white">Forgot Password</p>
            </div>
            <div class="card-body p-5">
              <form action="">
                <div class="form-group">
                  <label for="" class="form-label mb-4">Please enter the email associated with your account to receive a verification code</label>
                  <input type="email" class="form-control placeholder-gray rounded-1 border-black p-2 shadow-sm" placeholder="&#9993; Email Address*" required />
                </div>
                <div class="form-group mt-5 text-center">
                  <button class="btn btn-primary btn-lg rounded-1 w-100">Send Code</button>
                  <a href="login.php" class="btn btn-secondary btn-lg rounded-1 w-100 mt-5">Go Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
