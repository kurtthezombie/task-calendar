<?php
session_start();

if(isset($_POST['BtnTaskSave'])){
    $var_task_title = $_POST['TxtTaskTitle'];
    $var_task_description = $_POST['TxtTaskDescription'];
    $var_task_duedatetime = $_POST['TxtDueDateTime'];
    $var_task_status = $_POST['CboStatus'];
    $var_task_reminders = $_POST['CboReminders'];
    $user_id = $_SESSION['id'];
    
    $conn = mysqli_connect("localhost","root","","taskcalendar");

    if (!$conn->connect_error) {
        echo "Connected successfully";
        $query = "INSERT INTO `task` (task_title, task_description, task_duedatetime,task_status,task_reminder,task_date_created,task_user_id)
                            values ('$var_task_title','$var_task_description','$var_task_duedatetime','$var_task_status',$var_task_reminders,now(),$user_id);";
        if(mysqli_query($conn,$query)){
            echo "Task added successfullay.";
        }
        else {
            echo "Something went wrong with the query...";
        }
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_close($conn);
}
