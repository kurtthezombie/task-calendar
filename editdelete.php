<?php

session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    if (isset($_POST['BtnDelete'])) {
        $var_taskId = $_POST['TaskId'];
        $conn = mysqli_connect("localhost", "root", "", "taskcalendar");

        if (!$conn->connect_error) {
            $query = "CALL sp_deleteTask($var_taskId)";

            if (mysqli_query($conn, $query)) {
                //let it do the query
            }
        } else {
            die("Connection failed: " . $conn->connect_error);
        }
        header('Location: main.php');
        mysqli_close($conn);
    }
} else {
    sesh_out();
}

function sesh_out()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
