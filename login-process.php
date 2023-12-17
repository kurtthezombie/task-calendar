<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['TxtEmailAdd'];
    $password = $_POST['TxtPassword'];

    if (empty($email) || empty($password)) {
        header("Location: login.php");
        exit();
    }

    if ($email == 'a@admin.tc' && $password == 'admin') {
        $_SESSION['email'] = $email;
        header("Location: admin.php");
        exit();
    } else {
        //connect db
        $db = mysqli_connect("localhost", "root", "", "taskcalendar");


        //if db connect, query check if account exists
        if (!$db->connect_error) {
            $query = "SELECT * FROM `user_info` where `user_email` = '$email'";
            $result = mysqli_query($db, $query);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    if (password_verify($password, $row['user_password'])) {
                        //Password matches, user authenticated
                        $_SESSION['id'] = $row['user_idn'];
                        $_SESSION['email'] = $email;
                        header("Location: main.php");
                        exit();
                    } else {
                        //no user, incorrect user and password
                        $_SESSION['error_message'] = "<h5 class='text-center pt-3 pb-0 mb-0' style='color:red;'>Incorrect username and password!</h1>";
                        header("Location: login.php");
                    }
                } else {
                    $_SESSION['error_message'] = "<h5 class='text-center pt-3 pb-0 mb-0' style='color:red;'>User does not exist!</h1>";
                    header("Location: login.php");
                }
            } else {
                echo "<p style='color:gray;'>Something went wrong with the query...</p>";
            }
        } else {
            die("Connection failed: " . $db->connect_error);
        }
        mysqli_close($db);
    }
}
