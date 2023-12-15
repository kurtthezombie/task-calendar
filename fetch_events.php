<?php
session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    $user_id = $_SESSION['id'];
    $user_email = $_SESSION['email'];

    $conn = mysqli_connect("localhost","root","","taskcalendar");

    if(!$conn->connect_error){
        $query = "SELECT * FROM `task` WHERE `task_user_id` = '$user_id'";
        
        $result = mysqli_query($conn,$query);

        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = array(
                'id' => $row['task_id'],
                'title' => $row['task_title'],
                'start' => $row['task_startdate'],
                'end' => $row['task_duedatetime'],
                'description' => $row['task_description'],
                'status' => $row['task_status'],
                'reminder' => $row['task_reminder']
            );
        }
    } 
    else {
        die("Connection failed: " . $conn->connect_error);
    }
    echo json_encode($events);
    $conn->close();
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
