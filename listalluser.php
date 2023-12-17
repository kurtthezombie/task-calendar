<?php

session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    //continue
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

if (isset($_POST['BtnDeleteUser'])) 
{
    $conn = mysqli_connect("localhost","root","","taskcalendar");
    $userIdToDelete = $_POST['BtnDeleteUser'];
    $query = "CALL sp_deleteUser($userIdToDelete)";
    if (mysqli_query($conn, $query)) {
        header("refresh:1");
    } else {
        echo "Deletion failed";
    }
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <title></title>
</head>

<body>
    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Users</h1>
            <p class="lead">These are the users of task calendar system</p>
            <hr class="my-4" />
            <div class="card">
                <div class="card-body">
                    <form action="listalluser.php" method="POST" name="UserDisplayForm">
                        <div class="form-group">
                            <?php
                            $conn = mysqli_connect("localhost", "root", "", "taskcalendar");

                            $query = "SELECT * FROM `user_info`";
                            $records = mysqli_query($conn, $query);

                            if (mysqli_num_rows($records) > 0) {
                                echo "<table border='1' class='table table-dark'>";
                                echo "		<thead>";
                                echo "			<tr>";
                                echo "				<th scope='col'>Seq#</th>";
                                echo "				<th scope='col'>ID</th>";
                                echo "				<th scope='col'>Email Address</th>";
                                echo "				<th scope='col'>Firstname</th>";
                                echo "				<th scope='col'>Lastname</th>";
                                echo "				<th scope='col'>Change</th>";
                                echo "				<th scope='col'>Delete</th>";
                                echo "			</tr>";
                                echo "		</thead>";
                                echo "		<tbody>";
                            }
                            $sequence = 1;
                            while ($rec = mysqli_fetch_array($records)) {
                                //use the column names from items table in the array as subscript or index
                                echo "<tr>";
                                echo "		<th scope='row'>$sequence.</th>";
                                echo "		<td>" . $rec["user_idn"] . "</td>";
                                echo "		<td>" . $rec["user_email"] . "</td>";
                                echo "		<td>" . $rec["user_fname"] . "</td>";
                                echo "		<td>" . $rec["user_lname"] . "</td>";
                                echo "		<td><a class='btn btn-info' href='edituser.php?record=" . $rec["user_idn"] . "'>Edit</a></td>";
                                echo "		<td><button type='submit' class='btn btn-outline-danger' name='BtnDeleteUser' value='" . $rec['user_idn'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'></path>
                            <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'></path>
                          </svg></button></td>";
                                echo "</tr>";

                                //add 1 to sequence variable after each record
                                $sequence = $sequence + 1;
                            }

                            echo "		</tbody>";
                            echo "</table>";

                            
                            mysqli_close($conn);
                            ?>
                            <a href="admin.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>