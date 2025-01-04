<?php
session_start();
//if logged in already, redirect to main page.
if (isset($_SESSION['email'])) {
  header("Location: main.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <style>
    .btn-primary {
      background-color: #e736a9;
      border-color: #e736a9;
    }

    .placeholder-gray::placeholder {
      color: gray;
    }
  </style>
</head>

<body>
  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  //declare variables for data to store in
  $var_firstname = "";
  $var_lastname = "";
  $var_email = "";
  $var_password = "";
  $var_first_password = "";
  $var_second_password = "";

  if (isset($_POST["btnCreateAcc"])) {
    //set values to vars
    $var_firstname = $_POST["TxtFirstName"];
    $var_lastname = $_POST["TxtLastName"];
    $var_email = trim($_POST["TxtEmail"]);
    $var_password = password_hash($_POST["TxtPassword"], PASSWORD_BCRYPT);
    
    $var_first_password = trim($_POST['TxtPassword']);
    $var_second_password = trim($_POST['TxtConfirmPassword']);

    //print errors
    $errors = array();

    //error trapping
    //et: first name
    if (!ctype_alpha(str_replace(' ', '', $var_firstname))) {
      $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid First Name: Please enter only letters and spaces.</p>";
    }
    //et: last name
    if (!ctype_alpha(str_replace(' ', '', $var_lastname))) {
      $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid Last Name: Please enter only letters and spaces.</p>";
    }
    //et: email address
    if (!filter_var($var_email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid Email Address: Please enter only letters and spaces.</p>";
    }
    //et: checkUnique email address
    if (!isEmailUnique($var_email)) {
      $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Somebody already owns this email address</p>";
    }
    //et: check if confirm password is correct:
    if ($var_first_password != $var_second_password) {
      $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Password do not match. Please enter matching passwords.</p>";
    }

    //et: password - none
    if (!empty($errors)) {
      //if error is not empty, print all error messages at once
      foreach ($errors as $errormessage) {
        echo $errormessage;
      }
    } else {
      //insert into the table
      $conn = mysqli_connect("localhost", "root", "", "taskcalendar");
      if (!$conn->connect_error) {
        //insert into
        $query = "INSERT INTO user_info (user_email, user_password, user_fname, user_lname) VALUES ('$var_email', '$var_password', '$var_firstname', '$var_lastname')";
        if (mysqli_query($conn, $query)) {
          echo "<p style='color:green;' class='h5 text-center mx-auto mt-1 mb-0'>Account successfully registered</p>";
          //header("Location: login.php");
          //sleep(2);
          //exit();
        } else {
          echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
      } else {
        die("Connection failed: " . $conn->connect_error);
      }
      mysqli_close($conn);
    }
  }
  //check unique
  function isEmailUnique($email)
  {
    $conn = mysqli_connect("localhost", "root", "", "taskcalendar");
    if (!$conn->connect_error) {
      $query = "SELECT * FROM user_info where `user_email` = '$email'";
      if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
        return false;
      } else {
        return true;
      }
    } else {
      die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);
  }

  ?>
  <div class="container mx-auto mt-3 pt-5">
    <div class="card w-50 mx-auto shadow">
      <a href="login.php" class="text-decoration-none h1 mx-5 mt-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z" />
        </svg>
      </a>
      <div class="card-body p-5 pt-3">
        <div class="row justify-content-center">
          <div class="">
            <h2 class="mb-5">Sign Up</h2>
            <form action="signup.php" method="POST">
              <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="firstName" name="TxtFirstName" placeholder="Enter First Name" />
              </div>
              <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="lastName" name="TxtLastName" placeholder="Enter Last Name" required />
              </div>
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="email" name="TxtEmail" placeholder="Enter Email Address" required />
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="password" name="TxtPassword" placeholder="Enter Password" required />
                <label for="password">Confirm Password:</label>
                <input type="password" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="password" name="TxtConfirmPassword" placeholder="Re-enter Password" required />
              </div>
              <div class="text-center mt-3">
                <button type="submit" class="btn btn-lg btn-primary" name="btnCreateAcc" onclick="return confirm('Are you sure you want to create this account?')">CREATE ACCOUNT</button>
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