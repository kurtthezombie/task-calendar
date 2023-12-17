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
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5 col-8">
        <div class="container mt-1 mb-3">
            <a href="admin.php" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg> Back</a>
        </div>
        <h1 class="display-4">Reports</h1>
        <div class="card mt-3 border-primary">
            <div class="card-body">
                <form action="reports.php" method="POST" class="mb-3">
                    <div class="form-group">
                        <label for="" class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter email" name="TxtEmail">
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" class="btn btn-warning" value="Search" name="BtnSearch">
                    </div>
                </form>

                <?php
                if (isset($_POST['BtnSearch'])) {
                    $var_email = $_POST['TxtEmail'];
                    $var_fname = "";
                    $conn = mysqli_connect("localhost", "root", "", "taskcalendar");
                    if (!$conn->connect_error) {
                        $query = "CALL sp_getTasksByUsers('$var_email')";
                        $records = mysqli_query($conn, $query);

                        if (mysqli_num_rows($records) > 0) {
                            $firstRow = mysqli_fetch_assoc($records);
                            $var_fname = $firstRow["user_fname"];

                            //codes here:
                            echo "<p class='display-4'>" . $var_fname . "'s tasks: </p>";
                            echo "<table border='1' class='table table-dark'>";
                            echo "		<thead>";
                            echo "			<tr>";
                            echo "				<th scope='col'>Seq#</th>";
                            echo "				<th scope='col'>Task Title</th>";
                            echo "				<th scope='col'>Task Description</th>";
                            echo "			</tr>";
                            echo "		</thead>";
                            echo "		<tbody>";

                            $sequence = 1;

                            echo "<tr>";
                            echo "    <th scope='row'>$sequence.</th>";
                            echo "    <td>" . $firstRow["task_title"] . "</td>";
                            echo "    <td>" . $firstRow["task_description"] . "</td>";
                            echo "</tr>";

                            while ($rec = mysqli_fetch_array($records)) {
                                echo "<tr>";
                                echo "		<th scope='row'>$sequence.</th>";
                                echo "		<td>" . $rec["task_title"] . "</td>";
                                echo "		<td>" . $rec["task_description"] . "</td>";
                                echo "</tr>";

                                $sequence = $sequence + 1;
                            }
                            echo "		</tbody>";
                            echo "</table>";

                            mysqli_close($conn);
                        } else {
                            echo "<p class='display-6 text-danger'>" . $var_email . " does not exist or has no tasks..</p>";
                        }
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>