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

    if (isset($_POST['BtnTaskSaveChanges'])) {
        $var_taskId = $_POST['EditTaskId'];
        $var_taskTitle = $_POST['TxtEditTaskTitle'];
        $var_taskdescription = $_POST['TxtEditTaskDescription'];
        $var_startdate = $_POST['TxtEditStartDate'];
        $var_duedate = $_POST['TxtEditDueDateTime'];
        $var_status = $_POST['EditCboStatus'];
        $var_reminder = $_POST['EditCboReminders'];
        $conn = mysqli_connect("localhost","root","","taskcalendar");
        if (!$conn->connect_error) {
            $query = "CALL sp_updateTask(
                $var_taskId,
                '$var_taskTitle',
                '$var_taskdescription',
                '$var_startdate',
                '$var_duedate',
                '$var_status',
                $var_reminder
                )";
            if (mysqli_query($conn, $query)) {
                //let it do the query
            }
        } else {
            die("Connection failed: " . $conn->connect_error);
        }
        header('Location: main.php');
        mysqli_close($conn);
    }

    if (isset($_POST['BtnTaskSaveChanges'])) {
        //do edit query
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
