<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['TxtEmailAdd'];
        $password = $_POST['TxtPassword'];

        if(empty($email) || empty($password)){
            header("Location: login.php");
            exit();
        }

        //connect db
        $db = mysqli_connect("localhost","root","","taskcalendar");

        //if db connect, query check if account exists
        if (!$db->connect_error)
        {
            $query = "SELECT * FROM `user_info` where `user_email` = '$email'";
            $result = mysqli_query($db,$query);
            if($result) {
                $row = mysqli_fetch_assoc($result);
                if($row){
                    if(password_verify($password, $row['user_password'])) {
                        //Password matches, user authenticated
                        $_SESSION['id'] = $row['user_idn'];
                        $_SESSION['email'] = $email;
                        header("Location: main.php");
                        exit(); 
                    }
                    else{
                        //no user, incorrect user and password
                        echo "<h1 style='color:red;'>Incorrect username and password!</h1>";
                        echo "<a href='login.php'><h1>Go back</h1></a>";
                        exit();
                    }
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