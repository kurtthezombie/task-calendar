<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['TxtEmailAdd'];
        $password = $_POST['TxtPassword'];
        
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;


        //connect db
        $db = mysqli_connect("localhost","root","","taskcalendar");

        //if db connect, query check if account exists
        if (!$db->connect_error)
        {
            $query = "SELECT * FROM `user_info` where `user_email` = '$email' and `user_password` = '$password'";
            $result = mysqli_query($db,$query);
            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    //user exists?
                    header("Location: main.php");
                    exit(); 
                }
                else{
                    echo "<p style='color:red;'>Incorrect username and password!</p>"; 
                }
            }
            else {
                echo "<p style='color:gray;'>Something went wrong with the query...</p>";
            }
        }
        else {
            die("Connection failed: " . $db->connect_error);
        }
        mysqli_close($db);
    }
?>