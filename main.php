<?php

session_start();

//if there's email stay on page
if(isset($_SESSION['email'])){
    echo "<p style='color:green;'>Successfully logged in!</p>";
    echo "<h1>" .$_SESSION['email']. "</h1>";

    if(isset($_POST["logout"])){
        sesh_out();
    }
}
//if not go back to login
else {
    sesh_out();
}

function sesh_out(){
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Page</title>
    <!--<link rel="stylesheet" href="css/bootstrap.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <form action="main.php" method="POST">
            <button type="submit" name="logout" class="btn btn-large btn-danger">Logout</button>
        </form>
        
    </div>
    <!--<script src="js/bootstrap.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>


