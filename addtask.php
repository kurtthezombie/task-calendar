<?php
session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    if (isset($_POST['BtnTaskSave'])) {
        $var_task_title = $_POST['TxtTaskTitle'];
        $var_task_description = isset($_POST['TxtTaskDescription']) ? $_POST['TxtTaskDescription'] : null;
        $var_task_startdate = $_POST['TxtStartDate'];
        $var_task_duedatetime = isset($_POST['TxtDueDateTime']) ? $_POST['TxtDueDateTime'] : null;
        $var_task_status = isset($_POST['CboStatus']) ? $_POST['CboStatus'] : null;
        $var_task_reminders = isset($_POST['CboReminders']) ? $_POST['CboReminders'] : null;
        $owner_id = $_SESSION['id'];

        $conn = mysqli_connect("localhost", "root", "", "taskcalendar");

        if (!$conn->connect_error) {
            echo "<p style='color:green;'>Connected successfully </p><br>";
            $query = "INSERT INTO `task` (task_title, task_description, task_startdate, task_duedatetime,task_status,task_reminder,task_date_created,task_user_id)
                        values ('$var_task_title','$var_task_description','$var_task_startdate','$var_task_duedatetime','$var_task_status',$var_task_reminders,NOW(),$owner_id);";
            if (mysqli_query($conn, $query)) {
                echo "Task added successfullay.";
                header("Location: main.php");
            } else {
                echo "Something went wrong with the query...";
            }
        } else {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_close($conn);
    }
}
//if not go back to login
else {
    sesh_out();
}

function sesh_out()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
