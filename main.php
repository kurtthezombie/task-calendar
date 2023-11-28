<?php

session_start();

if(isset($_SESSION['email']) && isset($_SESSION['password'])){
    echo "<p style='color:green;'>Successfully logged in!</p>";
    echo "<h1>" .$_SESSION['email']. "</h1>";
    echo "<h1>" .$_SESSION['password']. "</h1>";
}
else {
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    session_destroy();
    header("Location: login.php");
}


