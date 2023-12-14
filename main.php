<?php

session_start();

//if there's email stay on page
if(isset($_SESSION['email'])){
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
    <meta charset='utf-8' />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .bg-pink {
            background-color: #E830A9;
        }
        .w-15 {
            width: 11%;
        }
    </style>
    <title>Calendar</title>
  </head>
  <body>
    <div class="container">
    <div class="modal fade align-items-center" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-pink">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="addtask.php" method="post" id="taskForm">
                    <div class="modal-body p-5">
                        <div class="form-group">
                            <input type="text" name="TxtTaskTitle" id="TxtTaskTitle" class="form-control border-0 border-bottom border-3 rounded-0 mb-3" placeholder="Add Title" required>
                            <textarea class="form-control" name="TxtTaskDescription" id="TxtTaskDescription" cols="30" rows="5" placeholder="Add description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Start Date</label>
                            <input type="date" id="TxtStartDate" name="TxtStartDate" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Due Date</label>
                            <div class="input-group">
                                <input type="datetime-local" name="TxtDueDateTime" class="form-control" id="TxtDueDateTime">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Status</label>
                            <select name="CboStatus" id="CboStatus" class="form-control" itemid="statusDropdown">
                                <option value="todo">To-do</option>
                                <option value="doing">Doing</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <!-- SHARING FUNCTION removed
                        <div class="form-group">
                            <input type="email" id="TxtShareWith" class="form-control" placeholder="Share with...">
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <label for="" class="form-label">Reminder: </label>
                        <select name="CboReminders" id="CboReminders" class="form-control w-15" itemid="statusDropdown">
                            <option value="0">Off</option>
                            <option value="1" selected>On</option> 
                        </select>
                        <button type="submit" class="btn btn-primary w-25" name="BtnTaskSave">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div id='calendar' style="height: 80%; width: 100%;" class="border-3 border-danger"></div>
        <div class="row mt-5">
            <!--LOGOUT BUTTON-->
            <form action="main.php" method="POST" class="justify-content-end">
                <div class="form-group">
                <button type="submit" name="logout" class="btn btn-large btn-danger w-100">Logout</button>
                </div>
            </form>
        </div>
    <script src='fullcalendar-6.1.10/dist/index.global.js'></script>
    <script src="js/mainscript.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>


