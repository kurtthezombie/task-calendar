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
    <title>Task Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
      .btn-primary {
        background-color: #e736a9;
        border-color: #e736a9;
      }
      .btn-secondary {
        background-color: #542bf7;
        border-color: #542bf7;
      }
      .btn {
        width: 50%;
      }
      .tc-custom-pink {
        color: #e736a9;
      }
    </style>
  </head>
  <body>
    <section>
      <div class="container mt-3 pt-5">
        <div class="row">
          <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card shadow">
              <div class="card-body p-5">
                <h1 class="fw-bold mt-3 mb-5">Login</h1>
                <form action="login-process.php" method="POST">
                  <div class="mb-3">
                    <label for="" class="form-label fw-bold mt-5">EMAIL ADDRESS</label>
                    <input type="email" name="TxtEmailAdd" id="" class="form-control border-bottom border-3 my-1 border-0 py-2 rounded-0" placeholder="&#9993; Type your email address" />
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label fw-bold mt-5">PASSWORD</label>
                    <input type="password" name="TxtPassword" id="" class="form-control border-bottom border-3 my-1 border-0 py-2 rounded-0" placeholder="&#128274; Type your password" />
                  </div>
                  <div class="mb-3 text-end">
                    <a href="forgotpassword.php" class="text-decoration-none tc-custom-pink">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="BtnLogin" class="btn btn-lg btn-primary shadow-sm">Login</button>
                    <!--<p class="text-muted mt-1">or</p>-->
                  </div>
                </form>
                <div class="text-center mt-3">
                  <!--<a href="signup.php" class="btn btn-lg btn-secondary shadow-sm w-100">Sign Up</a>-->
                  <a href="signup.php" class="text-muted text-decoration-none">Don't have an account yet? <span class="text-decoration-underline">Sign Up</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
