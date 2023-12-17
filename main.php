<?php

session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    if (isset($_POST["logout"])) {
        sesh_out();
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
        <!--MODAL FOR CREATE TASK-->
        <div class="modal fade align-items-center" id="addTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="datetime-local" id="TxtStartDate" name="TxtStartDate" class="form-control" value="">
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
                                    <option value="to-do">To-do</option>
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
        <!--MODAL FOR TASK DISPLAY-->
        <div class="modal fade align-items-center" id="taskDisplayModal" tabindex="-1" aria-labelledby="taskDisplay" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="editdelete.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="hidden" id="TaskId" name="TaskId">
                            <h3 class="modal-title text-primary" id="TaskTitle"></h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-5">
                                <label for="" class="label h5 text-muted">Description:</label>
                                <p id="TaskDescription" class="h6"></p>
                            </div>
                            <div class="row">
                                <label for="" class="label h6 text-muted">Start Date:</label>
                                <p id="StartDate" class=""></p>
                            </div>
                            <div class="row">
                                <label for="" class="label h6 text-muted">Due Date:</label>
                                <p id="EndDate" class=""></p>
                            </div>
                            <div class="row">
                                <label for="" class="col-auto label h6 text-muted">Status:</label>
                                <p id="TaskStatus" class="col fw-bold"></p>
                            </div>
                            <div class="row">
                                <label for="" class="col-auto label h6 text-muted">Reminders: </label>
                                <p id="ReminderSettings" class="col fw-bold"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-lg btn-primary" name="BtnEdit" onclick="editTaskModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </button>
                            <button type="submit" class="btn btn-lg btn-danger" data-dismiss="modal" name="BtnDelete" onclick="return confirm('Are you sure you want to delete this task?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--MODAL FOR EDIT TASK-->
        <div class="modal fade align-items-center" id="editTaskModal" tabindex="-1" aria-labelledby="taskEdit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="editdelete.php" method="POST">
                        <div class="modal-body p-5">
                            <div class="form-group">
                                <input type="hidden" id="EditTaskId" name="EditTaskId">
                                <input type="text" name="TxtEditTaskTitle" id="TxtEditTaskTitle" class="form-control border-0 border-bottom border-3 rounded-0 mb-3" placeholder="Add Title" required value="">
                                <textarea class="form-control" name="TxtEditTaskDescription" id="TxtEditTaskDescription" cols="30" rows="5" placeholder="Add description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Start Date</label>
                                <input type="datetime-local" id="TxtEditStartDate" name="TxtEditStartDate" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Due Date</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="TxtEditDueDateTime" id="TxtEditDueDateTime" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="form-label">Status</label>
                                <select name="EditCboStatus" id="EditCboStatus" class="form-control" itemid="statusDropdown">
                                    <option value="to-do">To-do</option>
                                    <option value="doing">Doing</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label for="" class="form-label">Reminder: </label>
                            <select name="EditCboReminders" id="EditCboReminders" class="form-control w-15" itemid="statusDropdown">
                                <option value="0" selected>Off</option>
                                <option value="1">On</option>
                            </select>
                            <button type="submit" class="btn btn-success w-50" name="BtnTaskSaveChanges">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div id='calendar' style="height: 100%; width: 100%;" class="border-3 border-danger"></div>
            <div class="row mt-5">
                <!--LOGOUT BUTTON-->
                <form action="main.php" method="POST" class="justify-content-end mb-5">
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