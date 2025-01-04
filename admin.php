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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome, Admin.</h1>
            <p class="lead">Admin page of the task calendar system</p>
            <hr class="my-4" />
            <p>Options</p>
            <div class="card">
                <div class="card-body">
                    <form action="admin.php" method="post">
                        <div class="form-group">
                            <button type="submit" class="btn btn-large btn-primary" name="BtnUsers">Users</button>
                            <button type="submit" class="btn btn-large btn-warning" name="BtnReports">Reports</button>
                        </div><br>
                        <?php
                        if (isset($_POST['BtnUsers'])) {
                            header("Location: listalluser.php");
                            exit();
                        }
                        if (isset($_POST['BtnReports'])) {
                            header("Location: reports.php");
                            exit();
                        }

                        ?>
                        <div class="form-group mt-5">
                            <button class="btn btn-danger" type="submit" name="logout">Log out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>